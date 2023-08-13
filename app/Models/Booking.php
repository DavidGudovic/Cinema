<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Requestable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model implements Requestable //pseudo extends Models/BusinessRequest
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'start_time',
        'end_time',
        'hall_id',
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
        'start_time' => 'datetime',
    ];


    /**
    * Eloquent relationships
    */

    public function hall(){
        return $this->belongsTo(Hall::class);
    }

    //Polymorphic one to one with BusinessRequest
    public function businessRequest(){
        return $this->morphOne(BusinessRequest::class, 'requestable');
    }

    /**
    * Local Eloquent scopes
    */

    public function scopeUpcoming($query){
        return $query->where('start_time', '>', now());
    }

    public function scopePast($query){
        return $query->where('start_time', '<', now());
    }

    public function scopeOverlapsWithTime($query, $start_time, $end_time)
    {
        return $query->where('start_time', '<=', $end_time)
        ->where('end_time', '>', $start_time);
    }


    public function scopeStatus($query, $status){
        return $query->whereHas('businessRequest', function($query) use ($status){
            $query->where('status', $status);
        });
    }

    public function scopePendingOrAccepted($query){
        return $query->whereHas('businessRequest', function ($query){
           return $query->where('status', 'PENDING')->orWhere('status', 'ACCEPTED');
        });
    }

    public function scopeUser($query, $user){
        return $query->whereHas('businessRequest', function($query) use ($user){
            $query->where('user_id', $user);
        });
    }

    public function scopeHall($query, $hall){
        return $query->where('hall_id', $hall);
    }
}
