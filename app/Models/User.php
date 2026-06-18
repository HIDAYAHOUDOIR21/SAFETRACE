<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }

    public function temoignages()
    {
        return $this->hasMany(Temoignage::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function abonnements()
    {
        return $this->hasMany(AbonnementAlerte::class);
    }

    public function signalements()
    {
        return $this->hasMany(SignalementAbus::class);
    }
}