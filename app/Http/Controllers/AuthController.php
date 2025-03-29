<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form 
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            // ✅ Ghi lại thời gian đăng nhập
            Auth::user()->update([
                'last_login_at' => now()
            ]);
    
            if (Auth::id() == 1) {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/');
            }
        }
    
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }
    
    // Show Register form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle Registration 
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Correct the create method to use ::create
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Thêm role mặc định
        ]);

        // Log the user in after registration
        Auth::login($user);

        return redirect('/dashboard');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:1000'
        ]);
    
        $question = $request->input('question');
    
        try {
            // Gọi API lấy answer
            $response = Http::post('http://127.0.0.1:8000/chatbot/ask', [
                'question' => $question
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
    
                // ✅ Trả về đúng format bạn cần
                return response()->json([
                    'question' => $question,
                    'answer' => $data['answer']
                ]);
            }
    
            // Nếu không thành công
            return response()->json([
                'question' => $question,
                'answer' => '🚫 API không phản hồi thành công (mã ' . $response->status() . ')'
            ], 500);
    
        } catch (\Exception $e) {
            // Trường hợp lỗi hệ thống
            return response()->json([
                'question' => $question,
                'answer' => '🚫 Lỗi hệ thống khi gọi API: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showadminForm()
    {
        if (Auth::id() !== 1) {
            abort(403, 'Bạn không có quyền truy cập trang admin.');
        }
    
        $userCount = User::count(); // 👈 đếm tổng số tài khoản
    
        return view('admin.admin', compact('userCount'));
    }
    
    public function showUsers()
    {
        $users = \App\Models\User::whereNotNull('last_login_at')
                    ->orderByDesc('last_login_at')
                    ->get();
    
        return view('admin.admin_users', compact('users'));
    }


}