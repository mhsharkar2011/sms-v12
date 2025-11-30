<aside class="bg-gray-800 text-white w-64 min-h-screen p-4" aria-label="Guardian sidebar">
    <div class="mb-6 flex items-center space-x-3">
        <div class="h-10 w-10 rounded-full bg-gray-600 flex items-center justify-center text-xl">
            {{ strtoupper(substr(optional(Auth::user())->name ?? 'G', 0, 1)) }}
        </div>
        <div>
            <div class="font-semibold text-sm">
                {{ Auth::user()->name ?? 'Guardian' }}
            </div>
            <div class="text-xs text-gray-300">
                {{ Auth::user()->email ?? '' }}
            </div>
        </div>
    </div>

    @php
        $is = function ($pattern) {
            return request()->routeIs($pattern) ? 'bg-gray-700 rounded' : 'hover:bg-gray-700 rounded';
        };
    @endphp

    <nav>
        <ul class="space-y-1 text-sm">
            <li>
                <a href="{{ route('guardian.dashboard') }}" class="block px-3 py-2 {{ $is('guardian.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.students.index') }}" class="block px-3 py-2 {{ $is('guardian.students.*') }}">
                    My Students
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.attendance.index') }}" class="block px-3 py-2 {{ $is('guardian.attendance.*') }}">
                    Attendance
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.timetable') }}" class="block px-3 py-2 {{ $is('guardian.timetable') }}">
                    Timetable
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.messages.index') }}" class="block px-3 py-2 {{ $is('guardian.messages.*') }}">
                    Messages
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.fees') }}" class="block px-3 py-2 {{ $is('guardian.fees') }}">
                    Fees
                </a>
            </li>

            <li class="mt-3">
                <a href="{{ route('guardian.profile') }}" class="block px-3 py-2 {{ $is('guardian.profile') }}">
                    Profile
                </a>
            </li>

            <li>
                <a href="{{ route('guardian.settings') }}" class="block px-3 py-2 {{ $is('guardian.settings') }}">
                    Settings
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 hover:bg-red-600 rounded">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>