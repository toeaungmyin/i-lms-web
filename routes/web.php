<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\ChapterController as AdminChapterController;
use App\Http\Controllers\Admin\AssignmentController as AdminAssignmentController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\EventController;
use App\Http\Controllers\Client\ExamController;
use App\Http\Controllers\Client\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::get('/courses', [CourseController::class, 'index'])->name('courses');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');

    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');

    Route::get('/courses/{id}/exam-start', [ExamController::class, 'startExam'])->name('exam.start');
    Route::post('exams/{id}/submit', [ExamController::class, 'submitExam'])->name('exam.submit');
    Route::get('/exams/{id}/result', [ExamController::class, 'showExamResult'])->name('exam.result');
    Route::post('/assignments/{id}/submit', [CourseController::class, 'submitAssignment'])->name('asignment.submit');
    // Route::get('/assignments/{id}/', [CourseController::class, 'showExamResult'])->name('exam.result');
    Route::get('/courses/{id}/finish', [CourseController::class, 'finishCourse'])->name('course.finish');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->middleware('role:admin,instructor')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminUserController::class, 'index'])->name('dashboard.users');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('dashboard.user.create');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('dashboard.users.show');
        Route::post('/users', [AdminUserController::class, 'store'])->name('dashboard.users.store');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('dashboard.users.destroy');
        Route::post('/users/{id}/attach-course', [AdminUserController::class, 'attachToCourse'])->name('dashboard.users.attachToCourse');

        Route::get('/events', [AdminEventController::class, 'index'])->name('dashboard.events');
        Route::get('/event/create', [AdminEventController::class, 'create'])->name('dashboard.event.create');
        Route::get('/event/{id}', [AdminEventController::class, 'show'])->name('dashboard.event.show');
        Route::post('/event', [AdminEventController::class, 'store'])->name('dashboard.event.store');
        Route::put('/event/{id}', [AdminEventController::class, 'update'])->name('dashboard.event.update');
        Route::delete('/event/{id}', [AdminEventController::class, 'destroy'])->name('dashboard.event.destroy');

        Route::get('/courses', [AdminCourseController::class, 'index'])->name('dashboard.courses');
        Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('dashboard.courses.create');
        Route::get('/courses/{id}', [AdminCourseController::class, 'show'])->name('dashboard.courses.show');
        Route::post('/courses', [AdminCourseController::class, 'store'])->name('dashboard.courses.store');
        Route::put('/courses/{id}', [AdminCourseController::class, 'update'])->name('dashboard.courses.update');
        Route::delete('/courses/{id}', [AdminCourseController::class, 'destroy'])->name('dashboard.courses.destroy');
        Route::post('/courses/{id}/enroll', [AdminCourseController::class, 'enrollStudent'])->name('dashboard.users.enrollStudent');
        Route::post('/course/{id}/assignment-check', [AdminCourseController::class, 'checkAssignment'])->name('asignment.check');

        Route::post('/categories', [AdminCourseController::class, 'storeCategory'])->name('dashboard.categories.store');
        Route::delete('/categories/{id}', [AdminCourseController::class, 'deleteCategory'])->name('dashboard.categories.delete');

        // axios crud api routes
        Route::get('courses/{id}/chapters', [AdminChapterController::class, 'index'])->name('dashboard.chapters');
        Route::post('/chapters', [AdminChapterController::class, 'store'])->name('dashboard.chapters.store');
        Route::put('/chapters/{id}', [AdminChapterController::class, 'update'])->name('dashboard.chapters.update');
        Route::delete('/chapters/{id}', [AdminChapterController::class, 'destroy'])->name('dashboard.chapters.destroy');

        Route::get('course/{id}/assignments', [AdminAssignmentController::class, 'index'])->name('dashboard.assignments');
        Route::post('/assignments', [AdminAssignmentController::class, 'store'])->name('dashboard.assignments.store');
        Route::put('/assignments/{id}', [AdminAssignmentController::class, 'update'])->name('dashboard.assignments.update');
        Route::delete('/assignments/{id}', [AdminAssignmentController::class, 'destroy'])->name('dashboard.assignments.destroy');

        Route::get('courses/{id}/quizzes', [AdminQuestionController::class, 'index'])->name('dashboard.quizzes');
        Route::post('/quizzes', [AdminQuestionController::class, 'store'])->name('dashboard.quizzes.store');
        Route::put('/quizzes/{id}', [AdminQuestionController::class, 'update'])->name('dashboard.quizzes.update');
        Route::delete('/quizzes/{id}', [AdminQuestionController::class, 'destroy'])->name('dashboard.quizzes.destroy');
    });
});


require __DIR__ . '/auth.php';
