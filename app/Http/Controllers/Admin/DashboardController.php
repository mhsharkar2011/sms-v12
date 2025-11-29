<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboards.admin-dashboard');
    }

    public function users()
    {
        $quickStats = User::count();
        return view('admin.users', $quickStats);
    }


    public function adminProfile()
    {
        $totalAdmins = User::role('admin')->count();
        $activeAdmins = User::role('admin')->where('status', 'active')->count();
        $superAdmins = User::role('admin')->whereHas('permissions', function ($q) {
            $q->where('name', 'super-admin');
        })->count();
        $pendingAdmins = User::role('admin')->where('status', 'pending')->count();

        $admins = User::role('admin')->paginate(10);

        return view('admin.admins.index', compact(
            'admins',
            'totalAdmins',
            'activeAdmins',
            'superAdmins',
            'pendingAdmins'
        ));
    }
    public function adminProfileEdit()
    {
        return view('admin.profiles.index');
    }
    public function adminProfileUpdate()
    {
        return view('admin.profiles.edit');
    }
    public function adminProfileUpdatePassword()
    {
        return view('admin.profiles.edit');
    }

    public function students()
    {
        return view('dashboards.student-dashboard');
    }

    public function teachers()
    {
        $teachers = $teachers ?? null;
        return view('dashboards.teacher-dashboard', compact('teachers'));
    }

    public function parents()
    {
        $parents = $parents ?? null;
        return view('dashboards.parent-dashboard', compact('parents'));
    }

    public function classes()
    {
        return view('admin.classes');
    }

    public function subjects()
    {
        return view('admin.subjects');
    }

    public function attendance()
    {
        return view('admin.attendance');
    }

    public function exams()
    {
        return view('admin.exams');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function reports()
    {
        return view('admin.reports');
    }
}
