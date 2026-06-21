<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'Siswa';
    protected $primaryKey = 'NISN';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Nama',
        'NISN',
        'JenisKelamin',
        'TempatLahir',
        'TanggalLahir',
        'Agama',
        'Kewarganegaraan',
        'AnakKeBRP',
        'JumlahSaudaraKandung',
        'JumlahSaudaraTiri',
        'AnakYatimPiatu',
        'JurusanPilihan',
        'UkuranBajuBatik',
        'UkuranBajuOlahraga',
        'PenerimaBantuan',
        'Alamat',
        'NoHP',
        'TinggalBersama',
        'AsalSekolahSMP',
        'TahunLulusSMP',
        'KdKelas',
        'KdOrangTua',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'KdKelas', 'KdKelas');
    }

    public function orangTua(): BelongsTo
    {
        return $this->belongsTo(OrangTua::class, 'KdOrangTua', 'KdOrangTua');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'NISN', 'NISN');
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'NISN', 'NISN');
    }
}
