<?php

namespace App\Services\Resources;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return Tag::all();
    }
}
