<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'speaker',
        'service_time',
        'division_id',
        'image',
        'description',
    ];

    protected $casts = [
        'service_time' => 'datetime',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
