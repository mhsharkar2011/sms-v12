<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function students()
    {
        return view('admin.students');
    }

    public function teachers()
    {
        return view('admin.teachers');
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
