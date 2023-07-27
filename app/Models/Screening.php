<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;
           /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'price',
        'advert_slots',
        'advert_duration',
        'advert_price',
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

        public function movie(){
            return $this->belongsTo(Movie::class);
        }

        public function hall(){
            return $this->belongsTo(Hall::class);
        }

        public function tags(){
            return $this->belongsToMany(Tag::class)->as('tags');;
        }

        public function tickets(){
            return $this->hasMany(Ticket::class);
        }

        public function adverts(){
            return $this->hasMany(Advert::class);
        }

    /**
     * Local Eloquent scopes
     */
}
