<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_INOVATOR = 'inovator';

    public const ROLE_VERIFIKATOR = 'verifikator';

    public const ROLE_ADMIN = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'instansi', 'aktif', 'login_terakhir',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token'];

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
            'aktif' => 'boolean',
            'login_terakhir' => 'datetime',
        ];
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function keputusan()
    {
        return $this->hasMany(VerificatorDecision::class, 'diputuskan_oleh');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
