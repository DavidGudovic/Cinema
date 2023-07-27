<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'release_date',
        'duration',
        'genre_id'
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
        'release_date' => 'datetime',
    ];


    /**
    * Eloquent relationships
    */

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function screenings(){
        return $this->hasMany(Screening::class);
    }

    /**
    * Local Eloquent scopes
    */

    public function scopeDurationLongerThan($query, $duration){
        return $query->where('duration', '>', $duration);
    }

    public function scopeDurationShorterThan($query, $duration){
        return $query->where('duration', '<', $duration);
    }

    public function scopeFromYear($query, $year){
        return $query->whereYear('release_date', $year);
    }

    public function scopeBeforeYear($query, $year){
        return $query->whereYear('release_date', '<', $year);
    }

    public function scopeAfterYear($query, $year){
        return $query->whereYear('release_date', '>', $year);
    }

    public function scopeFromGenre($query, $genre){
        return $query->where('genre_id', $genre);
    }

    public function scopeHasScreenings($query){
        return $query->whereHas('screenings', function($q){
            $q->where('date', '>', now());
        });
    }

    public function scopeHasNoScreenings($query){
        return $query->whereDoesntHave('screenings', function($q){
            $q->where('date', '>', now());
        });
    }

    public function scopeScreeningToday($query){
        return $query->whereHas('screenings', function($q){
            $q->where('date', '>', now()->startOfDay())
            ->where('date', '<', now()->endOfDay());
        });
    }

}
