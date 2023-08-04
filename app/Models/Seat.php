<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes;


    public $timestamps = false;


    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'ticket_id',
        'row',
        'column'
    ];


    /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */


    /*
    Accessors
    */

    /**
    * Eloquent relationships
    */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    /**
    * Local Eloquent scopes
    */
    public function scopeInScreening($query, Screening $screening)
    {
        return $query->whereHas('ticket', function ($query) use ($screening) {
            $query->where('screening_id', $screening->id);
        });
    }
}
