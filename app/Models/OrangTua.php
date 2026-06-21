<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrangTua extends Model
{
    protected $table = 'OrangTua';
    protected $primaryKey = 'KdOrangTua';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdOrangTua',
        'NamaAyah',
        'TempatLahirAyah',
        'TanggalLahirAyah',
        'AgamaAyah',
        'KewarganegaraanAyah',
        'PendidikanTerakhirAyah',
        'PekerjaanAyah',
        'PenghasilanAyah',
        'AlamatAyah',
        'NamaIbu',
        'TempatLahirIbu',
        'TanggalLahirIbu',
        'AgamaIbu',
        'KewarganegaraanIbu',
        'PendidikanTerakhirIbu',
        'PekerjaanIbu',
        'PenghasilanIbu',
        'AlamatIbu',
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'KdOrangTua', 'KdOrangTua');
    }
}
