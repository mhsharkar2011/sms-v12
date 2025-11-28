{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar with data automatically provided by View Composer -->
        <x-admin-sidebar />

        <!-- Main content -->
        <div class="flex-1 overflow-auto">
            @yield('content')
        </div>
    </div>
</body>
</html>
