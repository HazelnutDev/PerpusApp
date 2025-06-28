<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengembalianNonSiswa extends Model
{
    protected $table = 'kembali_non_siswa';
    protected $primaryKey = 'NoKembaliN';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'NoKembaliN',
        'NoPinjamN',
        'TglKembali',
        'KodePetugas',
        'Denda'
    ];

    protected $dates = [
        'TglKembali'
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanNonSiswa::class, 'NoPinjamN', 'NoPinjamN');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }
}
