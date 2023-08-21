<?php

namespace App\Models;

use App\Interfaces\Requestable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model implements Requestable //pseudo extends Models/BusinessRequest
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_request_id',
        'advert_url',
        'company',
        'title',
        'quantity',
        'quantity_remaining',
        'last_scheduled',
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
    public function screenings()
    {
        return $this->belongsToMany(Screening::class);
    }

    //Polymorphic one to one with BusinessRequest
    public function businessRequest()
    {
        return $this->morphOne(BusinessRequest::class, 'requestable');
    }

    /**
     * Local Eloquent scopes
     */

    public function scopeByUser($query, $user_id)
    {
        return $user_id == 0
            ? $query
            : $query
                ->whereHas('businessRequest', function ($q) use ($user_id) {
                    $q->where('user_id', $user_id);
                });
    }

    public function scopeStatus($query, $status)
    {
        return $query->whereHas('businessRequest', function ($q) use ($status) {
            $q->filterByStatus($status);
        });
    }

    public function scopeScheduled($query)
    {
        return $query->whereHas('screenings', function ($q) {
            $q->where('start_time', '>', now());
        });
    }
    #region Quantity scopes
    public function scopeQuantityRemaining($query, string $quantity)
    {
        return match($quantity) {
            'done' => $query->done(),
            'in_progress' => $query->inProgress(),
            'never_shown' => $query->neverScheduled(),
            default => $query,
        };
    }
    public function scopeNeverScheduled($query)
    {
        return $query->whereColumn('quantity', 'quantity_remaining');
    }
    public function scopeDone($query)
    {
        return $query->where('quantity_remaining', '=', 0);
    }
    public function scopeInProgress($query){
        return $query->where('quantity_remaining', '>', 0)
            ->where('quantity_remaining', '<', 'quantity');
    }
    public function scopeHasRemaining($query)
    {
        return $query->where('quantity_remaining', '>', 0);
    }
    #endregion

    public function scopeSearch($query, string $search_query)
    {
        return $search_query == ''
            ? $query
            : $query
                ->where('title', 'LIKE', "%$search_query%")
                ->orWhere('company', 'LIKE', "%$search_query%");
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
                        Advert::select($sort_by)
                            ->from($sort_relation)  // rtrim('business_requests') = 'business_request'
                            ->whereColumn('adverts.' . rtrim($sort_relation, 's') . '_id', $sort_relation . '.id')
                            ->limit(1),
                        $sort_direction
                    );
                })
            : $query;
    }

    public function scopePaginateOptionally($query, int $quantity)
    {
        return $quantity == 0
            ? $query->get()
            : $query->paginate($quantity);
    }
}
