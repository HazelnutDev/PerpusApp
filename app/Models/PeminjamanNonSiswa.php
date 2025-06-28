<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanNonSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'peminjamen_header_non_siswa';
    protected $primaryKey = 'NoPinjamN';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'NoPinjamN',
        'TglPinjam',
        'TglJatuhTempo',
        'NoAnggotaN',
        'KodePetugas'
    ];

    protected $dates = [
        'TglPinjam',
        'TglJatuhTempo'
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaNonSiswa::class, 'NoAnggotaN', 'NoAnggotaN');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjamanNonSiswa::class, 'NoPinjamN', 'NoPinjamN');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(PengembalianNonSiswa::class, 'NoPinjamN', 'NoPinjamN');
    }
}
