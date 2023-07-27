<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\Requestable;

class Booking extends Model implements Requestable //pseudo extends Models/BusinessRequest
{
    use HasFactory;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'duration',
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
}
