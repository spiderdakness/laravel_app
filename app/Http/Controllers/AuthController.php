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

                // ✅ Cập nhật thời gian đăng nhập
            Auth::user()->update([
                'last_login_at' => now()
            ]);

            // 👉 Kiểm tra role thay vì ID
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/dashboard');
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
            // ✅ Gọi API tại cổng 8000 (FastAPI hoặc API AI bên ngoài)
            $response = Http::timeout(5)->post('http://127.0.0.1:8000/chatbot/ask', [
                'question' => $question
            ]);
    
            if ($response->successful()) {
                $data = $response->json();
            
            //     // ✅ Ghi lại log nếu người dùng đang đăng nhập
            // if (Auth::check()) {
            //     ChatbotLog::create([
            //         'user_id' => Auth::id(),
            //         'question' => $question
            //     ]);
            // }
                return response()->json([
                    'question' => $question,
                    'answer' => $data['answer']
                ]);
            }            
    
            return response()->json([
                'question' => $question,
                'answer' => '🚫 API không phản hồi thành công (mã ' . $response->status() . ')'
            ], 500);
    
        } catch (\Exception $e) {
            return response()->json([
                'question' => $question,
                'answer' => '🚫 Không thể kết nối API: ' . $e->getMessage()
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
    //hiển thị danh dách người dung
    public function showUsers()
    { 
        
        $users = User::orderBy('last_login_at', 'desc')->get();
            return view('admin.users.index', compact('users'));   
    }
}