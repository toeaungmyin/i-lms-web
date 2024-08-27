<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->category;

        $categories = Category::all();

        $coursesq = Course::query();

        if ($category) {
            $coursesq->where('category_id', $category);
        }

        $courses = $coursesq->paginate(8);

        $events = Event::where('date', '>=', now()->startOfDay())
            ->orderBy('date', 'asc')
            ->take(4)->get();

        $status = [
            'totalCourses' => Course::count(),
            'totalEvents'  => Event::count(),
            'totalUsers'   => User::whereRole(['student', 'instructor'])->count(),
        ];

        return view('client.welcome.index', ['events' => $events, 'courses' => $courses, 'categories' => $categories, 'status' => $status]);
    }
}
