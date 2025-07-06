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
            // $nowJalali = Jalalian::now();
            // $formattedDate = $nowJalali->format('Y-m-d H:i:s');
        $session->update([
            'status' => 3,
            'ended_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'جلسه با موفقیت به پایان رسید'
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
        $status = $request->input('status', 2);
        $perPage = 10;
        
        $query = ConsultationSession::where('customer_id', $user)->orWhere('doctor_id', $user)
            ->withCount('messages')
            ->with(['messages' => function($query) {
                $query->latest()->limit(1);
            }]);
            
        if ($status === 2) {
            $query->where('status', 2);
        } elseif ($status === 3) {
            $query->where('status', 3);
        }
        
        $sessions = $query->latest()->paginate($perPage);
        
        return view('user_sessions', [
            'sessions' => $sessions,
            'currentStatus' => $status,
            'userId' => $user
        ]);
    }
}