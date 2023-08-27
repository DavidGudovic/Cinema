<?php

namespace App\Models;

use App\Traits\PeriodScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Screening extends Model
{
    use HasFactory, SoftDeletes, PeriodScopes;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'movie_id',
        'hall_id',
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

    public function movie()
    {
        return $this->belongsTo(Movie::class)->withTrashed();
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->as('tags');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function adverts()
    {
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

    public function scopeFromDates($query, array $dates)
    {
        return $query->whereIn(DB::raw('DATE(start_time)'), $dates);
    }

    public function scopeFromHall($query, $hallId)
    {
        return $query->where('hall_id', $hallId);
    }

    public function scopeFromHallOrManagedHalls($query, $hallId)
    {
        return match ($hallId) {
            0 => $query->whereHas('hall', function ($query) {
                $query->managedBy(auth()->user()->id);
            }),
            default => $query->fromHall($hallId)
        };
    }

    #region Screening time scopes

    public function scopeTime($query, string $screening_time)
    {
        return match ($screening_time) {
            'any' => $query->upcoming(),
            'now' => $query->Today(),
            'tomorrow' => $query->Tomorrow(),
            'week' => $query->ThisWeek(),
            default => $query,
        };
    }

    public function scopeToday($query)
    {
        return $query->where('start_time', '>', now())
            ->where('start_time', '<', now()->endOfDay());
    }

    public function scopeTomorrow($query)
    {
        return $query->where('start_time', '>', now()->addDay()->startOfDay())
            ->where('start_time', '<', now()->addDay()->endOfDay());
    }

    public function scopeThisWeek($query)
    {
        return $query->where('start_time', '>', now())
            ->where('start_time', '<', now()->addWeek()->endOfDay());
    }

    #endregion

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
        return $query->when($movieId != 0, function ($query) use ($movieId) {
            return $query->where('movie_id', $movieId);
        });
    }

    public function scopeWithTag($query, $tagName)
    {
        return $query->whereHas('tags', function ($query) use ($tagName) {
            $query->where('name', $tagName);
        });
    }

    public function scopeWithOmmitedTag($query, string $filter)
    {
        return $query->with(['tags' => function ($q) use ($filter) {
            $q->where('name', 'not like', $filter)
                ->select('name', 'image_url');
        }]);
    }

    public function scopeWithFreeAdSlots($query)
    {
        return $query->withCount('adverts')->having('adverts_count', '<', config('settings.advertising.per_screening'));
    }

    public function scopeSearch($query, string $search_query)
    {
        return $query->when($search_query, function ($query) use ($search_query) {
            return $query->where(function ($query) use ($search_query) {
                $query->whereHas('hall', function ($query) use ($search_query) {
                    $query->where('name', 'like', '%' . $search_query . '%');
                })->orWhereHas('movie', function ($query) use ($search_query) {
                    $query->where('title', 'like', '%' . $search_query . '%')
                        ->orWhere('director', 'like', '%' . $search_query . '%')
                        ->orWhereHas('genre', function ($query) use ($search_query) {
                            $query->where('name', 'like', '%' . $search_query . '%');
                        });
                })->orWhereHas('tags', function ($query) use ($search_query) {
                    $query->where('name', 'like', '%' . $search_query . '%');
                });
            });
        });
    }


    public function scopeSortOptional($query, bool $do_sort, string $sort_by, string $sort_direction)
    {
        if ($do_sort) {
            return $query->orderBy($sort_by, $sort_direction);
        }
        return $query;
    }

    public function scopePaginateOptional($query, int $quantity)
    {
        if ($quantity == 0) {
            return $query->get();
        }
        return $query->paginate($quantity);
    }
}
