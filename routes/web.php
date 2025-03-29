<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AuthController::class, 'showadminForm'])->middleware('auth')->name('admin');

Route::get('/dashboard', function () {
    return view('dashboard');  
})->middleware('auth');

Route::get('/admin_users', [AuthController::class, 'showUsers'])->middleware('auth')->name('admin.users');

Route::post('/chatbot/ask', [AuthController::class, 'ask'])->name('chatbot.ask');