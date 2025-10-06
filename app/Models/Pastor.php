<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'bio',
        'photo',
        'kelompok',      // <-- TAMBAHKAN INI
        'commission_id', // <-- TAMBAHKAN INI
    ];

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }
}
