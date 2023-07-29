<?php
namespace App\Services;

use App\Models\Tag;

class TagService{
    public function getTags(){
        return Tag::all();
    }
}
