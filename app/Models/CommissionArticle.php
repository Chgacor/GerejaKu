<?php

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

    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }

    // === TAMBAHKAN INI ===
    /**
     * Beritahu Laravel untuk mencari data berdasarkan SLUG, bukan ID.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
