<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPelajaran extends Model
{
    protected $table = 'JadwalPelajaran';
    protected $primaryKey = 'KdJadwal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdJadwal',
        'Hari',
        'JamMulai',
        'JamSelesai',
        'KdStaff',
        'KdMapel',
        'KdKelas',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'KdStaff', 'NIY');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'KdMapel', 'KdMapel');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'KdKelas', 'KdKelas');
    }
}
