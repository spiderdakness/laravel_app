<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Zen Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --secondary: #3b82f6;
            --dark: #1e293b;
            --light: #f8fafc;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            color: #334155;
        }
        .sidebar {
            background: linear-gradient(135deg, var(--dark), #0f172a);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .nav-link.active {
            background: var(--primary);
            font-weight: 500;
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: white;
            border-radius: 0 4px 4px 0;
        }
        .logout-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }
        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .stat-card {
            border-left: 4px solid var(--primary);
        }
        .header-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
        }
        .badge-primary {
            background-color: var(--primary);
            color: white;
        }
        .badge-secondary {
            background-color: var(--secondary);
            color: white;
        }
        /* Animation for notifications */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="min-h-screen flex">

    <!-- Sidebar -->
    <aside class="sidebar w-64 min-h-screen flex flex-col text-white">
        <!-- Logo -->
        <div class="p-6 flex items-center space-x-3 border-b border-slate-700">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center">
                <i class="fas fa-leaf text-green-500 text-xl"></i>
            </div>
            <h1 class="text-xl font-bold">Zen<span class="text-green-400">Admin</span></h1>
        </div>

        <!-- User Profile -->
        <div class="p-4 flex items-center space-x-3 border-b border-slate-700">
            <div class="relative">
                <img src="https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff" 
                     alt="Admin" class="w-10 h-10 rounded-full">
                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-slate-800"></span>
            </div>
            <div>
                <p class="font-medium">Admin</p>
                <p class="text-xs text-slate-300">Quản trị viên</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin') }}" 
               class="nav-link flex items-center space-x-3 py-3 px-4 {{ request()->routeIs('admin') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" 
               class="nav-link flex items-center space-x-3 py-3 px-4 {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fas fa-users w-5 text-center"></i>
                <span>Tài khoản</span>
            </a>

            <a href="#" class="nav-link flex items-center space-x-3 py-3 px-4">
                <i class="fas fa-cog w-5 text-center"></i>
                <span>Cài đặt</span>
            </a>
            <!-- <a href="#" class="nav-link flex items-center space-x-3 py-3 px-4">
                <i class="fas fa-chart-line w-5 text-center"></i>
                <span>Thống kê</span>
            </a> -->
            <!-- <a href="#" class="nav-link flex items-center space-x-3 py-3 px-4">
                <i class="fas fa-bell w-5 text-center"></i>
                <span>Thông báo</span>
                <span class="w-2 h-2 bg-red-500 rounded-full ml-auto pulse"></span>
            </a> -->
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-slate-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn w-full py-2 px-4 rounded-lg flex items-center justify-center space-x-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between p-4">
                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 focus:outline-none lg:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-500 focus:outline-none">
                            <i class="fas fa-bell"></i>
                            <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff" 
                                 alt="Admin" class="w-8 h-8 rounded-full">
                            <span class="hidden md:inline-block">Admin</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <!-- Page Header -->
            <div class="header-gradient text-white rounded-xl p-6 mb-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-white/90">@yield('page-description', 'Tổng quan hệ thống')</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm">Hôm nay: {{ now()->format('d/m/Y') }}</span>
                            <span class="text-white/50">|</span>
                            <span class="text-sm"><i class="fas fa-circle text-green-300 mr-1"></i> Trực tuyến</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            @unless(request()->routeIs('admin.users'))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Tổng người dùng -->
                <div class="card stat-card p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500">Tổng người dùng</p>
                            <h3 class="text-2xl font-bold mt-1"> {{ isset($totalUsers) ? $totalUsers : '-' }}</h3>
                            <p class="text-green-500 text-sm mt-2">
                                <i class="fas fa-arrow-up mr-1"></i> {{ isset($growthRate) ? $growthRate : '0' }}%
                            </p>

                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-users text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endunless
            <!-- Main Content -->
            <div class="card p-6 mb-6">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="text-center text-gray-500 text-sm mt-8">
                <p>Zen Admin Panel &copy; {{ date('Y') }} - Phát triển bởi <span class="text-green-500">Thiền Chat Team</span></p>
            </footer>
        </main>
    </div>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.lg\\:hidden');
            const sidebar = document.querySelector('.sidebar');
            
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
            });
            
            // Active nav link indicator
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.classList.contains('active')) {
                    link.style.transform = 'translateX(5px)';
                }
            });
        });
    </script>
</body>
</html>