<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DoctorProfile;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ConsultationSession extends Model
{
     protected $fillable = [
        'customer_id',
        'doctor_id',
        'start_time',
        'end_tyme',
        'status',
        'payment_amount',
        'payment_status',
        'transaction_id'
    ];

    public function doctor():BelongsTo
    {
        return $this->BelongsTo(DoctorProfile::class);
    }  
    public function transaction():HasOne
    { 
        return $this->hasOne(Transaction::class);
    }
}
