@extends('admin.admin')

@section('content')
@section('stats-cards')
@stop
<h2 class="text-2xl font-bold mb-4">Tài khoản đã đăng nhập gần đây</h2>

<!-- Thông báo thành công -->
@if (session('success'))
    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
        {{ session('success') }}
    </div>
@endif

<!-- Form tìm kiếm và lọc -->
<div class="mb-4 flex flex-wrap items-center gap-4">
    <a href="{{ route('admin.users.create') }}" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
        ➕ Thêm người dùng
    </a>

    <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap gap-4 flex-1">
        <input type="text" name="search" placeholder="Tìm kiếm theo tên hoặc email..." value="{{ request('search') }}"
               class="flex-1 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">

        <select name="role" class="px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
            <option value="">Tất cả vai trò</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
            Lọc
        </button>
    </form>
</div>

<!-- Bảng danh sách người dùng -->
<table class="min-w-full bg-white shadow rounded overflow-hidden">
    <thead>
        <tr class="bg-gray-200 text-left text-sm uppercase text-gray-600">
            <th class="py-3 px-4">Tên</th>
            <th class="py-3 px-4">Email</th>
            <th class="py-3 px-4">Vai trò</th>
            <th class="py-3 px-4">Lần đăng nhập cuối</th>
            <th class="py-3 px-4">Hành động</th>
        </tr>
    </thead>
    <tbody class="text-sm">
        @forelse ($users as $user)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="py-2 px-4 font-medium text-gray-800">{{ $user->name }}</td>
                <td class="py-2 px-4 text-gray-700">{{ $user->email }}</td>
                <td class="py-2 px-4 text-gray-700">{{ $user->role }}</td>
                <td class="py-2 px-4 text-gray-600">
                    {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Chưa đăng nhập' }}
                </td>
                <td class="py-2 px-4">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:underline">✏️ Sửa</a>

                    @if (Auth::id() !== $user->id)
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline delete-form ml-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">🗑️ Xóa</button>
                    </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="py-4 px-4 text-center text-gray-500">Không có người dùng nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Phân trang -->
<div class="mt-4">
    {{ $users->appends(request()->query())->links('pagination::tailwind') }}
</div>

<!-- SweetAlert confirm xóa -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Hành động này không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
