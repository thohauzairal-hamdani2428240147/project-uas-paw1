<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'Jurusan';
    protected $primaryKey = 'KdJurusan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'KdJurusan',
        'NamaJurusan',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'KdJurusan', 'KdJurusan');
    }
}
