<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /** Peran pengguna internal. */
    public const ROLE_ADMIN = 'admin';

    public const ROLE_TEACHER = 'teacher';

    public const ROLE_TRANSLATOR = 'translator';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_TEACHER => 'Guru',
        self::ROLE_TRANSLATOR => 'Penerjemah',
    ];

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

    /**
     * Default atribut — selaras dengan default kolom DB (role = admin).
     * Penting agar instance baru (belum disimpan/direfresh) langsung dianggap admin.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'role' => self::ROLE_ADMIN,
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
            'role' => 'string',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTeacher(): bool
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isTranslator(): bool
    {
        return $this->role === self::ROLE_TRANSLATOR;
    }

    /**
     * Matriks akses panel:
     *  - /admin     → hanya admin (IP allowlist tetap aktif di panel ini)
     *  - /training  → admin + guru
     *  - /translate → admin + penerjemah
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin(),
            'training' => $this->isAdmin() || $this->isTeacher(),
            'translate' => $this->isAdmin() || $this->isTranslator(),
            default => false,
        };
    }
}
