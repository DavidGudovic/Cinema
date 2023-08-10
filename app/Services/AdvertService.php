<?php
namespace App\Services;

use App\Models\User;
use App\Models\Advert;
use App\Models\BusinessRequest;
use Illuminate\Support\Facades\DB;

class AdvertService {

    /*
    * Create a new advert as well as a new business request, associate the two and return the advert
    */
    public function tryCreateAdvert($text, $quantity, $title, $company, $advert_url) : Advert
    {
        try {
            DB::beginTransaction();  // Make the insert atomic

            $businessRequest = BusinessRequest::make([
                'price' => $quantity * config('advertising.price'),
                'user_id' => auth()->user()->id,
                'text' => $text,
            ]);

            $advert = Advert::create([
                'quantity' => $quantity,
                'title' => $title,
                'company' => $company,
                'advert_url' => $advert_url,
            ]);

            $businessRequest->requestable()->associate($advert);
            $businessRequest->save();

            $advert->business_request_id = $businessRequest->id;
            $advert->save();

            DB::commit();  // Commit the insert

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        return $advert;

    }
}
