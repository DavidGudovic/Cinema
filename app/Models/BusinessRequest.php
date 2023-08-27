<?php

namespace App\Models;

use App\Enums\Periods;
use App\Enums\Status;
use App\Interfaces\Requestable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessRequest extends Model implements Requestable //pseudo superclass for Models/ Booking and Advert
{
    use HasFactory, SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'status',
        'text',
        'comment',
        'price',
        'user_id'
    ];


    /**
    * Eloquent relationships
    */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reclamation(){
        return $this->hasOne(Reclamation::class);
    }

    // Polymorphic one to one with Advert and Booking
    public function requestable(){
        return $this->morphTo()->withTrashed();
    }

    /**
    * Local Eloquent scopes
    */

    #region Status scopes
    public function scopeFilterByStatus($query, $status){
        return match ($status) {
            'pending' => $query->pending(),
            'accepted' => $query->accepted(),
            'rejected' => $query->rejected(),
            'cancelled' => $query->cancelled(),
            default => $query->withTrashed(),
        };
    }

    public function scopePending($query){
        return $query->where('status', 'PENDING');
    }

    public function scopeAccepted($query){
        return $query->where('status', 'ACCEPTED');
    }

    public function scopeRejected($query){
        return $query->where('status', 'REJECTED');
    }

    public function scopeCancelled($query){
        return $query->onlyTrashed();
    }
    #endregion

    #region Type scopes
    public function scopeFilterByType($query, $type){
        return match ($type) {
            'booking' => $query->booking(),
            'advert' => $query->advert(),
            default => $query,
        };
    }

    public function scopeBooking($query){
        return $query->where('requestable_type', Booking::class);
    }

    public function scopeAdvert($query){
        return $query->where('requestable_type', Advert::class);
    }
    #endregion
    public function scopeFromMonth($query, $month){
        return $query->whereMonth('date', $month);
    }

    public function scopeFromYear($query, $year){
        return $query->whereYear('date', $year);
    }

    public function scopeFromUser($query, $user){
        return $query->where('user_id', $user);
    }

    public function scopeHasReclamation($query){
        return $query->whereHas('reclamation');
    }

  #region Period scopes
    public function scopeFromPeriod($query, Periods $period)
    {
        return match ($period) {
            Periods::YEARLY => $query->fromLastYear(),
            Periods::MONTHLY => $query->fromLastMonth(),
            Periods::WEEKLY => $query->fromLastWeek(),
        };
    }

    public function scopeFromLastYear($query)
    {
        return $query->where('created_at', '>', now()->subYear()->startOfYear())
            ->where('created_at', '<', now()->subYear()->endOfYear());
    }

    public function scopeFromLastMonth($query)
    {
        return $query->where('created_at', '>', now()->subMonth()->startOfMonth())
            ->where('created_at', '<', now()->subMonth()->endOfMonth());
    }

    public function scopeFromLastWeek($query)
    {
        return $query->where('created_at', '>', now()->subWeek()->startOfWeek())
            ->where('created_at', '<', now()->subWeek()->endOfWeek());
    }
    #end region

    public function scopeFromHallOrManagedHalls($query, $hallId)
    {
        return match ($hallId) {
            0 => $query->whereHasMorph('requestable', [Booking::class], function ($query) {
                $query->whereHas('hall', function ($query) {
                    $query->managedBy(auth()->user()->id);
                });
            }),
            default => $query->whereHasMorph('requestable', [Booking::class], function ($query) use ($hallId) {
                $query->where('hall_id', $hallId);
            })
        };
    }
}
