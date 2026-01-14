<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',         // Ini kita pakai sebagai Nama Lengkap / Display Name
        'username',     // Kolom baru untuk login unik
        'email',
        'password',
        'role',         // admin, user, gembala, pengurus
        'is_approved',  // 1 = Aktif/Disetujui, 0 = Pending
        'password_reset_requested_at', // Timestamp request reset
        'no_telepon',   // Opsional jika ada fitur profil
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean', // Pastikan dicast ke boolean
            'password_reset_requested_at' => 'datetime',
        ];
    }

    // Relasi ke Data Jemaat
    public function jemaat()
    {
        return $this->hasOne(Jemaat::class, 'user_id');
    }

    // Helper cek role
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
