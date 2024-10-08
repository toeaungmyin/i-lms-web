<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseHasStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->search;
        $query = Course::query();

        $user = $request->user();
        if ($user->is_role('instructor')) {
            $query->where('instructor_id', $user->id);
        }

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('instructor', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $courses = $query->paginate(10);
        $categories = Category::all();
        return view('admin.courses.index', [
            'courses' => $courses,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', ['categories' => $categories]);
    }

    public function show(string $id)
    {
        $course = Course::find($id);
        $categories = Category::all();
        $students = $course->students;

        return view('admin.courses.show', [
            'course' => $course,
            'categories' => $categories,
            'students' => $students
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'required|string',
            'category_id' => 'nullable|string|exists:categories,id',
            'maxExamAttempts' => 'required|numeric',
            'examTimeLimit' => 'required|numeric',
            'assignment_grade_percent' => 'required|numeric|min:0|max:100',
            'exam_grade_percent' => 'required|numeric|min:0|max:100'
        ]);

        try {
            $validated = $request->all();

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '.' . $cover->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('images/courses', $cover, $coverName);
                $validated['cover'] = 'storage/images/courses/' . $coverName;
            }

            $validated['instructor_id'] = Auth::id();

            Course::create($validated);

            return redirect(route('dashboard.courses'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Course is created successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create course: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'Failed to create course',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'description' => 'nullable|string',
            'category_id' => 'nullable|string|exists:categories,id',
            'maxExamAttempts' => 'nullable|numeric',
            'examTimeLimit' => 'nullable|numeric',
            'assignment_grade_percent' => 'nullable|numeric|min:0|max:100',
            'exam_grade_percent' => 'nullable|numeric|min:0|max:100'
        ]);

        try {
            $validated = $request->all();

            $course = Course::find($id);

            if (!$course) {
                throw new \Exception('Course not found');
            }

            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $coverName = time() . '.' . $cover->getClientOriginalExtension();

                if ($course->cover) {
                    Storage::disk('public')->delete($course->cover);
                }

                Storage::disk('public')->putFileAs('courses/images', $cover, $coverName);
                $validated['cover'] = 'storage/courses/images/' . $coverName;
            }

            $course->update(array_filter($validated, function ($value) {
                return $value !== null;
            }));

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Course is updated successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to update course: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'Failed to update course',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        $chapters = $course->chapters;

        if ($chapters) {
            foreach ($chapters as $chapter) {
                $assets = json_decode($chapter->assets, true);

                foreach ($assets as $asset) {
                    Storage::disk('public')->delete($asset);
                }

                $chapter->delete();
            }
        }

        $assignments = $course->assignments;

        if ($assignments) {
            foreach ($assignments as $assignment) {
                Storage::disk('public')->delete($assignment->file);
                $assignment->delete();
            }
        }


        $course->questions()->delete();
        $course->course_has_students()->delete();

        $course->delete();

        return redirect()->back()->with(
            'message',
            [
                'status'  => 'success',
                'content' => 'Course is deleted successfully',
            ]
        );
    }



    public function storeCategory(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string',
        ]);

        try {
            $validated = $request->all();

            Category::create($validated);

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Category is created successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'Failed to create category',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            redirect()->back()->with(
                'message',
                [
                    'status'  => 'error',
                    'content' => 'Category is not found',
                ]
            );
        }

        $category->courses()->update(['category_id' => null]);
        $category->delete();

        return redirect()->back()->with(
            'message',
            [
                'status' => 'success',
                'content' => 'Category is deleted successfully'
            ]
        );
    }

    public function enrollStudent(Request $request, string $id)
    {
        $request->validate([
            'STDID' => 'required|exists:users,STDID',
        ]);

        try {
            $validatedData = $request->all();

            $student = User::where('role_id', 3)->where('STDID', $validatedData['STDID'])->first();

            if (!$student) {
                return redirect()->back()->with(
                    'message',
                    [
                        'status' => 'error',
                        'content' => 'Student with ' . $validatedData['STDID'] . ' not found',
                    ]
                );
            }

            $course = Course::find($id);

            $student->attachCourse($course->id);

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Student is enrolled to course successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'User is not attached to the selected course',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    public function checkAssignment(Request $request, $id)
    {

        $request->validate([
            'mark' => 'required|numeric',
            'student_id' => 'required|exists:users,id'
        ]);

        $user = User::findOrFail($request->student_id);
        $course = Course::findOrFail($id);

        $chs = CourseHasStudent::where('course_id', $course->id)->where('student_id', $user->id)->first();
        $chs->update([
            'assignment_mark' => $request->mark
        ]);

        return redirect()->back()->with(
            'message',
            [
                'status' => 'success',
                'content' => 'Assignment is checked successfully'
            ]
        );
    }
}
