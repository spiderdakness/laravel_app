<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Phật Giáo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        background-image: url('https://images.unsplash.com/photo-1595733046511-34bcc61b5d0b?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDQzfHx8ZW58MHx8fHx8'); /* Ảnh thiền tông */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .backdrop {
        backdrop-filter: blur(8px);
        background-color: rgba(255, 255, 255, 0.2);
    }
</style>
</head>

<body class="min-h-screen flex items-center justify-center">

    <!-- Top Right: User Info + Logout -->
    <div class="absolute top-4 right-6 flex items-center space-x-4">
        <p class="text-white font-semibold">
            Xin chào, {{ Auth::check() ? Auth::user()->name : 'Khách' }}
        </p>
        @if(Auth::check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    Đăng xuất
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                Đăng nhập
            </a>
        @endif
    </div>

    <!-- Chatbot Interface -->
    <div class=" backdrop rounded-xl shadow-xl p-10 w-full max-w-3xl text-white border border-white/30">
        <h1 class="text-4xl font-extrabold text-center text-green-600 mb-8">🧘 Chatbot Phật Giáo</h1>

        <!-- Input -->
        <div class="mb-6">
            <label for="question" class="block text-lg font-medium text-gray-800 mb-2">📝 Câu hỏi của bạn:</label>
            <textarea id="question" rows="4"
                      class="w-full p-4 border text-black border-green-400 rounded-lg focus:ring-2 focus:ring-green-300 focus:outline-none transition"
                      placeholder=""></textarea>
        </div>

        <!-- Button -->
        <div class="mb-6 text-center">
            <button id="askButton"
                    class="bg-green-500 text-white py-3 px-6 rounded-lg font-semibold text-lg hover:bg-green-600 transition">
                Gửi Câu Hỏi
            </button>
        </div>

        <!-- Output -->
        <div>
            <label for="answer" class="block text-lg font-medium text-gray-800 mb-2">💬 Câu trả lời từ Chatbot:</label>
            <textarea id="answer" rows="6"
                      class="w-full p-4 border border-gray-300 rounded-lg bg-gray-100 text-gray-700" readonly></textarea>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const submitButton = document.getElementById("askButton");

        submitButton.addEventListener("click", async function () {
            const question = document.getElementById("question").value.trim();
            const answerBox = document.getElementById("answer");

            if (!question) {
                answerBox.value = "Vui lòng nhập câu hỏi.";
                return;
            }

            answerBox.value = "Đang xử lý...";

            try {
                const response = await fetch('http://127.0.0.1:8000/chatbot/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'API-Key': '123'
                    },
                    body: JSON.stringify({ question: question })
                });

                if (response.ok) {
                    const data = await response.json();
                    answerBox.value = data.answer || 'Không có câu trả lời.';
                } else {
                    answerBox.value = 'Lỗi kết nối (mã: ' + response.status + ')';
                }
            } catch (error) {
                answerBox.value = 'Lỗi: ' + error.message;
            }
        });
    });
    </script>


</body>
</html>
