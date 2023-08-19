<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;
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
        'trailer_url',
        'duration',
        'genre_id',
        'director',
        'banner_url',
        'is_showcased'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'datetime',
    ];

    /*
    * Accessors
    */
    public function getReleaseYearAttribute()
    {
        return $this->release_date->format('Y');
    }

    /**
     * Eloquent relationships
     */

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    /**
     * Local Eloquent scopes
     */

    public function scopeShowcased($query)
    {
        return $query->where('is_showcased', true);
    }

    protected function scopeFromGenres($query, array $genres = NULL)
    {
        return $query->when($genres, function ($query, $genres) {
            return $query->whereHas('genre', function ($query) use ($genres) {
                $query->whereIn('id', $genres);
            });
        });
    }

    #region Screening time scopes

    public function scopeScreeningTime($query, string $screening_time)
    {
        return match ($screening_time) {
            'now' => $query->screeningToday(),
            'tomorrow' => $query->screeningTomorrow(),
            'week' => $query->screeningThisWeek(),
            'with past' => $query,
            default => $query->hasScreenings(),
        };
    }

    public function scopeHasScreenings($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now());
        });
    }

    public function scopeScreeningToday($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now())
                ->where('start_time', '<', now()->endOfDay());
        });
    }

    public function scopeScreeningTomorrow($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now()->addDay()->startOfDay())
                ->where('start_time', '<', now()->addDay()->endOfDay());
        });
    }

    public function scopeScreeningThisWeek($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now())
                ->where('start_time', '<', now()->addWeek()->endOfDay());
        });
    }

    #endregion

    public function scopePaginateOptional($query, bool $paginate, int $quantity)
    {
        return $query->when($paginate, function ($query) use ($quantity) {
            return $query->paginate($quantity);
        }, function ($query) {
            return $query->get();
        });
    }

    public function scopeSortOptional($query, bool $do_sort, string $sort_by, string $sort_direction)
    {
        return $query->when($do_sort, function ($query) use ($sort_by, $sort_direction) {
            return $query->orderBy($sort_by, $sort_direction);
        });
    }

    public function scopeSearch($query, $search_query)
    {
        $search_query = join("%", explode(" ", $search_query));
        return $query
            ->where('title', 'LIKE', '%' . $search_query . '%')
            ->orWhere('director', 'LIKE', '%' . $search_query . '%')
            ->orWhereHas('genre', function ($query) use ($search_query) {
                $query->where('name', 'LIKE', '%' . $search_query . '%');
            });
    }
}
