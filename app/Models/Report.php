<?php

namespace App\Models;

use App\Enums\Period;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $with = ['user', 'hall']; // Both relationships are needed in most use cases
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_at',
        'text',
        'period',
        'date_from',
        'PDF_path',
        'CSV_path',
        'user_id',
        'hall_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime',
        'date_from' => 'date',
        'period' => Period::class,
    ];

    /**
     * Eloquent relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    /**
     * Local Eloquent scopes
     */
    public function scopeForDatePeriod($query, $date, $period)
    {
        return $query->where('date_from', $date)->where('period', $period);
    }

    public function scopeForPeriod($query, $period)
    {
        return $query->when($period, function ($query) use ($period) {
            return $query->where('period', $period);
        });
    }

    public function scopeFromUser($query, $user)
    {
        return $query->when($user != 0, function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        });
    }

    public function scopeForHall($query, $hall_id)
    {
        return $query->when($hall_id != 0, function ($query) use ($hall_id) {
            return $query->where('hall_id', $hall_id);
        });
    }

    public function scopePaginateOptional($query, $quantity)
    {
        return $query->when($quantity > 0, function ($query) use ($quantity) {
            return $query->paginate($quantity);
        }, function ($query) {
            return $query->get();
        });
    }

    public function scopeSort($query, bool $do_sort, string $sort_by, string $sort_direction)
    {
        return $query->when($do_sort, function ($query) use ($sort_by, $sort_direction) {
            return $query->orderBy($sort_by, $sort_direction);
        });
    }

    public function scopeSearch($query, $search_query)
    {
        return $query->when($search_query, function ($query) use ($search_query) {
            $query->where('period', 'LIKE', '%' . $search_query . '%')
                ->orWhereHas('user', function ($query) use ($search_query) {
                    $query->where('name', 'LIKE', '%' . $search_query . '%');
                })
                ->orWhereHas('hall', function ($query) use ($search_query) {
                    $query->where('name', 'LIKE', '%' . $search_query . '%');
                });
        });
    }
}
