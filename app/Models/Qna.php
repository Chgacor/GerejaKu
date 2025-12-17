<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qna extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'question',
        'answer',
        'answered_by',
        'answered_at',
        'is_published',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Relasi ke User (Penanya)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Admin yang menjawab (PENTING: Gunakan User::class)
     * Karena auth()->id() menyimpan ID dari tabel users.
     */
    public function answerer()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }
}
