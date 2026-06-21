<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    protected $table = 'Nilai';
    
    // Disable primary key auto-incrementing
    public $incrementing = false;
    protected $primaryKey = null; 

    protected $fillable = [
        'NISN',
        'KdMapel',
        'Semester',
        'nilaiUTS',
        'nilaiUAS',
        'nilaiTugas',
        'nilaiAkhir',
        'Keterangan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'NISN', 'NISN');
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'KdMapel', 'KdMapel');
    }
}
