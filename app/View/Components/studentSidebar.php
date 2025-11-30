<?php

namespace App\View\Components;

use App\Models\Attendance;
use App\Models\Exam;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Symfony\Component\Routing\Route;

class StudentSidebar extends Component
{
    public $activeRoute;
    public $user;

    public function __construct($activeRoute = null)
    {
        $this->activeRoute = $activeRoute;
        $this->user = Auth::user();
    }

    protected function getMenuItems()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalClasses = SchoolClass::count();
        $totalSubjects = Subject::count();
        $totalAttendance = Attendance::count();
        $totalExams = Exam::count();

        $items = [
            [
                'route' => 'student.dashboard',
                'icon' => '🏠',
                'label' => 'Dashboard',
                'description' => 'Overview & Updates',
                'badge' => null,
                'badgeColor' => null
            ],
            [
                'route' => 'student.index',
                'icon' => '🎓',
                'label' => 'Students',
                'description' => 'Student records',
                'badge' => $totalStudents,
                'badgeColor' => 'bg-blue-500'
            ],
            [
                'route' => 'student.teachers.profile',
                'icon' => '👨‍🏫',
                'label' => 'Teachers',
                'description' => 'Teacher profiles',
                'badge' => $totalTeachers,
                'badgeColor' => 'bg-green-500'
            ],
            [
                'route' => 'student.classes.index',
                'icon' => '🏫',
                'label' => 'Classes',
                'description' => 'Class management',
                'badge' => $totalClasses,
                'badgeColor' => 'bg-yellow-500'
            ],
            [
                'route' => 'student.subjects.index',
                'icon' => '📚',
                'label' => 'Subjects',
                'description' => 'Course catalog',
                'badge' => $totalSubjects,
                'badgeColor' => 'bg-purple-500'
            ],
            [
                'route' => 'student.attendance.index',
                'icon' => '📅',
                'label' => 'Attendance',
                'description' => 'Track presence',
                'badge' => $totalAttendance > 0 ? $totalAttendance : "NULL",
                'badgeColor' => $totalAttendance > 0 ? 'bg-red-500' : "bg-gray-500",
            ],
            [
                'route' => 'student.exams',
                'icon' => '📝',
                'label' => 'Exams',
                'description' => 'Tests & results',
                'badge' => $totalExams > 0 ? $totalExams : "NULL",
                'badgeColor' => $totalExams > 0 ? 'bg-yellow-500' : "bg-gray-500",
            ],
            [
                'route' => 'student.reports',
                'icon' => '📈',
                'label' => 'Reports',
                'description' => 'Analytics & insights',
                'badge' => null
            ],
        ];
        return $items;
    }

    public function bottomMenuItems()
    {
        return [
            [
                'route' => 'student.profile',
                'icon' => '👤',
                'label' => 'Profile',
                'description' => 'Account Settings'
            ],
            [
                'route' => 'student.settings',
                'icon' => '⚙️',
                'label' => 'Settings',
                'description' => 'Preferences'
            ],
            [
                'route' => 'logout',
                'icon' => '🚪',
                'label' => 'Logout',
                'description' => 'Sign out',
                'method' => 'POST'
            ],
        ];
    }

    public function isActive($route)
    {
        return $this->activeRoute === $route || request()->routeIs($route);
    }

    public function render()
    {
        return view('components.student-sidebar');
    }
}
