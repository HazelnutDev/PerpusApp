<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'petugas';
    protected $primaryKey = "KodePetugas";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'KodePetugas',
        'Username',
        'Nama',
        'Password',
        'Role'
    ];
    protected $casts = [
        'Role'=> 'string',
    ];
    protected $hidden = [
        'Password', 
        'remember_token',
    ];
    /**
     * The column name used for authentication username
     */
    public $username = 'Username';

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }
    
    public function peminjamanSiswa(): HasMany
    {
        return $this->hasMany(PeminjamanSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function peminjamanNonSiswa(): HasMany
    {
        return $this->hasMany(PeminjamanNonSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function pengembalianSiswa(): HasMany
    {
        return $this->hasMany(PengembalianSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function pengembalianNonSiswa(): HasMany
    {
        return $this->hasMany(PengembalianNonSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function detailPeminjamanSiswa(): HasMany
    {
        return $this->hasMany(DetailPeminjamanSiswa::class, 'KodePetugas', 'KodePetugas');
    }

    public function detailPeminjamanNonSiswa(): HasMany
    {
        return $this->hasMany(DetailPeminjamanNonSiswa::class, 'KodePetugas', 'KodePetugas');
    }
}
