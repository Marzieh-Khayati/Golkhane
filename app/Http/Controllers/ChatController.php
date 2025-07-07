<?php

namespace App\Http\Controllers;

use App\Models\ConsultationSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * نمایش صفحه چت
     */
    public function showChat($userId, $sessionId)
    {

        $session = ConsultationSession::find($sessionId);
        return view('chat', [
            'consultationSession' => $session,
            'doctor' => $session->doctor,
            'messages' => $session->messages,
            'is_active' => $session->status === 'active'
        ]);
    }

// تابع جدید برای پایان جلسه
    public function endSession(Request $request, $sessionId)
    {
        $session = ConsultationSession::where('id', $sessionId)
            ->where('doctor_id', auth()->id())
            ->firstOrFail();

        $updateData = [
            'status' => 'completed', // یا 3 اگر عددی است
            'ended_at' => Carbon::now()->toDateTimeString() // یا now()
        ];

        $session->update($updateData);

        return response()->json([
            'success' => $session->wasChanged(),
            'message' => $session->wasChanged() 
                ? 'جلسه با موفقیت به پایان رسید' 
                : 'تغییری در وضعیت جلسه ایجاد نشد',
            'ended_at' => $session->ended_at
        ]);
    }

    /**
     * ارسال پیام جدید
     */
    // در Controller مربوطه
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:consultation_sessions,id',
            'message' => 'required|string|max:1000'
        ]);

        try {
            $message = ChatMessage::create([
                'session_id' => $validated['session_id'],
                'sender_id' => auth()->id(),
                'message_text' => $validated['message'],
                'is_read' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'html' => view('partialsMessage', ['message' => $message])->render()
            ]);

        } catch (\Exception $e) {
            \Log::error('SendMessage error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'خطا در ذخیره پیام: ' . $e->getMessage() // فقط برای تست
            ], 500);
        }
    }

    public function index(Request $request, $user)
    {
        $status = $request->input('status', 'active');
        $perPage = 10;
        
        $query = ConsultationSession::where(function($q) use ($user) {
            $q->where('customer_id', $user)
            ->orWhere('doctor_id', $user);
        })
        ->withCount('messages')
        ->with(['messages' => function($query) {
            $query->latest()->limit(1);
        }]);
        
        // فیلتر وضعیت با منطق بهینه‌تر
        $validStatuses = ['active', 'completed'];
        if (in_array($status, $validStatuses)) {
            $query->where('status', $status);
        } else {
            // حالت پیش‌فرض اگر وضعیت نامعتبر بود
            $query->where('status', 'active');
            $status = 'active';
        }
        
        $sessions = $query->latest()->get();
        
        return view('user_sessions', [
            'sessions' => $sessions,
            'currentStatus' => $status,
            'userId' => $user
        ]);
    }
}