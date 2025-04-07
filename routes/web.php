<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;

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

//Route::post('/chatbot/ask', [AuthController::class, 'ask'])->name('chatbot.ask');
Route::post('/chatbot/ask', [AuthController::class, 'ask']) ->middleware('auth') ->name('chatbot.ask');


//Route::get('/index', [AuthController::class, 'showUsers'])->middleware('auth')->name('admin.index');

Route::prefix('admin_users')->middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('admin.users');
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

//của chat bot
// Route::get('/admin/chatbot', [ChatbotLogController::class, 'index'])->middleware('auth')->name('admin.chatbot');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
});