<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-green-600 text-white flex flex-col">
        <div class="p-6 border-b border-green-500">
            <h1 class="text-2xl font-bold">Admin Panel</h1>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('admin') }}" class="block py-2 px-4 rounded hover:bg-green-700">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block py-2 px-4 rounded bg-green-700">Tài khoản</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-700">Chatbot</a>
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
        <h2 class="text-2xl font-bold mb-4">Tài khoản đã đăng nhập gần đây</h2>

        <table class="min-w-full bg-white shadow rounded overflow-hidden">
            <thead>
                <tr class="bg-gray-200 text-left text-sm uppercase text-gray-600">
                    <th class="py-3 px-4">Tên</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Lần đăng nhập cuối</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($users as $user)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="py-2 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="py-2 px-4 text-gray-700">{{ $user->email }}</td>
                    <td class="py-2 px-4 text-gray-600">
                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa xác định' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-4 px-4 text-center text-gray-500">Chưa có ai đăng nhập.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </main>

</body>
</html>
