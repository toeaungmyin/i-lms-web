<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            'Language Exchange Fair',
            'Cultural Celebration Day',
            'Language Learning Workshops',
            'International Food Festival',
            'Global Storytelling Sessions',
            'Multilingual Music Concert',
            'Language Immersion Camp',
            'Cross-Cultural Art Exhibition',
            'Language Proficiency Contests',
            'Cultural Dance Performance',
            'International Film Festival',
            'Global Poetry Slam',
            'Cultural Fashion Show',
            'Language Trivia Night',
            'World Cuisine Cooking Class',
            'Language and Technology Seminar',
            'Cultural Heritage Walk',
            'International Book Club',
            'Multilingual Theatre Production',
            'Cross-Cultural Panel Discussion'
        ];
        $index = 1;
        $date = now()->subDays(5);
        foreach ($events as $event) {
            Event::create(['cover' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-' . $index . '.jpg',
                'title'=> ucwords($event),
                'description'=>fake()->text(),
                'date' => $date->addDay(),
            ]);

            if ($index > 10) {
                $index = 1;
            } else {
                $index++;
            }
        }
    }
}
