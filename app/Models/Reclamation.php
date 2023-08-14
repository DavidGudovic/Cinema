<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reclamation extends Model
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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function businessRequest(){
        return $this->belongsTo(BusinessRequest::class)->withTrashed();
    }

    /**
     * Local Eloquent scopes
     */

    #region Status scopes
    public function scopeFilterByStatus($query, $status){
        switch($status){
            case 'pending':
            return $query->pending();
            case 'accepted':
            return $query->accepted();
            case 'rejected':
            return $query->rejected();
            default:
            return $query;
        }
    }

    public function scopePending($query){
        return $query->where('status', 'PENDING');
    }

    public function scopeAccepted($query){
        return $query->where('status', 'ACCEPTED');
    }

    public function scopeRejected($query){
        return $query->where('status', 'REJECTED');
    }

    #region Type scopes

    public function scopeFilterByType($query, $type){
        switch($type){
            case 'advert':
            return $query->forAdvert();
            case 'booking':
            return $query->forBooking();
            default:
            return $query;
        }
    }

    public function scopeForAdvert($query){
        return $query->whereHas('businessRequest', function($q){
            $q->where('requestable_type', Advert::class);
        });
    }

    public function scopeForBooking($query){
        return $query->whereHas('businessRequest', function($q){
            $q->where('requestable_type', Booking::class);
        });
    }

    public function scopeFromUser($query, $user){
        return $query->where('user_id', $user);
    }
}
