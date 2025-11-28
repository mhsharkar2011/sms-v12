<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboards.teacher-dashboard');
    }

    public function courses()
    {
        return view('teachers.courses');
    }

    public function assignments()
    {
        return view('teachers.assignments');
    }
}
