<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'Pembayaran';
    protected $primaryKey = 'KdPembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdPembayaran',
        'BulanBayar',
        'TglBayar',
        'JumlahBayar',
        'MetodePembayaran',
        'NISN',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'NISN', 'NISN');
    }
}
