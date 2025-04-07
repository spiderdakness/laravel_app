<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chatbot Phật Giáo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #ffffff; /* White background */
        }
        .user-message {
            background-color: #e3f2fd; /* Light blue for user */
            border-radius: 12px;
            padding: 12px 16px;
        }
        .bot-message {
            background-color: #f7f7f8; /* Light gray for bot like ChatGPT */
            border-radius: 12px;
            padding: 12px 16px;
        }
        .send-btn {
            transition: all 0.3s ease;
        }
        .send-btn:hover {
            transform: translateY(-2px);
            background-color: #4caf50 !important;
        }
        /* Hide scrollbar but keep scrolling functionality */
        .scrollbar-hidden {
            -ms-overflow-style: none; /* IE and Edge */
            scrollbar-width: none; /* Firefox */
        }
        .scrollbar-hidden::-webkit-scrollbar {
            display: none; /* Chrome, Safari, and Opera */
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .spinner {
            animation: spin 1s linear infinite;
        }
        /* Dynamic textarea */
        #question {
            min-height: 48px;
            max-height: 200px; /* Limit max height */
            resize: none;
            overflow-y: auto;
            width: 100%;
            box-sizing: border-box;
        }
        /* Ensure chat area scrolls properly */
        #chatArea {
            flex: 1 1 auto; /* Allow the chat area to grow and shrink */
            overflow-y: auto; /* Enable vertical scrolling */
            max-height: calc(100vh - 300px); /* Initial height with welcome message */
            padding-bottom: 20px; /* Add padding to ensure content isn't cut off */
            transition: max-height 0.3s ease; /* Smooth transition for height change */
            scroll-behavior: smooth; /* Smooth scrolling */
        }
        /* Expanded chat area when welcome message is hidden */
        #chatArea.expanded {
            max-height: calc(100vh - 200px); /* Adjust height to take up more space */
        }
        /* Welcome message with transition for hiding */
        #welcome-message {
            transition: opacity 0.3s ease, height 0.3s ease;
            height: auto;
            opacity: 1;
        }
        #welcome-message.hidden {
            opacity: 0;
            height: 0;
            margin-bottom: 0;
            overflow: hidden;
        }
        /* Styling for the logout button */
        .logout-btn {
            background: linear-gradient(0deg,rgb(58, 230, 81),rgb(58, 230, 81)); /* Gradient background */
            color: white;
            padding: 8px 16px;
            border-radius: 5px; /* More rounded corners */
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px; /* Space between icon and text */
            box-shadow: 0 10px 8px rgba(90, 29, 29, 0.1); /* Subtle shadow */
            transition: all 0.3s ease; /* Smooth transition for hover effects */
        }
        .logout-btn:hover {
            background: linear-gradient(135deg,rgb(230, 13, 13),rgb(230, 13, 13)); /* Darker gradient on hover */
            transform: translateY(-2px); /* Slight lift on hover */
            box-shadow: 0 12px 12px rgba(0, 0, 0, 0.15); /* Enhanced shadow on hover */
        }
        .logout-btn svg {
            width: 16px;
            height: 16px;
        }
    </style>
