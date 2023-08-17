<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
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
        'end_time',
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


    public function getHumanDateAttribute(): string
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
        return $this->belongsToMany(Tag::class)->as('tags');
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function adverts(){
        return $this->belongsToMany(Advert::class)->as('adverts');
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

    public function scopePastForDays($query, $quantity)
    {
        return $query->where('start_time', '>=', now()->subDays($quantity))
        ->where('start_time', '<', now());
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

    public function scopeWithOmmitedTag($query,string $filter)
    {
        return $query->with(['tags' => function ($q) use ($filter){
            $q->where('name', 'not like', $filter)
            ->select('image_url');
        }]);
    }

    public function scopeWithFreeAdSlots($query)
    {
        return $query->withCount('adverts')->having('adverts_count', '<', config('advertising.per_screening'));
    }

}
