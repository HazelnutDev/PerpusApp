<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    /** @use HasFactory<\Database\Factories\BukuFactory> */
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'KodeBuku';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'KodeBuku',
        'NoUDC',
        'Judul',
        'Penerbit',
        'Pengarang',
        'TahunTerbit',
        'Deskripsi',
        'ISBN',
        'Stok',
    ];

    public function detailPeminjamanSiswa(): HasMany
    {
        return $this->hasMany(DetailPeminjamanSiswa::class, 'KodeBuku', 'KodeBuku');
    }

    public function detailPeminjamanNonSiswa(): HasMany
    {
        return $this->hasMany(DetailPeminjamanNonSiswa::class, 'KodeBuku', 'KodeBuku');
    }
}
