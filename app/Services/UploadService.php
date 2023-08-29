<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    /**
     *  Uploads an image to a path
     *
     * @param $image
     * @param string $path
     * @return string|bool
     */
    public function uploadImage($image, string $path): string|bool
    {
        $imageName = $image->getClientOriginalName();
        return $image->move(public_path($path), $imageName)
            ? $imageName
            : false;
    }

    /**
     * Uploads a pdf to a path
     *
     * @param PDF $pdf
     * @param string $path
     * @return string|bool
     */
    public function uploadPDF(PDF $pdf, string $path): string|bool
    {
        return Storage::put($path, $pdf->output())
            ? basename($path)
            : false;
    }
}
