<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Morilog\Jalali\Jalali;
use App\Models\User;

class DoctorProfile extends Model
{
    //
    protected $fillable = [
        'user_id',
        'education',
        'career_start_year',
        'consultation_fee',
        'average_rating',
        'total_ratings',
        'bio',
    ];

     public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }  

    public function session():HasMany
    { 
        return $this->hasMany(ConsultationSession::class);
    }
}
