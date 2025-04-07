@extends('admin.admin')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ $editMode ? 'Sửa tài khoản' : 'Thêm tài khoản' }}
        </h2>
        <a href="{{ route('admin.users') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <!-- Form Container -->
    <div class="card flex-1">
        <form method="POST" 
              action="{{ $editMode ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
              class="space-y-5 p-6">
            @csrf
            @if($editMode)
                @method('PUT')
            @endif

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Tên người dùng <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $user->name ?? '') }}"
                       required
                       class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" 
                       value="{{ old('email', $user->email ?? '') }}"
                       required
                       class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Mật khẩu {{ $editMode ? '(để trống nếu không đổi)' : '' }}
                    @if(!$editMode)<span class="text-red-500">*</span>@endif
                </label>
                <input type="password" name="password" id="password"
                       {{ $editMode ? '' : 'required' }}
                       class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role Field -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                    Vai trò <span class="text-red-500">*</span>
                </label>
                <select name="role" id="role" required
                        class="input-field w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="user" {{ old('role', $user->role ?? '') === 'user' ? 'selected' : '' }}>Người dùng</option>
                    <option value="admin" {{ old('role', $user->role ?? '') === 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                </select>
            </div>

            <!-- Status Field (for edit mode) -->
            @if($editMode)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_active" value="1" 
                               {{ old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Hoạt động</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="is_active" value="0"
                               {{ !old('is_active', $user->is_active ?? 1) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700">Không hoạt động</span>
                    </label>
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="flex justify-end pt-4">
                <button type="submit" 
                        class="btn-primary">
                    <i class="fas {{ $editMode ? 'fa-save' : 'fa-plus' }} mr-2"></i>
                    {{ $editMode ? 'Cập nhật' : 'Thêm mới' }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .card {
        @apply bg-white rounded-lg shadow-sm border border-gray-200;
    }
    
    .btn-primary {
        @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition;
    }
    
    .btn-secondary {
        @apply inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition;
    }
    
    .input-field {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50;
    }
</style>
@endsection