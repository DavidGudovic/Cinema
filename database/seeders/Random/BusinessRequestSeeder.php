<?php

namespace Database\Seeders\Random;

use App\Enums\Roles;
use App\Models\Advert;
use App\Models\Booking;
use App\Models\BusinessRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessRequestSeeder extends Seeder
{
    public function run(): void
    {
        $requests = BusinessRequest::factory()->count(3000)->make();

        $requests->each(function ($request) {
            $request->user_id = User::where('role', Roles::BUSINESS_CLIENT)->inRandomOrder()->first()->id;
            if($request->requestable_type == "App\Models\Advert") {
                $advert = Advert::factory()->create();
                $request->requestable_id = $advert->id;
                $request->price = config('settings.advertising.price') * $advert->quantity;
                $request->save();
                $advert->business_request_id = $request->id;
                $advert->save();
            } else {
                $booking = Booking::factory()->create();
                $request->requestable_id = $booking->id;
                $request->price = $booking->hall()->first()->price_per_hour * $booking->start_time->diffInHours($booking->end_time);
                $request->save();
                $booking->business_request_id = $request->id;
                $booking->save();

            }
        });
    }
}
