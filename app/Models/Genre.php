<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;
               /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image_url',
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

    public function movies(){
        return $this->hasMany(Movie::class);
    }

    /**
     * Local Eloquent scopes
     */
    public function scopeHasMovieScreeningsUpcoming($query){
        return $query->whereHas('movies.screenings', function($query){
            $query->upcoming();
        });
    }
}
