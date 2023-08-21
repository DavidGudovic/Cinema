<?php

namespace Database\Seeders\NonRandom;

use App\Models\Hall;
use Illuminate\Database\Seeder;

class HallSeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'Sala "Scorsese" pruža vrhunski filmski doživljaj sa najmodernijom tehnologijom i udobnim sedištima. Opuštajuća atmosfera i kristalno čist zvuk učiniće svaku projekciju nezaboravnim iskustvom.',
            'Doživite magiju filma u našoj prostranoj bioskopskoj sali, opremljenoj najnovijom 3D tehnologijom i surround zvučnim sistemom. Posetite nas i uživajte u jedinstvenom filmskom iskustvu.',
            'Naša moderna bioskopska sala dizajnirana je da pruži neponovljivo iskustvo gledanja, sa visokokvalitetnom slikom i zvukom. Udobna sedišta i vrhunska usluga čine svaku posetu posebnom',
            'Posetite naš bioskop i uronite u svet filma u sali koja je opremljena najnovijom tehnologijom i pruža neuporedivo iskustvo. Od savršeno podešene temperature do luksuznih sedišta, svaki detalj je pažljivo osmišljen za Vaš užitak.',
        ];

        $halls = [
            ['name' => 'Scorsese', 'description' => $descriptions[0], 'rows' => 10, 'columns' => 12, 'image_url' => 'sala_1.webp', 'price_per_hour' => 11000, 'user_id' => 1],
            ['name' => 'Kubrick', 'description' => $descriptions[1], 'rows' => 8 , 'columns' => 10, 'image_url' => 'sala_2.webp', 'price_per_hour' => 11000, 'user_id' => 1],
            ['name' => 'Nolan', 'description' => $descriptions[2], 'rows' => 8 , 'columns' => 8 , 'image_url' => 'sala_3.webp', 'price_per_hour' => 11000, 'user_id' => 1],
            ['name' => 'Tarantino', 'description' => $descriptions[3], 'rows' => 8 , 'columns' => 10, 'image_url' => 'sala_4.webp', 'price_per_hour' => 11000, 'user_id' => 1],
        ];

        Hall::insert($halls);
    }
}
