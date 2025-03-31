<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-600 text-white flex flex-col">
        <div class="p-6 border-b border-green-500">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('admin') ? 'bg-green-700' : '' }}">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('admin.users') ? 'bg-green-700' : '' }}">Tài khoản</a>
            <a href="{{ route('admin.chatbot') }}" class="block py-2 px-4 rounded hover:bg-green-700 {{ request()->routeIs('admin.chatbot') ? 'bg-green-700' : '' }}">Chatbot</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-700">Cài đặt</a>
        </nav>
        <form method="POST" action="{{ route('logout') }}" class="p-4 border-t border-green-500">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 py-2 rounded text-white">
                Đăng xuất
            </button>
        </form>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</body>
</html>
