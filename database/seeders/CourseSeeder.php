<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Question;
use App\Models\Quizz;
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
                'Beginner Spanish',
                'Intermediate Spanish',
                'Advanced Spanish'
            ],
            'French' => [
                'Beginner French',
                'Intermediate French',
                'Advanced French'
            ],
            'German' => [
                'Beginner German',
                'Intermediate German',
                'Advanced German'
            ],
            'Chinese' => [
                'Beginner Chinese',
                'Intermediate Chinese',
                'Advanced Chinese'
            ],
            'Japanese' => [
                'Japanese Language and Culture Beginner',
                'Japanese Language and Culture Intermediate',
                'Japanese Language and Culture Advanced'
            ],
        ];
        $index = 0;
        foreach ($categories as $cat_key => $courses) {
            $category = Category::create([
                'name' => $cat_key,
            ]);

            foreach ($courses as $course) {
                $imageID = $index > 0 ? '-'.$index : '';
                $course = Course::create([
                    'cover' => 'https://flowbite.s3.amazonaws.com/docs/gallery/square/image' . $imageID . '.jpg',
                    'title' => ucwords($course),
                    'description' => fake()->text(),
                    'category_id' => $category->id,
                    'instructor_id' => User::whereRole('instructor')->inRandomOrder()->first()->id,
                ]);

                for ($i = 0; $i < 2; $i++) {
                    Chapter::create([
                        'course_id' => $course->id,
                        'title' => 'Chapter ' . ($i + 1) . ': ' . ucwords($course->title),
                        'description' => fake()->text(),
                        'assets' => json_encode(['storage/courses/assets/Intermediate.pptx'], true),
                    ]);
                }

                for ($i = 0; $i < 2; $i++) {
                    Assignment::create([
                        'title' => 'Assignment ' . ($i + 1) . ': ' . ucwords($course->title),
                        'course_id' => $course->id,
                        'file' => 'storage/courses/assets/Intermediate.pptx',
                        'due_date' => now()->addDays(7),
                    ]);
                }

                for ($i = 0; $i < 5; $i++) {
                    Question::create([
                        'course_id' => $course->id,
                        'question' => 'Is the capital of ' . $cat_key . ' is ' . fake()->city() . '?',
                        'answer' => 'true',
                    ]);
                }

                if ($index > 10) {
                    $index = 1;
                } else {
                    $index++;
                }
            }
        }

    }
}
