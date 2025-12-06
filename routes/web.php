<?php

use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\Parent\DashboardController as GuardianDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\StudentManagementController;
use App\Http\Controllers\Admin\TeacherManagementController;
use App\Http\Controllers\Admin\ClassManagementController;
use App\Http\Controllers\Admin\GuardianManagementController;
use App\Http\Controllers\Admin\SubjectManagementController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing Page
Route::get('/', function () {
    return view('landing');
})->name('home');


// routes/web.php

// Posts
Route::resource('posts', PostController::class);

// Comments
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


// Authentication Routes
require __DIR__ . '/auth.php';

// Add profile routes if they don't exist
Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}/posts', [ProfileController::class, 'posts'])->name('users.posts');
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
    Route::prefix('guardian')->name('guardian.')->middleware('role:guardian')->group(function () {
        Route::get('/dashboard', [GuardianDashboard::class, 'index'])->name('dashboard');
        Route::get('/children', [GuardianDashboard::class, 'children'])->name('children')->middleware('permission:view child grades');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {

        // Dashboard Route =============================================================================================================================
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::get('/students/dashboard', [AdminDashboard::class, 'students'])->name('students.dashboard');
        Route::get('/teachers/dashboard', [AdminDashboard::class, 'teachers'])->name('teachers.dashboard');
        Route::get('/parents/dashboard', [AdminDashboard::class, 'parents'])->name('parents.dashboard');
        Route::get('/classes/dashboard', [AdminDashboard::class, 'classes'])->name('classes.dashboard');
        Route::get('/subjects/dashboard', [AdminDashboard::class, 'subjects'])->name('subjects.dashboard');
        // Dashboard End ================================================================================================================================


        Route::resource('/users', UserManagementController::class);
        Route::resource('/students', StudentManagementController::class);
        Route::resource('/teachers', TeacherManagementController::class);
        Route::resource('/classes', ClassManagementController::class);
        Route::resource('/subjects', SubjectManagementController::class);
        Route::resource('/guardians', GuardianManagementController::class);


        // Enrollment Routes Start ===================================================================================================================
        Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
        Route::get('/enrollments/{enrollment}', [EnrollmentController::class, 'show'])->name('enrollments.show');
        Route::get('/enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('enrollments.edit');
        Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('enrollments.update');
        Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
        // Enrollment Actions
        Route::post('/enrollments/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('enrollments.approve');
        Route::post('/enrollments/{enrollment}/withdraw', [EnrollmentController::class, 'withdraw'])->name('enrollments.withdraw');
        Route::post('/enrollments/{enrollment}/complete', [EnrollmentController::class, 'complete'])->name('enrollments.complete');
        Route::post('/enrollments/{enrollment}/payment', [EnrollmentController::class, 'recordPayment'])->name('enrollments.payment');
        Route::post('/enrollments/{enrollment}/attendance', [EnrollmentController::class, 'updateAttendance'])->name('enrollments.attendance');
        Route::post('/enrollments/{enrollment}/transfer', [EnrollmentController::class, 'transfer'])->name('enrollments.transfer');
        // Class-specific enrollments
        Route::get('/classes/{class}/enrollments', [EnrollmentController::class, 'classEnrollments'])->name('classes.enrollments');
        // Student-specific enrollments
        Route::get('/students/{student}/enrollments', [EnrollmentController::class, 'studentEnrollments'])->name('students.enrollments');
        Route::get('/classes/{class}/students-data', [ClassManagementController::class, 'getStudentsData'])->name('classes.students-data');
        Route::post('/classes/{class}/assign-students', [ClassManagementController::class, 'assignStudents'])->name('classes.assign-students');
        // Enrollment Routes End ========================================================================================================================

        // Attendance Routes Start ======================================================================================================================
        Route::get('/attendance', [AdminDashboard::class, 'attendance'])->name('attendance');
        // Attendance Routes End =========================================================================================================================
        
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
