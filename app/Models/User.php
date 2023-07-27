<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use app\Enums\Role;

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
        'last_name',
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
        'role' => Role::class,
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

}
