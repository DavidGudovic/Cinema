<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'rows',
        'columns',
        'image_url',
        'price_per_hour',
        'user_id'
    ];

    /**
     * Eloquent relationships
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Local Eloquent scopes
     */

    public function scopePriceLargerThan($query, $price)
    {
        return $query->where('price_per_hour', '>', $price);
    }

    public function scopePriceSmallerThan($query, $price)
    {
        return $query->where('price_per_hour', '<', $price);
    }

    public function scopeHasUpcomingScreenings($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now());
        });
    }

    public function scopeHasBookings($query)
    {
        return $query->whereHas('bookings');
    }

    public function scopeManagedBy($query, $user_id)
    {
        return $query->when($user_id != 0, function ($query) use ($user_id) {
            return $query->where('user_id', $user_id);
        });
    }

    public function scopeAvailableAtTime($query, $start_time, $end_time)
    {
        return $query->whereDoesntHave('bookings', function ($q) use ($start_time, $end_time) {
            $q->pendingOrAccepted()
                ->where('start_time', '<=', $end_time)
                ->where('start_time' + 'duration', '>=', $start_time);
        })->whereDoesntHave('screenings', function ($q) use ($start_time, $end_time) {
            $q->where('start_time', '<=', $end_time)
                ->where('start_time' + 'duration', '>=', $start_time);
        });
    }
}
