<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    protected $table = 'Staff';
    protected $primaryKey = 'NIY';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NIY',
        'Nama',
        'TempatLahir',
        'TanggalLahir',
        'JenisKelamin',
        'PendidikanTerakhir',
        'Jabatan',
        'NoHP',
        'Alamat',
    ];

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'KdStaff', 'NIY');
    }
}
