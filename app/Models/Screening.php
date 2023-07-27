<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($screening) {
            $screening->duration = ceil(($screening->advert_slots * $this->advert_duration + $this->movie->duration)/ 60) * 60;
        });

        static::updating(function ($screening) {
            $screening->duration = ceil(($this->advert_slots * $this->advert_duration + $this->movie->duration)/ 60) * 60;
        });
    }


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
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', now());
    }

    public function scopeFromHall($query, $hallId)
    {
        return $query->where('hall_id', $hallId);
    }

    public function scopeScreeningGenre($query, $genreId)
    {
        return $query->whereHas('movie', function ($query) use ($genreId) {
            $query->whereHas('genres', function ($query) use ($genreId) {
                $query->where('id', $genreId);
            });
        });
    }

    public function scopeScreeningMovie($query, $movieId)
    {
        return $query->where('movie_id', $movieId);
    }

    public function scopeWithTag($query, $tagName)
    {
        return $query->whereHas('tags', function ($query) use ($tagName) {
            $query->where('name', $tagName);
        });
    }

    public function scopeWithAdverts($query)
    {
        return $query->whereHas('adverts');
    }
}
