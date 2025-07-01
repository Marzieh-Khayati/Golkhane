<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use App\Models\ConsultationSession;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function showPaymentPage(User $doctor)
    {
        // نمایش صفحه پرداخت (مثلاً با اطلاعات متخصص)
         $user = auth()->user();
        
        return view('payment', [
            'doctor' => $doctor,
            'user' => $user
        ]);
    }

    public function processPayment(Request $request, User $doctor)
    {
        $user = auth()->user();
        
        // اعتبارسنجی موجودی کافی
        if ($user->credit < $doctor->doctor_profile->consultation_fee) {
            return back()->withErrors([
                'wallet' => 'موجودی کیف پول شما کافی نیست.'
            ]);
        }

        // اعتبارسنجی تایید پرداخت
        $request->validate([
            'confirm_payment' => 'required|accepted'
        ], [
            'confirm_payment.required' => 'لطفاً تاییدیه پرداخت را علامت بزنید.'
        ]);

        // انجام تراکنش
        try {
            \DB::transaction(function () use ($user, $doctor) {
                // کسر از کیف پول کاربر
                $user->decrement('credit', $doctor->doctor_profile->consultation_fee);
                
                // افزایش موجودی متخصص (در صورت نیاز)
                 $doctor->increment('credit', $doctor->doctor_profile->consultation_fee);
                
                // ذخیره اطلاعات تراکنش
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $doctor->doctor_profile->consultation_fee,
                    'description' => 'پرداخت برای مشاوره با ' . $doctor->first_name . $doctor->last_name,
                    'type' => 'consultation'
                ]);

                $nowJalali = Jalalian::now();
                $formattedDate = $nowJalali->format('Y-m-d H:i:s');
                ConsultationSession::create([ 
                    'customer_id'=> $user->id,
                    'doctor_id' => $doctor->id,
                    'start_time'=> $formattedDate,
                    'status' => 2,
                    'payment_amount' => $doctor->doctor_profile->consultation_fee,
                    'payment_status' => 2,
                    'transaction_id' => $transaction->id,
                ]);
            });
            
            return redirect()->route('doctor.chat', $doctor->id)
                             ->with('success', 'پرداخت با موفقیت انجام شد!');
            
        } catch (\Exception $e) {
            return back()->withErrors([
                'transaction' => 'خطا در انجام تراکنش: ' . $e->getMessage()
            ]);
        }
    }
}