</head>
<body class="h-screen flex flex-col">
    <!-- Header with Logo and User Info -->
    <header class="bg-white shadow-sm py-4 px-6 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="https://img.icons8.com/color/48/000000/lotus.png" alt="Lotus Logo" class="w-10 h-10">
            <h1 class="text-2xl font-bold text-green-800">Thiền Chat</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <p class="font-medium text-gray-700">
                {{ Auth::check() ? Auth::user()->name : 'Khách' }}
            </p>
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        Login
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                    Đăng nhập
                </a>
            @endif
        </div>
    </header>

    <!-- Main Chat Area -->
    <main class="flex-1 overflow-hidden px-4 py-6 max-w-5xl mx-auto w-full my-4 flex flex-col">
        <!-- Welcome Message -->
        <div id="welcome-message" class="text-center mb-6">
            <h2 class="text-3xl font-bold text-green-700 mb-2">Chào mừng đến với Thiền Chat</h2>
            <p class="text-gray-600">Hỏi tôi bất cứ điều gì về Phật giáo, thiền định và cuộc sống an lạc</p>
        </div>
        
        <!-- Chat Messages -->
        <div id="chatArea" class="scrollbar-hidden space-y-6 px-2"></div>
    </main>

    <!-- Input Area -->
    <footer class="p-4 bg-white shadow-inner">
        <div class="max-w-5xl mx-auto w-full">
            <form id="chatForm" class="relative">
                <div class="flex items-end">
                    <!-- Emoji Picker Button (placeholder) -->
                    <button type="button" class="mr-2 p-2 text-gray-500 hover:text-green-600 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    
                    <!-- Text Input -->
                    <textarea id="question" placeholder="Nhập câu hỏi về Phật giáo..." 
                        class="flex-1 py-3 px-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-300 text-base"></textarea>
                    
                    <!-- Send Button -->
                    <button type="submit" class="ml-2 w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600 transition send-btn shadow-md"
                        title="Gửi câu hỏi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transform rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                        </svg>
                    </button>
                </div>
            </form>
            
            <!-- Suggested Questions -->
            <div class="mt-3 flex flex-wrap gap-2">
                <button class="suggested-question text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-gray-700">Thiền là gì?</button>
                <button class="suggested-question text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-gray-700">Làm sao để tâm an?</button>
                <button class="suggested-question text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-gray-700">Ý nghĩa của Tứ Diệu Đế</button>
                <button class="suggested-question text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full text-gray-700">Cách thực hành chánh niệm</button>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("chatForm");
        const questionInput = document.getElementById("question");
        const chatArea = document.getElementById("chatArea");
        const welcomeMessage = document.getElementById("welcome-message");
        const suggestedQuestions = document.querySelectorAll('.suggested-question');
        
        // Auto-resize textarea
        questionInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Suggested questions click handler
        suggestedQuestions.forEach(btn => {
            btn.addEventListener('click', function() {
                questionInput.value = this.textContent;
                questionInput.focus();
            });
        });
        
        // Handle Enter key (Shift+Enter for new line)
        questionInput.addEventListener("keydown", function (e) {
            if (e.key === "Enter" && !e.shiftKey) {
                e.preventDefault();
                form.dispatchEvent(new Event("submit"));
            }
        });
        
        // Hide welcome message and expand chat area on scroll
        chatArea.addEventListener('scroll', function() {
            if (chatArea.scrollTop > 0) { // If user scrolls down
                welcomeMessage.classList.add('hidden');
                chatArea.classList.add('expanded');
            } else { // If user scrolls back to the top
                welcomeMessage.classList.remove('hidden');
                chatArea.classList.remove('expanded');
            }
        });
        
        // Form submission
        form.addEventListener("submit", async function (e) {
            e.preventDefault();
            const question = questionInput.value.trim();
            if (!question) return;
            
            // Reset textarea height
            questionInput.style.height = 'auto';
            
            // Add user message to chat
            addMessageToChat('user', question);
            questionInput.value = "";
            
            // Show loading indicator with spinner
            const loadingId = "loading-" + Date.now();
            chatArea.innerHTML += `
                <div id="${loadingId}" class='flex items-center space-x-3 p-3'>
                    <div class='w-8 h-8 rounded-full bg-green-100 flex items-center justify-center'>
                        <img src="https://img.icons8.com/color/48/000000/lotus.png" class="w-6 h-6">
                    </div>
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-full p-2">
                        <div class="spinner w-5 h-5 border-2 border-green-500 border-t-transparent rounded-full"></div>
                        <span class="text-sm text-gray-600">Đang suy nghĩ...</span>
                    </div>
                </div>
            `;
            chatArea.scrollTo({ top: chatArea.scrollHeight, behavior: 'smooth' }); // Smooth scroll to bottom
            
            try {
                const response = await fetch('http://127.0.0.1:8000/chatbot/ask', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'API-Key': '123'
                    },
                    body: JSON.stringify({ question: question })
                });
                
                const data = await response.json();
                
                // Remove loading and add bot response
                const loadingEl = document.getElementById(loadingId);
                if (loadingEl) loadingEl.remove();
                
                addMessageToChat('bot', data.answer || 'Xin lỗi, tôi không hiểu câu hỏi của bạn. Bạn có thể diễn đạt lại không?');
                
            } catch (error) {
                const loadingEl = document.getElementById(loadingId);
                if (loadingEl) {
                    loadingEl.outerHTML = `
                        <div class='p-3 text-red-500'>
                            Đã xảy ra lỗi khi kết nối. Vui lòng thử lại sau.
                        </div>
                    `;
                }
            }
        });
        
        // Helper function to add messages to chat
        function addMessageToChat(sender, message) {
            if (sender === 'user') {
                chatArea.innerHTML += `
                    <div class='flex justify-end'>
                        <div class='user-message max-w-xl'>
                            ${message}
                        </div>
                    </div>
                `;
            } else {
                chatArea.innerHTML += `
                    <div class='flex items-start space-x-3'>
                        <div class='w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0'>
                            <img src="https://img.icons8.com/color/48/000000/lotus.png" class="w-6 h-6">
                        </div>
                        <div class='bot-message max-w-xl'>
                            ${message}
                        </div>
                    </div>
                `;
            }
            chatArea.scrollTo({ top: chatArea.scrollHeight, behavior: 'smooth' }); // Smooth scroll to bottom
        }
        
        // Add welcome message from bot
        setTimeout(() => {
            addMessageToChat('bot', 'Xin chào! Tôi là Thiền Chat, chatbot về tra cứu Phật giáo. Tôi có thể giúp gì cho bạn hôm nay?');
        }, 500);
    });
    </script>
</body>
</html>