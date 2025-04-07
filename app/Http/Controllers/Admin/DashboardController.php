<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        
        return view('admin.admin', [
            'totalUsers' => $totalUsers,
            'questionCount' => 0 // Giá trị mặc định
        ]);
    }
}
