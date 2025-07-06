<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// در routes/channels.php
Broadcast::channel('chat.{sessionId}', function ($user, $sessionId) {
    return ConsultationSession::where('id', $sessionId)
        ->where(function($query) use ($user) {
            $query->where('doctor_id', $user->id)
                  ->orWhere('patient_id', $user->id);
        })->exists();
});
