<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengembalianSiswa extends Model
{
    protected $table = 'kembali_siswa';
    protected $primaryKey = 'NoKembaliM';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'NoKembaliM',
        'NoPinjamM',
        'TglKembali',
        'KodePetugas',
        'Denda'
    ];

    protected $dates = [
        'TglKembali'
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanSiswa::class, 'NoPinjamM', 'NoPinjamM');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }
}
