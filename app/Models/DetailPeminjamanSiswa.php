<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPeminjamanSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam_details_siswa';

    protected $fillable = [
        'NoPinjamM',
        'KodeBuku',
        'KodePetugas'
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(PeminjamanSiswa::class, 'NoPinjamM', 'NoPinjamM');
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
