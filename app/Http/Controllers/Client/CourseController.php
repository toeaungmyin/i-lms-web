<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;
        $search = $request->search;
        $date = $request->date;

        $courses = Course::query();

        if ($category) {
            $courses->where('category_id', $category);
        }

        if ($search) {
            $courses->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }

        if ($date) {
            $courses->whereDay('event_date', $date);
        }

        $categories = Category::all();
        return view('client.courses.index', [
            'courses' => $courses->get(),
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('client.courses.show', [
            'course' => $course
        ]);
    }


}
