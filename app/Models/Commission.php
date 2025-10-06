<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'head_of_commission',
        'head_photo',
        'purpose',
        'management_structure',
    ];

    /**
     * Relasi ke artikel-artikel yang dimiliki komisi ini.
     */
    public function articles()
    {
        return $this->hasMany(CommissionArticle::class);
    }
}
