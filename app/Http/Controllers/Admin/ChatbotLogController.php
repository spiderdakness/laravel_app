<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ChatbotLogController extends Controller
{
    public function index()
    {
        $stats = User::withCount('chatbotLogs')
            ->orderByDesc('chatbot_logs_count')
            ->get();

        return view('admin.chatbot.index', compact('stats'));
    }   
}
