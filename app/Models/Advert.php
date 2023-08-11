<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Requestable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model implements Requestable //pseudo extends Models/BusinessRequest
{
    use HasFactory,SoftDeletes;

    protected static function booted(){
        static::creating(function ($advert) {
            $advert->quantity_remaining = $advert->quantity;
        });
    }

    public $timestamps = false;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'business_request_id',
        'advert_url',
        'company',
        'title',
        'quantity',
        'quantity_remaining',
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
    public function screenings(){
        return $this->belongsToMany(Screening::class);
    }

    //Polymorphic one to one with BusinessRequest
    public function businessRequest(){
        return $this->morphOne(BusinessRequest::class, 'requestable');
    }

    /**
    * Local Eloquent scopes
    */

    public function scopeByUser($query, $user_id){
        return $query->whereHas('businessRequest', function($q) use ($user_id){
            $q->where('user_id', $user_id);
        });
    }

    public function scopeStatus($query, $status){
        return $query->whereHas('businessRequest', function($q) use ($status){
            $q->where('status', $status);
        });
    }

    public function scopeScheduled($query){
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now());
        });
    }
}
