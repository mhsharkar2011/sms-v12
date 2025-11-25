<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    public function courses()
    {
        return view('student.courses');
    }

    public function grades()
    {
        return view('student.grades');
    }
}
