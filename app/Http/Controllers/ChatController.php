<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function showChat(User $doctor)
    {
        // بررسی آیا کاربر پرداخت را انجام داده (مثلاً از طریق جدول payments)
        // اگر پرداخت شده، چت را نمایش بده
        return view('chat', ['doctor' => $doctor]);
    }
}