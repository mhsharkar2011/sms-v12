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

    public function attendance()
    {
        return view('student.attendance');
    }

    public function timetable()
    {
        return view('student.timetable');
    }

    public function subjects()
    {
        return view('student.subjects');
    }

    public function homework()
    {
        return view('student.homework');
    }

    public function grades()
    {
        return view('student.grades');
    }

    public function events()
    {
        return view('student.events');
    }

    public function messages()
    {
        return view('student.messages');
    }

    public function settings()
    {
        return view('student.settings');
    }

    public function exams()
    {
        return view('student.exams');
    }
}
