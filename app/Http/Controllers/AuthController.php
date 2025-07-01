<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function checkAuth(Request $request, User $doctor)
    {
        // کاربر لاگین نکرده باشد
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'برای ارسال پیام به متخصص، لطفا وارد حساب کاربری خود شوید.',
                'register_url' => route('register') // مسیر صفحه لاگین Breeze
            ], 401);
        }

        // کاربر لاگین کرده باشد
        return response()->json([
            'success' => true,
            'payment_url' => route('doctor.payment', ['doctor' => $doctor->id])
        ]);
    }
}