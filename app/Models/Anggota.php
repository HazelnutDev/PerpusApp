<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $table = 'anggota';
    protected $primaryKey = 'NoAnggotaM';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'NoAnggotaM',
        'NIS',
        'NamaAnggota',
        'TanggalLahir',
        'JenisKelamin',
        'Alamat',
        'Kelas',
        'NoTelp',
        'NamaOrtu',
        'NoTelpOrtu',
    ];

    public function peminjaman_siswa()
    {
        return $this->hasMany(PeminjamanSiswa::class, 'NoAnggotaM', 'NoAnggotaM');
    }

    protected $casts = [
        'TanggalLahir' => 'date'
    ];

    public function pengembalian_siswa()
    {
        return $this->hasManyThrough(
            PengembalianSiswa::class,
            'NoAnggotaM',
            'NoPinjamM',
            'NoAnggotaM',
            'NoPinjamM'
        );
    }
}
