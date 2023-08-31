<?php

namespace App\Models;

use App\Traits\Scopes\PeriodScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Booking extends Model //pseudo extends Models/BusinessRequest
{
    use HasFactory, SoftDeletes, PeriodScopes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'hall_id',
        'business_request_id'
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


    /**
     * Eloquent relationships
     */

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    //Polymorphic one to one with BusinessRequest
    public function businessRequest()
    {
        return $this->morphOne(BusinessRequest::class, 'requestable');
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

    public function scopeOverlapsWithTime($query, $start_time, $end_time)
    {
        return $query->where('start_time', '<=', $end_time)
            ->where('end_time', '>', $start_time);
    }

    public function scopeFromDates($query, array $dates)
    {
        return $query->whereIn(DB::raw('DATE(start_time)'), $dates);
    }

    public function scopeStatus($query, $status)
    {
        return $query->whereHas('businessRequest', function ($q) use ($status) {
            $q->filterByStatus($status);
        });
    }

    public function scopePendingOrAccepted($query)
    {
        return $query->whereHas('businessRequest', function ($query) {
            return $query->where('status', 'PENDING')->orWhere('status', 'ACCEPTED');
        });
    }

    public function scopeUser($query, $user)
    {
        return $query->when($user != 0, function ($query) use ($user) {
            return $query->whereHas('businessRequest', function ($query) use ($user) {
                $query->where('user_id', $user);
            });
        });
    }

    public function scopeHall($query, $hall)
    {
        return $query->where('hall_id', $hall);
    }

    public function scopePaginateOptionally($query, $quantity)
    {
        return $quantity > 0 ? $query->paginate($quantity) : $query->get();
    }

    public function scopeSearch($query, $search_query)
    {
        return $query->when($search_query !== '', function ($q) use ($search_query) {
            return $q->whereHas('hall', function ($q) use ($search_query) {
                $q->where('name', 'LIKE', '%' . $search_query . '%');
            });
        });
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
    public function scopeFromHall($query, $hallId)
    {
        return $query->where('hall_id', $hallId);
    }

    public function scopeFromHalls($query, array $halls)
    {
        return $query->when(count($halls) > 0, function ($q) use ($halls) {
            return $q->whereIn('hall_id', $halls);
        });
    }

    public function scopeSortPolymorphic($query, bool $do_sort, string $type, string $sort_relation, string $sort_by, string $sort_direction)
    {
        return $do_sort
            ? $query
                ->when($type === 'direct', function ($q) use ($sort_by, $sort_direction) {
                    return $q->orderBy($sort_by, $sort_direction);
                })
                ->when($type === 'relation', function ($q) use ($sort_relation, $sort_by, $sort_direction) {
                    return $q->orderBy(
                        Booking::select($sort_by)
                            ->from($sort_relation)  // rtrim('halls') = 'hall'
                            ->whereColumn('bookings.' . rtrim($sort_relation, 's') . '_id', $sort_relation . '.id')
                            ->limit(1),
                        $sort_direction
                    );
                })
            : $query;
    }
}
