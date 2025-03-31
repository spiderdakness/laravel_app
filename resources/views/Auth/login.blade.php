<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Chatbot Phật Giáo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e');
            background-size: cover;
            background-position: center;
        }

        .backdrop {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="backdrop rounded-xl shadow-xl p-10 w-full max-w-md text-white border border-white/30">
        <h2 class="text-3xl font-bold text-center mb-6">Đăng nhập Chatbot Phật Giáo</h2>

        <!-- Thông báo lỗi -->
        @if ($errors->any())
            <div class="mb-4 bg-red-500 bg-opacity-70 text-white p-2 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form đăng nhập -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 rounded bg-white/80 text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 rounded bg-white/80 text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded transition">
                Đăng nhập
            </button>
        </form>

        <p class="text-center mt-4 text-sm">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="text-green-300 hover:underline">Đăng ký ngay</a>
        </p>
    </div>

</body>
</html>