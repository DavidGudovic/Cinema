<?php

namespace App\Services;

use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Uploads a pdf to a path
     *
     * @param PDF $pdf
     * @param string $path
     * @return string
     */
    public function uploadPDF(PDF $pdf, string $path): string
    {
        Storage::put($path, $pdf->output());
        return $path . '.pdf';
    }
}
