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
            $screening->end_time = $this->start_time->addMinutes(config('advertising.duration') * config('advertising.per_screening') + $screening->movie->duration);
        });
    }


    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'start_time',
        'end_time',
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
        'end_time' => 'datetime'
    ];

    /*
    Accessors
    */


    public function getHumanDateAttribute()
    {
        return $this->start_time->format('d/m');
    }

    public function getHumanTimeAttribute()
    {
        return $this->start_time->format('H:i');
    }

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

    public function scopeOverlapsWithTime($query, $start_time, $end_time)
    {
        return $query->where('start_time', '<=', $end_time)
        ->where('end_time', '>', $start_time);
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
    // TODO: Figure out is this supposed to be a scope here or something else.
    public function scopeWithOmmitedTag($query,string $filter)
    {
        return $query->with(['tags' => function ($q) use ($filter){
            $q->where('name', 'not like', $filter)
            ->select('image_url');
        }]);
    }
}
