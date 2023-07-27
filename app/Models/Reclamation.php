<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reclamation extends Model
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
        'user_id',
        'business_request_id'
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
        'status' => Status::class,
    ];


    /**
     * Eloquent relationships
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function businessRequest(){
        return $this->belongsTo(BusinessRequest::class);
    }

    /**
     * Local Eloquent scopes
     */

    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }

    public function scopeForAdvert($query){
        return $query->whereHas('businessRequest', function($q){
            $q->where('requestable_type', Advert::class);
        });
    }

    public function scopeForBooking($query){
        return $query->whereHas('businessRequest', function($q){
            $q->where('requestable_type', Booking::class);
        });
    }

    public function scopeFromUser($query, $user){
        return $query->where('user_id', $user->id);
    }
}
