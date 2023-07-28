<?php

namespace App\Models;

use App\Interfaces\Requestable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRequest extends Model implements Requestable //pseudo superclass for Models/ Booking and Advert
{
    use HasFactory;
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
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
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
        return $this->morphTo();
    }

    /**
     * Local Eloquent scopes
     */

    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }

    public function scopeFromYear($query, $year){
        return $query->whereYear('date', $year);
    }

    public function scopeFromUser($query, $user){
        return $query->where('user_id', $user);
    }

    public function scopeIsAdvert($query){
        return $query->where('requestable_type', Advert::class);
    }

    public function scopeIsBooking($query){
        return $query->where('requestable_type', Booking::class);
    }

    public function scopeHasReclamation($query){
        return $query->whereHas('reclamation');
    }
}