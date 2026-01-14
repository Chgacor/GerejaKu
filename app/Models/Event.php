<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',             // Ibadah, Acara, Latihan
        'description',
        'start_time',
        'end_time',
        'speaker',          // Nullable
        'division_id',      // Nullable
        'image',            // Nullable
        'is_featured',      // <--- WAJIB ADA
        'color',            // <--- WAJIB ADA
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'is_featured' => 'boolean', // Agar otomatis jadi true/false
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
