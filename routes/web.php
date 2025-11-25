<?php

use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Parent\DashboardController as ParentDashboard;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Authentication Routes
require __DIR__ . '/auth.php';

// Add profile routes if they don't exist
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Student Routes
    Route::prefix('student')->name('student.')->middleware('role:student')->group(function () {
        Route::get('/dashboard', [StudentDashboard::class, 'index'])->name('dashboard');
        Route::get('/attendance', [StudentDashboard::class, 'attendance'])->name('attendance');
        Route::get('/timetable', [StudentDashboard::class, 'timetable'])->name('timetable');
        Route::get('/subjects', [StudentDashboard::class, 'subjects'])->name('subjects');
        Route::get('/homework', [StudentDashboard::class, 'homework'])->name('homework');
        Route::get('/grades', [StudentDashboard::class, 'grades'])->name('grades');
        Route::get('/events', [StudentDashboard::class, 'events'])->name('events');
        Route::get('/messages', [StudentDashboard::class, 'messages'])->name('messages');
        Route::get('/settings', [StudentDashboard::class, 'settings'])->name('settings');
        Route::get('/exams', [StudentDashboard::class, 'exams'])->name('exams');
    });

    // Teacher Routes
    Route::prefix('teacher')->name('teacher.')->middleware('role:teacher')->group(function () {
        Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
        Route::get('/courses', [TeacherDashboard::class, 'courses'])->name('courses')->middleware('permission:create courses');
        Route::get('/assignments', [TeacherDashboard::class, 'assignments'])->name('assignments')->middleware('permission:manage assignments');
    });

    // Parent Routes
    Route::prefix('parent')->name('parent.')->middleware('role:parent')->group(function () {
        Route::get('/dashboard', [ParentDashboard::class, 'index'])->name('dashboard');
        Route::get('/children', [ParentDashboard::class, 'children'])->name('children')->middleware('permission:view child grades');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    // Redirect based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        } elseif ($user->hasRole('parent')) {
            return redirect()->route('parent.dashboard');
        }

        return redirect('/');
    })->name('dashboard');
});
