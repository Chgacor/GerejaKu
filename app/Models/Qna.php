<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qna extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
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
     * Relasi ke user (Jemaat) yang menjawab.
     */
    public function answerer()
    {
        return $this->belongsTo(Jemaat::class, 'answered_by');
    }
}
