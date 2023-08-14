<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
           /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'price_addon'
    ];

    /**
     * Eloquent relationships
     */

     public function screenings(){
         return $this->belongsToMany(Screening::class)->as('screenings');
     }


    /**
     * Local Eloquent scopes
     */


}
