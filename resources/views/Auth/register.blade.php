<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://images.unsplash.com/photo-1533045812573-97218e72dd28?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
        }

        .backdrop {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-700 flex items-center justify-center min-h-screen">

    <div class="backdrop rounded-xl shadow-xl p-10 w-full max-w-md text-white border border-white/30">
        <h2 class="text-2xl font-semibold text-center mb-4">Đăng ký tài khoản</h2>

        <!-- Hiển thị lỗi -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-1">Họ tên</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full p-2 border border-gray-300 rounded text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('name')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full p-2 border border-gray-300 rounded text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium mb-1">Mật khẩu</label>
                <input type="password" id="password" name="password" required
                       class="w-full p-2 border border-gray-300 rounded text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium mb-1">Nhập lại mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full p-2 border border-gray-300 rounded text-black focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('password_confirmation')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" id="terms" name="terms" required class="mr-2">
                <label for="terms" class="text-gray-300 text-sm">
                    Tôi đồng ý với <a href="#" class="text-green-500 hover:underline">Điều khoản</a> & 
                    <a href="#" class="text-green-500 hover:underline">Chính sách</a>
                </label>
                @error('terms')
                    <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600 transition">
                Đăng ký ngay
            </button>
        </form>

        <p class="text-center text-gray-300 mt-4">
            Đã có tài khoản? <a href="{{ route('login') }}" class="text-green-500 hover:underline">Đăng nhập</a>
        </p>
    </div>

</body>
</html>