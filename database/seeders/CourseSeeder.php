<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'English' => [
                'Beginner English',
                'Intermediate English',
                'Advanced English'
            ],
            'Spanish' => [
                'Conversational Spanish',
                'Business Spanish'
            ],
            'French' => [
                'Beginner French',
                'Advanced French'
            ],
            'German' => [
                'German for Travelers'
            ],
            'Chinese' => [
                'Mandarin Chinese Basics'
            ],
            'Japanese' => [
                'Japanese Language and Culture'
            ],
            'Thai' => [
                'Beginner Thai',
                'Advanced Thai'
            ],
        ];
        $index = 0;
        foreach ($categories as $cat_key => $courses) {
            $category = Category::create([
                'name' => $cat_key,
            ]);


            foreach ($courses as $course) {
                $imageID = $index > 0 ? '-'.$index : '';
                Course::create([
                    'cover' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image' . $imageID . '.jpg',
                    'title' => ucwords($course),
                    'description' => fake()->text(),
                    'category_id' => $category->id,
                    'instructor_id' => User::whereRole('instructor')->inRandomOrder()->first()->id,
                ]);
                $index++;
            }
        }

    }
}
