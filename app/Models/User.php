<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phonenumber',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function registeredEnterprises()
    {
        return $this->hasMany(Entreprise::class, 'registeredby');
    }

    public function receivedComplaints()
    {
        return $this->hasMany(Complaint::class, 'receiver');
    }

    public function investigatedComplaints()
    {
        return $this->hasMany(Complaint::class, 'investigator');
    }

    public function filledSummons()
    {
        return $this->hasMany(Summon::class, 'filledby');
    }

    public function filledFines()
    {
        return $this->hasMany(Fine::class, 'filledby');
    }
}
