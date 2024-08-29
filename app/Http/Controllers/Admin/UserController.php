<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public $std_config;
    public $ins_config;

    public function __construct()
    {
        $this->std_config = Config::where('name', 'student')->first();
        $this->ins_config = Config::where('name', 'instructor')->first();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $instructor = $request->user();

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('STDID', 'like', '%' . $search . '%');
            });
        }

        if ($instructor->is_role('instructor')) {
            $query->where('role_id', 3)
            ->whereHas('joinedCourses', function ($q) use ($instructor) {
                $q->where('instructor_id', $instructor->id);
            });
        } else {
            $query->whereNot('role_id', 1);
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generated_std_id = $this->std_config->generate_id();
        $generated_ins_id = $this->ins_config->generate_id();
        $roles = Role::whereNot('name', 'admin')->get();
        return view('admin.users.create', ['roles' => $roles, 'generated_std_id' => $generated_std_id, 'generated_ins_id' => $generated_ins_id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:users,name',
            'phone' => ['required', 'regex:/^(\+959\d{9}|09\d{9})$/', 'unique:users,phone'],
            'role' => 'required|string|exists:roles,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $validated = $request->all();
            if ($validated['role'] == 'student') {
                $generated_id = $this->std_config->generate_id();
            } else if ($validated['role'] == 'instructor') {
                $generated_id = $this->ins_config->generate_id();
            }

            $validated['STDID'] = $generated_id;

            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            $user->assignRole($validated['role']);

            if ($validated['role'] == Role::where('name', 'student')->first()->id) {
                $this->std_config->update_id_index();
            } else if ($validated['role'] == Role::where('name', 'instructor')->first()->id) {
                $this->ins_config->update_id_index();
            }

            return redirect(route('dashboard.users'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'User is created successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'User is not created',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $roles = Role::whereNot('name','admin')->get();
        $courses = Course::all();

        return view('admin.users.show', ['user' => $user, 'roles' => $roles, 'courses' => $courses]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'name'     => 'nullable|string|exists:users,name',
            'phone'    => ['nullable', 'regex:/^(\+959\d{9}|09\d{9})$/', Rule::unique(User::class)->ignore($id)],
            'role'     => 'nullable|string|exists:roles,name',
            'email'    => ['nullable', 'email', Rule::unique(User::class)->ignore($id)],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $validated = $request->all();

            $user = User::find($id);

            if (!$user) {
                throw new \Exception('User is not found');
            }

            if ($request->has('password')) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            if ($request->has('role')) {
                $user->assignRole($validated['role']);
            }

            return redirect(route('dashboard.users'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'User is updated successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to update user: ' . $e->getMessage());

            redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'User is not updated',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            redirect(route('dashboard.users'))->with(
                'message',
                [
                    'status'  => 'error',
                    'content' => 'User is not found',
                ]
            );
        }

        $message = $user->role->name . ' (' . $user->STDID . ') is deleted successfully';

        $user->delete();

        return redirect(route('dashboard.users'))->with('message', [
            'status' => 'success',
            'content' => $message,
        ]);
    }

    public function attachToCourse(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        try {
            $validatedData = $request->all();

            $student = User::find($id);

            $course = Course::find($validatedData['course_id']);

            // if (!$student->is_role('student')) {
            //     return redirect()->back()->with(
            //         'message',
            //         [
            //             'status' => 'error',
            //             'content' => 'User has not student role',
            //         ]
            //     );
            // }

            $student->attachCourse($course->id);

            return redirect()->back()->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'Student is attached to course successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            redirect()->back()->with(
                'message',
                [
                    'status' => 'error',
                    'content' => 'User is not attached to the selected course',
                    'log' => $e->getMessage(),
                ]
            )->withInput();
        }
    }
}
