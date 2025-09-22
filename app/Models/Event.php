<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'start_time', 'end_time',
        'speaker', 'division_id', 'type', 'image', 'is_featured', 'color'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
