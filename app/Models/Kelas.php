<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'Kelas';
    protected $primaryKey = 'KdKelas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdKelas',
        'NamaKelas',
        'KdJurusan',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'KdJurusan', 'KdJurusan');
    }

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'KdKelas', 'KdKelas');
    }

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'KdKelas', 'KdKelas');
    }
}
