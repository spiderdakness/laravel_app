<!DOCTYPE html>
<html lang="en">
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
            <div class="text-black flex space-x-4 mb-4">
                <input type="text" placeholder="Họ tên" id="name" name="name" required class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="text-black mb-4">
                <input type="email" placeholder="Email" id="email" name="email" required class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="text-black mb-4">
                <input type="password" placeholder="Mật khẩu" id="password" name="password" required class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="text-black mb-4">
                <input type="password" placeholder="Nhập lại mật khẩu" id="password_confirmation" name="password_confirmation" required class="w-full p-2 border border-gray-300 rounded">
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="terms" class="mr-2" required>
                <label for="terms" class="text-gray-500 text-sm">Tôi đồng ý với <a href="#" class="text-green-500">Điều khoản</a> & <a href="#" class="text-green-500">Chính sách</a></label>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600 transition">Đăng ký ngay</button>
        </form>

        <p class="text-center text-gray-500 mt-4">Đã có tài khoản? <a href="{{ route('login') }}" class="text-blue-500">Đăng nhập</a></p>
    </div>

</body>
</html>
