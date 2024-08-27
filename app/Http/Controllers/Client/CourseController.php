<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Category;
use App\Models\Course;
use App\Models\StudentHasAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'courses' => $courses->paginate(16),
            'categories' => $categories
        ]);
    }

    public function show($id)
    {
        $user = User::find(Auth::id());
        $course = Course::findOrFail($id);

        if (!$user->joinedCourses->contains($course->id)) {
            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'You are not enrolled in this course',
                ]
            );
        }
        return view('client.courses.show', [
            'course' => $course
        ]);
    }

    public function submitAssignment(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|file|mimes:pptx,pdf,docx,zip|max:20000',
            ]);

            $validated = $request->all();
            $user = Auth::user();

            $assignment = Assignment::find($validated['assignment_id']);
            $remainingTime = Carbon::parse($assignment->due_date)->diffInSeconds(Carbon::now());
            if ($remainingTime > 1) {
                return redirect()->back()->with(
                    'message',
                    [
                        'status' => 'error',
                        'content' => 'The assignment is overdue',
                    ]
                );
            }
            if ($assignment) {

                $stdAssignments = $assignment->studentHasAssignment()->where('student_id', Auth::id())->get();

                foreach ($stdAssignments as $stdAssignment) {
                    Storage::disk('public')->delete($stdAssignment->file);
                    $stdAssignment->delete();
                }
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->putFileAs("students/{$user->name}/assignments", $file, $fileName);
                $validated['file'] = "storage/students/{$user->name}/assignments/{$fileName}";
            }

            $validated['student_id'] = $user->id;

            StudentHasAssignment::create($validated);

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Assignment is submitted successfully',
                ]
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'message',
                [
                    'status'  => 'error',
                    'content' => $e->getMessage(),
                    'log'     => $e->getMessage(),
                ]
            );
        }
    }


}
