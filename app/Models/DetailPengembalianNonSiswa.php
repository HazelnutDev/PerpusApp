<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengembalianNonSiswa extends Model
{
    use HasFactory;
    
    protected $table = 'detail_pengembalian_non_siswa';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'NoKembaliN',
        'KodeBuku',
        'KodePetugas',
        'Jumlah',
        'Denda'
    ];

    protected $casts = [
        'Jumlah' => 'integer',
        'Denda' => 'decimal:2'
    ];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(PengembalianNonSiswa::class, 'NoKembaliN', 'NoKembaliN');
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
