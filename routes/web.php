<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Parent\DashboardController as GuardianDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\TeacherManagementController;
use App\Http\Controllers\Admin\ClassManagementController;
use App\Http\Controllers\Admin\SubjectManagementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


// Debug route
Route::get('/', [PostController::class, 'index'])->name('home');
Route::post('/posts/{post}/like', [LikeController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/unlike', [LikeController::class, 'unlike'])->name('posts.unlike');
Route::post('/posts/{post}/toggle-like', [LikeController::class, 'toggle'])->name('posts.toggle-like');

// Authentication Routes
require __DIR__ . '/auth.php';

// Add profile routes if they don't exist
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Posts
    Route::resource('posts', PostController::class);

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Route::resource('likes', LikeController::class);
    // Route::post('/posts/{post}/like', [LikeController::class, 'store'])->middleware('auth')->name('posts.like');
    // Route::delete('/posts/{post}/unlike', [LikeController::class, 'destroy'])->middleware('auth')->name('posts.unlike');

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
    Route::prefix('guardian')->name('guardian.')->middleware('role:guardian')->group(function () {
        Route::get('/dashboard', [GuardianDashboard::class, 'index'])->name('dashboard');
        Route::get('/children', [GuardianDashboard::class, 'children'])->name('children')->middleware('permission:view child grades');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('/users', UserManagementController::class);
        Route::delete('/users/{user}/avatar', [UserManagementController::class, 'removeAvatar'])->name('users.avatar.remove');
        Route::resource('/students', StudentManagementController::class);
        Route::resource('/guardians', TeacherManagementController::class);
        Route::resource('/teachers', TeacherManagementController::class);
        Route::resource('/classes', ClassManagementController::class);
        Route::resource('/subjects', SubjectManagementController::class);
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
