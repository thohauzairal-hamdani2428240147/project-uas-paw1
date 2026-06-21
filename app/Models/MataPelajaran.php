<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    protected $table = 'MataPelajaran';
    protected $primaryKey = 'KdMapel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdMapel',
        'NamaMapel',
        'NamaBuku',
        'KKM',
    ];

    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'KdMapel', 'KdMapel');
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'KdMapel', 'KdMapel');
    }
}
