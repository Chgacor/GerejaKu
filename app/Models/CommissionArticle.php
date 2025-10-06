<?php

// app/Models/CommissionArticle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'commission_id',
        'title',
        'slug',
        'author',
        'category',
        'content',
        'cover_image',
        'published_at',
    ];

    /**
     * Relasi ke komisi pemilik artikel.
     */
    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }
}
