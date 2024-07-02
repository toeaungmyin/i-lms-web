<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\EventController;
use App\Http\Controllers\Client\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class,'index'])->name('welcome');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/courses', [CourseController::class, 'index'])->name('courses');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->middleware('role:admin')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('dashboard.users');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('dashboard.users.show');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('dashboard.users.destroy');

        Route::get('/events', [AdminEventController::class, 'index'])->name('dashboard.events');
        Route::get('/event/{id}', [AdminEventController::class, 'show'])->name('dashboard.event.show');
        Route::post('/event', [AdminEventController::class, 'store'])->name('dashboard.event.store');
        Route::put('/event/{id}', [AdminEventController::class, 'update'])->name('dashboard.event.update');
        Route::delete('/event/{id}', [AdminEventController::class, 'destroy'])->name('dashboard.event.destroy');
    });
});


require __DIR__.'/auth.php';
