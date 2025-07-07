<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Models\ConsultationSession;
use App\Models\User;
use App\Http\Middleware\CheckUserAccessToSessionsList;
use App\Http\Middleware\CheckUserAccessToChat;
use App\Http\Middleware\EnsureUserIsAdmin;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('doctors', [UserController::class, 'doctors']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/doctors/{id}', [UserController::class, 'show_doctor'])->name('doctors.show');

// این Routeها فقط برای کاربران لاگین‌شده قابل دسترسی هستند
Route::middleware('auth')->group(function () {
    // نمایش صفحه پرداخت
    Route::get('/doctors/{doctor}/payment', [PaymentController::class, 'showPaymentPage'])->name('doctor.payment');
    // پردازش پرداخت
    Route::post('/doctors/{doctor}/process-payment', [PaymentController::class, 'processPayment'])->name('doctor.process-payment');
    // صفحه چت پس از پرداخت
    Route::get('/{userId}/{sessionId}/chat', [ChatController::class, 'showChat'])->middleware(CheckUserAccessToChat::class.':{userId}'.'{sessionId}')->name('doctor.chat');
});

// Route برای بررسی لاگین بودن کاربر (از طریق Ajax)
Route::post('/doctors/{doctor}/check-auth', [AuthController::class, 'checkAuth'])->name('doctor.check-auth');

// در routes/web.php
Route::middleware('auth')->group(function () {
    Route::post('/sessions/{session}/end', [ChatController::class, 'endSession'])
         ->name('session.end');
});

Route::middleware(['auth'])->post('/send-message', [ChatController::class, 'sendMessage'])->name('send-message');

Route::get('/{user}/sessions', [ChatController::class, 'index'])->middleware(['auth',CheckUserAccessToSessionsList::class.':{user}'])->name('user.sessions');

Route::get('/admin-pannel', [AdminController::class, 'index'])->middleware(['auth', EnsureUserIsAdmin::class])->name('admin-pannel');


require __DIR__.'/auth.php';
