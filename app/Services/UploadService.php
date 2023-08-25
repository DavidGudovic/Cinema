<?php

namespace App\Services;

class UploadService
{
    /**
     * @param $image
     * @param string $path
     * @return string
     * Uploads an image to a path
     */
    public function uploadImage($image, string $path): string
    {
        $imageName = $image->getClientOriginalName();
        $image->move(public_path($path), $imageName);
        return $imageName;
    }
}
