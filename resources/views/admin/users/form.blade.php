<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $editMode ? 'Sửa tài khoản' : 'Thêm tài khoản' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center px-4 bg-cover bg-center"
      style="background-image: url('https://img.freepik.com/free-photo/beautiful-tropical-empty-beach-sea-ocean-with-white-cloud-blue-sky-background_74190-13665.jpg?t=st=1743386643~exp=1743390243~hmac=cd1c8328ab8e1f7351da46e2995a8c704d916a2ae4d90e5cf7c696806b4c159f&w=1380');">

    <div class="bg-white/40 backdrop-blur-md w-full max-w-lg p-8 rounded-2xl shadow-lg border border-white/30">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">
            {{ $editMode ? 'Sửa tài khoản' : 'Thêm tài khoản' }}
        </h2>

        <form method="POST"
              action="{{ $editMode ? route('admin.users.update', $user->id) : route('admin.users.store') }}">
            @csrf
            @if($editMode)
                @method('PUT')
            @endif

            <!-- Tên -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white/80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white/80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Mật khẩu -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Mật khẩu {{ $editMode ? '(bỏ trống nếu không đổi)' : '' }}
                </label>
                <input type="password" name="password"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white/80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                       {{ $editMode ? '' : 'required' }}>
            </div>

            <!-- Vai trò -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                <select name="role" id="role"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white/80 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                    <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.users') }}" class="text-gray-700 hover:underline">⬅ Quay lại</a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow">
                    {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                </button>
            </div>
        </form>
    </div>

</body>
</html>
