<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $quickStats = User::count();
        return view('admin.users',$quickStats);
    }

    public function students()
    {
        return view('admin.students');
    }

    public function teachers()
    {
         $teachers = $teachers ?? null;
        return view('admin.teachers',compact('teachers'));
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
