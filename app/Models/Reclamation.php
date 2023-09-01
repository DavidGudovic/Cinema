<?php

namespace App\Models;

use App\Interfaces\HasOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reclamation extends Model implements HasOwner
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $with = ['businessRequest']; //eager load requestable model always needed

    protected $fillable = [
        'status',
        'text',
        'comment',
        'user_id',
        'business_request_id'
    ];


    /**
     * Eloquent relationships
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function businessRequest()
    {
        return $this->belongsTo(BusinessRequest::class)->withTrashed();
    }

    /**
     * Local Eloquent scopes
     */

    #region Status scopes
    public function scopeFilterByStatus($query, $status)
    {
        return match ($status) {
            'pending' => $query->pending(),
            'accepted' => $query->accepted(),
            'rejected' => $query->rejected(),
            default => $query,
        };
    }

    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'ACCEPTED');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'REJECTED');
    }

    #region Type scopes

    public function scopeFilterByType($query, $type)
    {
        return match ($type) {
            'advert' => $query->forAdvert(),
            'booking' => $query->forBooking(),
            default => $query,
        };
    }

    public function scopeForAdvert($query)
    {
        return $query->whereHas('businessRequest', function ($q) {
            $q->where('requestable_type', Advert::class);
        });
    }

    public function scopeForBooking($query)
    {
        return $query->whereHas('businessRequest', function ($q) {
            $q->where('requestable_type', Booking::class);
        });
    }

    public function scopeFromUser($query, $user)
    {
        return $query->when($user, function ($query) use ($user) {
            return $query->where('user_id', $user);
        });
    }

    public function scopePaginateOptional($query, $paginate)
    {
        return $query->when($paginate != 0, function ($query) use ($paginate) {
            return $query->paginate($paginate);
        }, function ($query) {
            return $query->get();
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            return $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
                $q->orWhere('email', 'like', '%' . $search . '%');
                $q->orWhere('username', 'like', '%' . $search . '%');
                $q->orWhere('id', (int)$search);
            })->orWhereHas('businessRequest', function ($q) use ($search) {
                $q->where('status', 'like', '%' . $search . '%');
                $q->orWhere('requestable_id', 'like', '%' . $search . '%');
                $q->orWhere('id', (int)$search);
            });
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
                        Reclamation::select($sort_by)
                            ->from($sort_relation)  // rtrim('business_requests') = 'business_request'
                            ->whereColumn('reclamations.' . rtrim($sort_relation, 's') . '_id', $sort_relation . '.id')
                            ->limit(1),
                        $sort_direction
                    );
                })
            : $query;
    }
}
