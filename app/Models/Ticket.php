<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected static function booted()
    {
        // Soft delete all associated seats when the ticket is soft deleted
        static::deleted(function ($ticket) {
            $ticket->seats()->delete();
            $ticket->seat_count = 0;
            $ticket->save();
        });

        static::creating(function ($ticket) {
            $ticket->technology_price_addon = $ticket->calc_technology_price_addon;
            $ticket->long_movie_addon = $ticket->calc_long_movie_addon;
            $ticket->subtotal = $ticket->calc_subtotal;
            $ticket->discount = $ticket->calc_discount;
            $ticket->total = $ticket->calc_total;
            $ticket->seat_count = $ticket->seats->count();
        });
    }

    protected $fillable = [
        'screening_id',
        'user_id',
        'technology_price_addon',
        'long_movie_addon',
        'subtotal',
        'discount',
        'total',
        'seat_count',
    ];

    /*
    Accessors
    */
    public function getCalcTechnologyPriceAddonAttribute(){
        return $this->screening->tags->sum('price_addon');
    }

    public function getCalcLongMovieAddonAttribute(){
        return $this->screening->movie->duration > config('settings.pricing.long_movie_duration') ? config('settings.pricing.long_movie_addon') : 0;
    }
    public function getCalcSubtotalAttribute(){
        return (config('settings.pricing.base_price') + $this->calc_technology_price_addon + $this->calc_long_movie_addon)
        * $this->seats->count();
    }

    public function getCalcDiscountAttribute(){
        return $this->seats->count() >= config('settings.pricing.seat_discount_threshold') ? $this->calc_subtotal * config('settings.pricing.seat_discount') : 0;
    }

    public function getIsDiscountedAttribute(){
        return $this->calc_discount > 0;
    }

    public function getCalcTotalAttribute(){
        return $this->calc_subtotal - $this->calc_discount;
    }
    /**
    * Eloquent relationships
    */

    public function screening(){
        return $this->belongsTo(Screening::class)->withTrashed();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }

    /*
    * Local Eloquent scopes
    */


    #region Status Filters
    public function scopeActive($query){
        return $query->whereHas('screening', function($query){
            $query->upcoming();
        });
    }

    public function scopeInactive($query){
        return $query->whereHas('screening', function($query){
            $query->past();
        });
    }

    public function scopeFilterByStatus($query, $status){
        return match ($status) {
            'active' => $query->active(),
            'inactive' => $query->inactive(),
            'cancelled' => $query->onlyTrashed(),
            default => $query->withTrashed(),
        };
    }
    #endregion

    public function scopeForMovie($query, $movie){
        return $query->whereHas('screening', function($query) use ($movie){
            $query->where('movie_id', $movie);
        });
    }

    public function scopeForScreening($query, $screening){
        return $query->where('screening_id', $screening->id);
    }

    public function scopeForUser($query, $user){
        return $query->where('user_id', $user->id);
    }


    public function scopeFilterByMovie($query, $movie)
    {
        return $movie != 0 ? $query->forMovie($movie) : $query;
    }
}
