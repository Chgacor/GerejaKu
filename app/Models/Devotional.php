<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devotional extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'scripture_reference',
        'content',
    ];
}
