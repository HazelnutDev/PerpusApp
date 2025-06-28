<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'peminjamen_header_siswa';
    protected $primaryKey = 'NoPinjamM';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'NoPinjamM',
        'TglPinjam',
        'TglJatuhTempo',
        'NoAnggotaM',
        'KodePetugas'
    ];

    protected $dates = [
        'TglPinjam',
        'TglJatuhTempo'
    ];

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class, 'NoAnggotaM', 'NoAnggotaM');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjamanSiswa::class, 'NoPinjamM', 'NoPinjamM');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(PengembalianSiswa::class, 'NoPinjamM', 'NoPinjamM');
    }
}
