<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationSession extends Model
{
     protected $fillable = [
        'customer_id',
        'doctor_id',
        'start_time',
        'ended_at',
        'status',
        'payment_amount',
        'payment_status',
        'transaction_id'
    ];

    public function doctor():BelongsTo
    {
        return $this->BelongsTo(User::class);
    }  
    public function transaction():HasOne
    { 
        return $this->hasOne(Transaction::class);
    }
    public function messages():HasMany
    { 
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    // public function getStartTimeJalaliAttribute()
    // {
    //     if (!$this->start_time) {
    //         return '--:--';
    //     }

    //     try {
    //         return \Morilog\Jalali\Jalalian::fromDateTime($this->start_time)->format('H:i');
    //     } catch (\Exception $e) {
    //         \Log::error('Jalali conversion failed', [
    //             'id' => $this->id,
    //             'start_time' => $this->start_time,
    //             'error' => $e->getMessage()
    //         ]);
    //         return '--:--';
    //     }
    // }
}
