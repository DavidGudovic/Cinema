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
    protected $fillable = [
        'first_seat_row',
        'first_seat_column',
        'seat_number',
        'price',
        'discounted',
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

    public function screening(){
        return $this->belongsTo(Screening::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
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

    public function scopeCancelled($query){
        return $query->where('soft_deleted', true);
    }
}
