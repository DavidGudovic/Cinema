<?php

namespace App\Models;

use App\Enums\Period;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;
           /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'text',
        'duration'
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
        'duration' => Period::class,
    ];


    /**
     * Eloquent relationships
     */

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Local Eloquent scopes
     */

    public function scopeDuration($query, $duration){
        return $query->where('duration', $duration);
    }

    public function scopeFromYear($query, $year){
        return $query->whereYear('date', $year);
    }

    public function scopeFromMonth($query, $month){
        return $query->whereMonth('date', $month);
    }

    public function scopeByUser($query, $user){
        return $query->where('user_id', $user->id);
    }

}
