<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public $config;

    public function __construct()
    {
        $this->config = Config::first();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $query = User::whereRole(['student', 'instructor']);

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%')
                ->orWhere('STDID', 'like', '%' . $search . '%');
        }
        $users = $query->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generated_id = $this->config->generate_student_id();
        $roles = Role::whereNot('name', 'admin')->get();
        return view('admin.users.create', ['roles' => $roles, 'generated_id' => $generated_id]);
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

            $generated_id = $this->config->generate_student_id();

            $validated['STDID'] = $generated_id;

            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            $user->assignRole($validated['role']);

            $this->config->update_student_id_index();

            return redirect(route('dashboard.users'))->with(
                'message',
                [
                    'status' => 'success',
                    'content' => 'User is created successfully',
                ]
            );
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());

            redirect(route('dashboard.users.create'))->with(
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
        return view('admin.users.show', ['user' => $user,'roles'=>$roles]);
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
}
