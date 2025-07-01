<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'type',
    ];

    public function session():BelongsTo
    { 
        return $this->belongsTo(ConsultationSession::class);
    }

    public function user():BelongsTo
    { 
        return $this->belongsTo(User::class);
    }
}
