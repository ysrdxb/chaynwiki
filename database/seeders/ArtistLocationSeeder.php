<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArtistLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Michael Jackson' => ['lat' => 41.593, 'lng' => -87.346], // Gary, Indiana
            'Daft Punk' => ['lat' => 48.856, 'lng' => 2.352], // Paris, France
            'The Weeknd' => ['lat' => 43.653, 'lng' => -79.383], // Toronto, Canada
            'Led Zeppelin' => ['lat' => 51.507, 'lng' => -0.127], // London, UK
            'Kraftwerk' => ['lat' => 51.227, 'lng' => 6.773], // Dusseldorf, Germany
            'Bob Marley' => ['lat' => 18.109, 'lng' => -77.297], // Nine Mile, Jamaica
            'J Dilla' => ['lat' => 42.331, 'lng' => -83.045], // Detroit, USA
            'Björk' => ['lat' => 64.146, 'lng' => -21.942], // Reykjavik, Iceland
            'Fela Kuti' => ['lat' => 6.524, 'lng' => 3.379], // Lagos, Nigeria
            'BTS' => ['lat' => 37.566, 'lng' => 126.978], // Seoul, South Korea
        ];

        foreach ($locations as $name => $coords) {
            \App\Models\Artist::where('name', $name)->update([
                'latitude' => $coords['lat'],
                'longitude' => $coords['lng']
            ]);
        }
    }
}
