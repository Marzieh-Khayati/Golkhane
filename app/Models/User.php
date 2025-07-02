<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\DoctorProfile;
use App\Models\ConsultationSession;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'user_type',
        'first_name',
        'last_name',
        'is_active',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function doctor_profile():HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }  

    public function getProfileUrl()
    {
        if ($this->profile_picture) {
            return asset("{$this->profile_picture}");
        }
        return asset('images/avatars/default.jpg');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }   

    public function session():HasMany
    { 
        return $this->hasMany(ConsultationSession::class);
    }
}
