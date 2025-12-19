<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaats';

    protected $fillable = [
        'user_id',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone_number',
        'profile_picture',
    ];

    // Pastikan birth_date dianggap sebagai object Date (Carbon)
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor: Menghitung Umur Otomatis
     * Cara panggil: $jemaat->age
     */
    public function getAgeAttribute()
    {
        // Menggunakan Carbon untuk menghitung umur presisi berdasarkan WIB (Asia/Jakarta)
        return Carbon::parse($this->birth_date)->age;
    }

    /**
     * Accessor: Menentukan Kategori Umur Otomatis
     * Cara panggil: $jemaat->kategori_umur
     */
    public function getKategoriUmurAttribute()
    {
        $age = $this->age;

        if ($age >= 1 && $age <= 11) {
            return 'Sekolah Minggu';
        } elseif ($age >= 12 && $age <= 18) {
            return 'Tunas & Remaja';
        } elseif ($age >= 19 && $age <= 59) {
            return 'Dewasa';
        } elseif ($age >= 60) {
            return 'Usia Indah';
        } else {
            return 'Balita / Belum Dikategorikan';
        }
    }

    /**
     * Scope: Filter berdasarkan Kategori Umur
     */
    public function scopeFilterByKategori(Builder $query, $kategori)
    {
        if (!$kategori) return $query;

        $now = Carbon::now();

        return $query->where(function ($q) use ($kategori, $now) {
            if ($kategori === 'sekolah_minggu') {
                // Lahir antara 11 tahun lalu s/d 1 tahun lalu
                $q->whereBetween('birth_date', [$now->copy()->subYears(11)->format('Y-m-d'), $now->copy()->subYears(1)->format('Y-m-d')]);
            } elseif ($kategori === 'remaja') {
                // Lahir antara 18 tahun lalu s/d 12 tahun lalu
                $q->whereBetween('birth_date', [$now->copy()->subYears(18)->format('Y-m-d'), $now->copy()->subYears(12)->format('Y-m-d')]);
            } elseif ($kategori === 'dewasa') {
                // Lahir antara 59 tahun lalu s/d 19 tahun lalu
                $q->whereBetween('birth_date', [$now->copy()->subYears(59)->format('Y-m-d'), $now->copy()->subYears(19)->format('Y-m-d')]);
            } elseif ($kategori === 'lansia') {
                // Lahir sebelum 60 tahun lalu
                $q->whereDate('birth_date', '<=', $now->copy()->subYears(60)->format('Y-m-d'));
            }
        });
    }

    /**
     * Scope: Filter Bulan Lahir
     */
    public function scopeFilterByBulan(Builder $query, $bulan)
    {
        if ($bulan) {
            return $query->whereMonth('birth_date', $bulan);
        }
        return $query;
    }

    /**
     * Scope: Filter Tahun Lahir
     */
    public function scopeFilterByTahun(Builder $query, $tahun)
    {
        if ($tahun) {
            return $query->whereYear('birth_date', $tahun);
        }
        return $query;
    }
}
