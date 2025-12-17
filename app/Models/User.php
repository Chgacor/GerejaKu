<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi massal.
     * Kita gunakan kolom 'name' untuk menyimpan 'username'.
     */
    protected $fillable = [
        'name',     // Ini akan menyimpan data 'username'
        'email',
        'password',
        'role',     // Pastikan kolom ini ada di tabel users, atau hapus jika tidak pakai role
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke tabel profil Jemaat
    public function jemaat()
    {
        return $this->hasOne(Jemaat::class);
    }
}
