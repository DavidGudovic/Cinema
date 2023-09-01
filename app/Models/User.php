<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\Roles;
use app\Enums\Status;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',

    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => Roles::class,
    ];


    /**
    * Eloquent relationships
    */

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function business_requests(){
        return $this->hasMany(BusinessRequest::class);
    }

    public function halls(){
        return $this->hasMany(Hall::class);
    }

    public function reclamations(){
        return $this->hasMany(Reclamation::class);
    }

    public function report(){
        return $this->hasOne(Report::class);
    }

    /**
    * Local Eloquent scopes
    */

    public function scopeFilterVerified($query, $is_verified){
        return match($is_verified){
            'verified' => $query->verified(),
            'unverified' => $query->unverified(),
            default => $query,
        };
    }
    public function scopeUnverified($query){
        return $query->where('email_verified_at', null);
    }

    public function scopeVerified($query){
        return $query->where('email_verified_at', '!=', null);
    }

    public function scopeIsRole($query, $role){
        return $query->when($role, function ($query) use ($role) {
            return $query->where('role', $role);
        });
    }

    public function scopeHasTicketsForScreening($query, $screening_id){
        return $query->whereHas('tickets', function($q) use ($screening_id){
            $q->where('screening_id', $screening_id);
        });
    }

    public function scopeHasTicketsForMovie($query, $movie_id){
        return $query->whereHas('tickets', function($q) use ($movie_id){
            $q->whereHas('screening', function($q) use ($movie_id){
                $q->where('movie_id', $movie_id);
            });
        });
    }

    public function scopeHasTicketsForHall($query, $hall_id){
        return $query->whereHas('tickets', function($q) use ($hall_id){
            $q->whereHas('screening', function($q) use ($hall_id){
                $q->where('hall_id', $hall_id);
            });
        });
    }

    public function scopeHasUnresolvedRequests($query){
        return $query->whereHas('business_requests', function($q){
            $q->where('status', '=', Status::PENDING);
        });
    }

    public function scopeHasUnresolvedReclamations($query){
        return $query->whereHas('reclamations', function($q){
            $q->where('status', '=', Status::PENDING);
        });
    }

    public function scopeSort($query,$do_sort, $sort_by, $sort_direction){
        return $query->when($do_sort, function ($query) use ($sort_by, $sort_direction) {
            return $query->orderBy($sort_by, $sort_direction);
        });
    }

    public function scopeSearch($query, $search_query){
        return $query->when($search_query, function ($query) use ($search_query) {
            return $query->where('name', 'LIKE', "%{$search_query}%")
                ->orWhere('username', 'LIKE', "%{$search_query}%")
                ->orWhere('email', 'LIKE', "%{$search_query}%")
                ->orWhere('role', 'LIKE', "%{$search_query}%")
                ->orWhere('id', '=', $search_query);
        });
    }

    public function scopeWithoutSystemAccount($query){
        return $query->where('username', '!=', 'SYSTEM');
    }

    public function scopePaginateOptionally($query, $paginate_quantity){
        return $query->when($paginate_quantity, function ($query) use ($paginate_quantity) {
            return $query->paginate($paginate_quantity);
        }, function ($query) {
            return $query->get();
        });
    }

}
