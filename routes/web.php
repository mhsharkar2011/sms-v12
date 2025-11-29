<?php

use App\Http\Controllers\Admin\ClassManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Parent\DashboardController as ParentDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\TeacherManagementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectManagementController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');

// Authentication Routes
require __DIR__ . '/auth.php';

// Add profile routes if they don't exist
Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
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
        Route::get('/profiles', [AdminDashboard::class, 'adminProfile'])->name('profile');
        Route::get('/profile', [AdminDashboard::class, 'adminProfileEdit'])->name('profile.edit');
        Route::put('/profile', [AdminDashboard::class, 'adminProfileUpdate'])->name('profile.update');
        Route::put('/profile/password', [AdminDashboard::class, 'adminProfileUpdatePassword'])->name('profile.password');

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // User Management Route
        Route::resource('/users', UserManagementController::class);
        Route::delete('/users/{user}/avatar', [UserManagementController::class, 'removeAvatar'])->name('users.avatar.remove');

        // Student Management Route
        Route::resource('/students', StudentManagementController::class);
        // Teacher Management
        Route::resource('/teachers', TeacherManagementController::class);
        // Class Management
        Route::resource('/classes', ClassManagementController::class);
        Route::resource('/subjects', SubjectManagementController::class);

        // Student assignment routes
        Route::get('/classes/{class}/students-data', [ClassManagementController::class, 'getStudentsData'])->name('classes.students-data');
        Route::post('/classes/{class}/assign-students', [ClassManagementController::class, 'assignStudents'])->name('classes.assign-students');



        // In your routes file
        // Dashboard Route
        Route::get('/students/dashboard', [AdminDashboard::class, 'students'])->name('students.dashboard');
        Route::get('/teachers/dashboard', [AdminDashboard::class, 'teachers'])->name('teachers.dashboard');
        Route::get('/parents/dashboard', [AdminDashboard::class, 'parents'])->name('parents.dashboard');
        Route::get('/classes/dashboard', [AdminDashboard::class, 'classes'])->name('classes.dashboard');
        Route::get('/subjects/dashboard', [AdminDashboard::class, 'subjects'])->name('subjects.dashboard');
        Route::get('/attendance', [AdminDashboard::class, 'attendance'])->name('attendance');
        Route::get('/exams', [AdminDashboard::class, 'exams'])->name('exams');
        Route::get('/reports', [AdminDashboard::class, 'reports'])->name('reports');
        Route::get('/settings', [AdminDashboard::class, 'settings'])->name('settings');

        //Admin Notifications Route
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    });


    // // Admin Report Routes
    // Route::middleware(['auth', 'role:admin'])->prefix('admin/reports')->name('admin.reports.')->group(function () {
    //     Route::get('/academic', function () {
    //         return view('admin.reports.academic');
    //     })->name('academic');

    //     Route::get('/financial', function () {
    //         return view('admin.reports.financial');
    //     })->name('financial');

    //     Route::get('/attendance', function () {
    //         return view('admin.reports.attendance');
    //     })->name('attendance');

    //     Route::get('/examination', function () {
    //         return view('admin.reports.examination');
    //     })->name('examination');
    // });

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


Route::get('/notifications/unread-count', function () {
    return response()->json([
        'unread_count' => auth()->user()->unreadNotifications->count()
    ]);
})->name('notifications.unread-count');

// Notifications Routes
Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unreadCount');
    Route::get('/recent', [NotificationController::class, 'recent'])->name('recent');
    Route::get('/type/{type}', [NotificationController::class, 'byType'])->name('byType');

    Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
    Route::post('/{notification}/unread', [NotificationController::class, 'markAsUnread'])->name('markAsUnread');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('markAllAsRead');

    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::delete('/', [NotificationController::class, 'clearAll'])->name('clearAll');
});

// routes/web.php
Route::get('/notifications/unread-count', function () {
    return response()->json([
        'unread_count' => auth()->check() ? auth()->user()->unreadNotifications->count() : 0
    ]);
})->name('notifications.unread-count')->middleware('auth');
