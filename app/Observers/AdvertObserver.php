<?php

namespace App\Observers;

use App\Models\Advert;

class AdvertObserver
{
    public function creating(Advert $advert): void
    {
        $advert->quantity_remaining = $advert->quantity;
    }
}
