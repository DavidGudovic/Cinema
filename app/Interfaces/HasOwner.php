<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasOwner
{
    public function user() : belongsTo;
}

