<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key'; // <-- Tambahkan ini
    public $incrementing = false;    // <-- Tambahkan ini
    protected $keyType = 'string';   // <-- Tambahkan ini

    protected $fillable = ['key', 'value'];
}
