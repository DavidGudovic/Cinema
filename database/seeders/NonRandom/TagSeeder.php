<?php

namespace Database\Seeders\NonRandom;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $description = [
            'Doživite ultimativno kinematografsko iskustvo uz IMAX tehnologiju.',
            'Osetite svaku scenu kao da ste deo filma sa revolucionarnom 4DX tehnologijom.',
            'Osetite svaku scenu kao da ste deo filma sa revolucionarnom 4DX tehnologijom.',
            'Iskusite filmsku magiju u kristalno čistoj 4K RealD 3D rezoluciji',
        ];
        $tags = [
            ['name' => 'IMAX', 'description' => $description[0], 'image_url' => 'imax.png', 'price_addon' => 150],
            ['name' => '4DX', 'description' => $description[1], 'image_url' => '4dx.png', 'price_addon' => 200],
            ['name' => 'Dolby Atmos', 'description' => $description[2], 'image_url' => 'dolby.png', 'price_addon' => 0],
            ['name' => 'RealD 3D', 'description' => $description[3], 'image_url' => 'reald3d.png', 'price_addon' => 100],
        ];

        Tag::insert($tags);
    }
}
