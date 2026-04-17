<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function isPengurus(): bool
    {
        return $this->role === 'pengurus';
    }

    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    public function getDashboardRoute(): string
    {
        return match($this->role) {
            'pengurus'  => '/pengurus/dashboard',
            'bendahara' => '/bendahara/dashboard',
            default     => '/user/dashboard',
        };
    }

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
}
