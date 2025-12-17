<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaats';
    // Data autentikasi dihapus dari sini karena sudah ada di User
    protected $fillable = [
        'user_id',
        'full_name',        // Pengganti nama_lengkap
        'gender',           // Pengganti kelamin
        'birth_place',      // Pengganti tempat_lahir
        'birth_date',       // Pengganti tanggal_lahir
        'address',          // Pengganti alamat
        'phone_number',     // Pengganti no_telepon
        'profile_picture',  // Pengganti foto_profil
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
