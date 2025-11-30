<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

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
    public function ProfileShow()
    {
        return view('profile.show');
    }
    public function ProfileEdit()
    {
        return view('profile.edit');
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

    public function guardians()
    {
        $guardians = $guardians ?? null;
        return view('dashboards.guardian-dashboard', compact('guardians'));
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
