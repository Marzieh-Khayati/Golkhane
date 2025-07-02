<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConsultationSession;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    //
    protected $fillable = [
        'session_id',
        'sender_id',
        'message_text',
        'is_read',
    ];

    public function session():BelongsTo
    { 
        return $this->belongsTo(ConsultationSession::class);
    }
}
