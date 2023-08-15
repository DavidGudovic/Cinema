<?php

namespace Database\Seeders\NonRandom;

use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'Klovn svoj mali grad okreće naopačke zaraznim smehom i nekonvencionalnim načinima rešavanja problema, sve uz pomoć svog magičnog kišobrana',
            'Hrabri fotograf se upušta u neistražene močvare, hvatajući sirovu lepotu i borbu za preživljavanje unutar ekosistema.',
            'Dokumentarac "Eho Gneva" beleži  borbu aktivista, strast i hrabrost dok oni navigiraju kroz zapetljane puteve političkog aktivizma, pokušavajući da otkriju i izleče duboko ukorenjene probleme u društvu koje vole',
            'U gradu nebodera koji se protežu od zemlje do neba i obrnuto, mladi arhitekta otkriva opasnu tajnu koja bi mogla da okrene njihov svet naopačke.',
            'Elitna eskadrila borbenih aviona trka se s vremenom da spreči katastrofalni događaj, leteći iznad opasnih bojišta i neprijateljskih linija.',
            'Uspon spartanskog ratnika se odvija na pozadini dramatičnog napredka Spartankse države, osvetljavajući probe i trijumfe njegovog života i istoriju njegovog narodaVeličanstveni vrhovi i doline planine oživljavaju u ovoj vizuelnoj simfoniji, otkrivajući duboku harmoniju ritma prirode',
            'Veličanstveni vrhovi i doline planine oživljavaju u ovoj vizuelnoj simfoniji, otkrivajući duboku harmoniju ritma prirode',
            'Cybernetička žena se bori sa svojim identitetom i čovečanstvom u futurističkom svetu, pomerajući granice tehnologije i samootkrivanja',
            'Usred smrtonosne kuge, žena se bavi svojim gubitkom i očajem, bacajući svetlost na duboku ljudsku sposobnost za otpornost i ljubav',
        ];
        $movies = [
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Kišobran za smejanje', 'director' => 'Miroslav Popović', 'description' => $descriptions[0], 'banner_url' => 'klovn_banner.png', 'image_url' => 'klovn.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 130, 'is_showcased' => 0, 'genre_id' => 2],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Objektiv Močvare', 'director' => 'Nemanja Petrović', 'description' => $descriptions[1], 'banner_url' => 'mocvare_banner.png', 'image_url' => 'mocvare.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 200, 'is_showcased' => 1, 'genre_id' => 7],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Eho Gneva', 'director' => 'Danica Jovanović', 'description' => $descriptions[2], 'banner_url' => 'pobuna_banner.png', 'image_url' => 'pobuna.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 180, 'is_showcased' => 1, 'genre_id' => 7],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Nebeske Kule', 'director' => 'Luka Novaković', 'description' => $descriptions[3], 'banner_url' => 'tesseract_banner.png', 'image_url' => 'tesseract.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 130, 'is_showcased' => 1, 'genre_id' => 8],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Albatros', 'director' => 'Miroslav Popović', 'description' => $descriptions[4], 'banner_url' => 'topgan_banner.png', 'image_url' => 'topgan.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 160, 'is_showcased' => 0, 'genre_id' => 1],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Spartanski Duh', 'director' => 'Isidora Nikolić', 'description' => $descriptions[5], 'banner_url' => 'troja_banner.png', 'image_url' => 'troja.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 140, 'is_showcased' => 1, 'genre_id' => 1],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Zvuk Planine', 'director' => 'Milica Đorđević', 'description' => $descriptions[6], 'banner_url' => 'alpi_banner.png', 'image_url' => 'alpi.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 180, 'is_showcased' => 0, 'genre_id' => 7],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Niti Budućnosti', 'director' => 'Marko Vasić', 'description' => $descriptions[7], 'banner_url' => 'deus_ex_banner.png', 'image_url' => 'deus_ex.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 120, 'is_showcased' => 1, 'genre_id' => 8],
            ['created_at' => now(), 'updated_at' => now(), 'title' => 'Kuga', 'director' => 'Jelena Kostić', 'description' => $descriptions[8], 'banner_url' => 'kuga_banner.png', 'image_url' => 'kuga.png', 'trailer_url' => 'https://youtube.com', 'release_date' => fake()->dateTimeBetween('-3 years'), 'duration' => 110, 'is_showcased' => 1, 'genre_id' => 3],
        ];

        Movie::insert($movies);
    }
}

