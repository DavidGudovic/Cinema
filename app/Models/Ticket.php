<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */

    protected static function booted()
    {
        // Soft delete all associated seats when the ticket is soft deleted
        static::deleted(function ($ticket) {
            $ticket->seats()->delete();
        });
    }

    protected $fillable = [
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

    /*
    Accessors
    */
    public function getTechnologyPriceAddonAttribute(){
        return $this->screening->tags->sum('price_addon');
    }

    public function getLongMovieAddonAttribute(){
        return $this->screening->movie->duration > config('pricing.long_movie_duration') ? config('pricing.long_movie_addon') : 0;
    }
    public function getSubtotalAttribute(){
        return (config('pricing.base_price') + $this->technology_price_addon + $this->long_movie_addon)
        * $this->seats->count();
    }

    public function getDiscountAttribute(){
        return $this->seats->count() > config('pricing.seat_discount_threshold') ? $this->subtotal * config('pricing.seat_discount') : 0;
    }

    public function getIsDiscountedAttribute(){
        return $this->discount > 0;
    }

    public function getTotalAttribute(){
        return $this->subtotal - $this->discount;
    }
    /**
    * Eloquent relationships
    */

    public function screening(){
        return $this->belongsTo(Screening::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function seats(){
        return $this->hasMany(Seat::class);
    }

    /*
    * Local Eloquent scopes
    */

    public function scopeDiscounted($query){
        return $query->where('discounted', true);
    }

    public function scopeActive($query){
        return $query->whereHas('screening', function($query){
            $query->upcoming();
        });
    }

    public function scopeInactive($query){
        return $query->whereHas('screening', function($query){
            $query->past();
        });
    }

    public function scopeForMovie($query, $movie){
        return $query->whereHas('screening', function($query) use ($movie){
            $query->where('movie_id', $movie);
        });
    }

    public function scopeForScreening($query, $screening){
        return $query->where('screening_id', $screening->id);
    }
}
