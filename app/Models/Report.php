<?php

namespace App\Models;

use App\Enums\Period;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

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
    public function scopeForPeriod($query, $period)
    {
        return $query->where('period', $period);
    }

    public function scopeFromUser($query, $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeForHall($query, $hall)
    {
        return $query->where('hall_id', $hall->id);
    }
}
