<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gear;
use Illuminate\Support\Str;

class GearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gears = [
            // Synthesizers
            [
                'name' => 'Minimoog Model D',
                'brand' => 'Moog',
                'type' => 'hardware',
                'description' => 'The world’s first portable synthesizer and the archetype for all later electronic keyboards. Known for its thick, fat analog bass and lead sounds.',
                'image' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=500&q=80',
            ],
            [
                'name' => 'Prophet-5',
                'brand' => 'Sequential Circuits',
                'type' => 'hardware',
                'description' => 'A legendary polyphonic analog synthesizer used extensively in the 1980s by artists like Michael Jackson and Radiohead.',
                'image' => 'https://images.unsplash.com/photo-1614113400622-c3230005d528?w=500&q=80',
            ],
            [
                'name' => 'DX7',
                'brand' => 'Yamaha',
                'type' => 'hardware',
                'description' => 'The digital synthesizer that defined the sound of 80s pop music with its FM synthesis, famous for its electric piano and bell sounds.',
                'image' => 'https://images.unsplash.com/photo-1542646274-725838446261?w=500&q=80',
            ],

            // Drum Machines
            [
                'name' => 'TR-808',
                'brand' => 'Roland',
                'type' => 'hardware',
                'description' => 'The most famous drum machine of all time. Its booming kick drum forms the foundation of Hip Hop, Techno, and Trap music.',
                'image' => 'https://images.unsplash.com/photo-1519508234439-4f23643125c1?w=500&q=80',
            ],
            [
                'name' => 'TR-909',
                'brand' => 'Roland',
                'type' => 'hardware',
                'description' => 'A hybrid analog/digital drum machine crucial for the development of House and Techno music.',
                'image' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=500&q=80',
            ],
            [
                'name' => 'MPC 3000',
                'brand' => 'Akai',
                'type' => 'hardware',
                'description' => 'The sampler and sequencer that defined the swing and rhythm of 90s Hip Hop, used by J Dilla and Dr. Dre.',
                'image' => 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?w=500&q=80',
            ],

            // Guitars & Bass
            [
                'name' => 'Stratocaster',
                'brand' => 'Fender',
                'type' => 'instrument',
                'description' => 'An iconic electric guitar known for its bright, articulate sound. Used by Jimi Hendrix, David Gilmour, and countless others.',
                'image' => 'https://images.unsplash.com/photo-1550985543-f4423c8d2991?w=500&q=80',
            ],
            [
                'name' => 'Les Paul Standard',
                'brand' => 'Gibson',
                'type' => 'instrument',
                'description' => 'Famous for its thick, warm, and sustaining tone, a staple of Rock and Blues music.',
                'image' => 'https://images.unsplash.com/photo-1564186763531-6418a265b3d9?w=500&q=80',
            ],
            [
                'name' => 'Precision Bass',
                'brand' => 'Fender',
                'type' => 'instrument',
                'description' => 'The first mass-produced electric bass guitar, providing the low-end thump for Motown, Rock, and Punk.',
                'image' => 'https://images.unsplash.com/photo-1627926296766-c67d84877395?w=500&q=80',
            ],

            // DAWs & Software
            [
                'name' => 'Ableton Live',
                'brand' => 'Ableton',
                'type' => 'daw',
                'description' => 'A unique digital audio workstation designed for live performance and intuitive loop-based composition.',
                'image' => 'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?w=500&q=80',
            ],
            [
                'name' => 'Pro Tools',
                'brand' => 'Avid',
                'type' => 'daw',
                'description' => 'The industry standard DAW for professional recording studios and post-production facilities.',
                'image' => 'https://images.unsplash.com/photo-1598653222000-6b7b7a552625?w=500&q=80',
            ],
            [
                'name' => 'Auto-Tune',
                'brand' => 'Antares',
                'type' => 'software',
                'description' => 'Pitch correction software that changed the sound of modern vocal production, often used as a creative effect.',
                'image' => 'https://images.unsplash.com/photo-1516280440614-6697288d5d38?w=500&q=80',
            ],
            
            // Microphones
            [
                'name' => 'U87',
                'brand' => 'Neumann',
                'type' => 'hardware',
                'description' => 'The most widely used large-diaphragm condenser microphone in professional studios for vocals.',
                'image' => 'https://images.unsplash.com/photo-1590845947391-ba13a6647b31?w=500&q=80',
            ],
            [
                'name' => 'SM7B',
                'brand' => 'Shure',
                'type' => 'hardware',
                'description' => 'A dynamic broadcast microphone famously used by Michael Jackson on "Thriller" and now a standard for podcasts.',
                'image' => 'https://images.unsplash.com/photo-1525438885566-22485e98585e?w=500&q=80',
            ],
        ];

        foreach ($gears as $gear) {
            Gear::updateOrCreate(
                ['name' => $gear['name']],
                array_merge($gear, ['slug' => Str::slug($gear['name'])])
            );
        }
    }
}
