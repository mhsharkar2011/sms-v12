<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('teacher.dashboard');
    }

    public function courses()
    {
        return view('teacher.courses');
    }

    public function assignments()
    {
        return view('teacher.assignments');
    }
}
