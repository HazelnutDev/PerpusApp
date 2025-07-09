<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaNonSiswa extends Model
{
    use HasFactory;

    protected $table = 'anggota_non_siswa';
    protected $primaryKey = 'NoAnggotaN';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'NoAnggotaN',
        'NIP',
        'NamaAnggota',
        'Pekerjaan',
        'JenisKelamin',
        'TanggalLahir',
        'Alamat',
        'NoTelp',
    ];

    public function peminjaman_Non_Siswa()
    {
        return $this->hasMany(PeminjamanNonSiswa::class, 'NoAnggotaN', 'NoAnggotaN');
    }

    public function pengembalian_Non_Siswa()
    {
        return $this->hasManyThrough(
            PengembalianNonSiswa::class,
            'NoAnggotaN',
            'NoPinjamN',
            'NoAnggotaN',
            'NoPinjamN'
        );
    }

    protected $casts = [
        'TanggalLahir' => 'date'
    ];

    public function getRouteKeyName()
    {
        return 'NoAnggotaN';
    }
}
