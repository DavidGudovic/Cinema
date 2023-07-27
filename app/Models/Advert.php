<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Requestable;

class Advert extends Model implements Requestable //pseudo extends Models/BusinessRequest
{
    use HasFactory;

    public $timestamps = false;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'screening_id',
        'business_request_id',
        'advert_url',
        'slot_number'
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
    public function screening(){
        return $this->belongsTo(Screening::class);
    }

    //Polymorphic one to one with BusinessRequest
    public function businessRequest(){
        return $this->morphOne(BusinessRequest::class, 'requestable');
    }

    /**
    * Local Eloquent scopes
    */

    public function scopeForScreening($query, $screening_id){
        return $query->where('screening_id', $screening_id);
    }

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
}
