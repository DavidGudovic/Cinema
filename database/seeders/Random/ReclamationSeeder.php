<?php

namespace Database\Seeders\Random;

use App\Models\BusinessRequest;
use App\Models\Reclamation;
use Illuminate\Database\Seeder;

class ReclamationSeeder extends Seeder
{
    public function run(): void
    {
        $requests = BusinessRequest::inRandomOrder()->limit(20)->get();

        $requests->each(function ($request) {
            $reclamation = Reclamation::factory()->make();
            $reclamation->user_id = $request->user_id;
            $reclamation->business_request_id = $request->id;
            $reclamation->save();
        });
    }
}
