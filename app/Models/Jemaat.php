<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaats';

    // Sesuaikan dengan database baru (Bahasa Inggris)
    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone_number',
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
