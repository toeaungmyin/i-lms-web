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
            'Cultural Dance Performance'
        ];

        foreach ($events as $key => $event) {
            Event::create([
                'cover'=> 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image-'.$key + 1 .'.jpg',
                'title'=> ucwords($event),
                'description'=>fake()->text(),
                'event_date'=>fake()->date(),
            ]);
        }
    }
}
