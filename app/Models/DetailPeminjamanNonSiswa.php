<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPeminjamanNonSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam_details_non_siswa';

    protected $fillable = [
        'NoPinjamN',
        'KodeBuku',
        'KodePetugas'
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanNonSiswa::class, 'NoPinjamN', 'NoPinjamN');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'KodeBuku', 'KodeBuku');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class, 'KodePetugas', 'KodePetugas');
    }
}
