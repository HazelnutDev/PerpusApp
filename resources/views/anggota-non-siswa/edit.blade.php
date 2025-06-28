@extends('layouts.master')

@section('title', 'Edit Anggota Non Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Edit Anggota Non Siswa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota-non-siswa.update', ['anggota_non_siswa' => $anggotaNonSiswa->NoAnggotaN]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="NIP">NIP</label>
                                    <input type="text" class="form-control @error('NIP') is-invalid @enderror" id="NIP" name="NIP" value="{{ old('NIP', $anggotaNonSiswa->NIP) }}" placeholder="Masukkan NIP" />
                                    @error('NIP')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NamaAnggota">Nama Anggota</label>
                                    <input type="text" class="form-control @error('NamaAnggota') is-invalid @enderror" id="NamaAnggota" name="NamaAnggota" value="{{ old('NamaAnggota', $anggotaNonSiswa->NamaAnggota) }}" placeholder="Masukkan nama anggota" />
                                    @error('NamaAnggota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Jabatan">Jabatan</label>
                                    <input type="text" class="form-control @error('Jabatan') is-invalid @enderror" id="Jabatan" name="Jabatan" value="{{ old('Jabatan', $anggotaNonSiswa->Jabatan) }}" placeholder="Masukkan jabatan" />
                                    @error('Jabatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Tambahkan field lain sesuai kebutuhan -->
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="TTL">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('TTL') is-invalid @enderror" id="TTL" name="TTL" value="{{ old('TTL', $anggotaNonSiswa->TTL ? $anggotaNonSiswa->TTL->format('Y-m-d') : '') }}" />
                                    @error('TTL')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Alamat">Alamat</label>
                                    <input type="text" class="form-control @error('Alamat') is-invalid @enderror" id="Alamat" name="Alamat" value="{{ old('Alamat', $anggotaNonSiswa->Alamat) }}" placeholder="Masukkan alamat" />
                                    @error('Alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="KodePos">Kode Pos</label>
                                    <input type="text" class="form-control @error('KodePos') is-invalid @enderror" id="KodePos" name="KodePos" value="{{ old('KodePos', $anggotaNonSiswa->KodePos) }}" placeholder="Masukkan kode pos" />
                                    @error('KodePos')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NoTelpHp">No Telp/HP</label>
                                    <input type="text" class="form-control @error('NoTelpHp') is-invalid @enderror" id="NoTelpHp" name="NoTelpHp" value="{{ old('NoTelpHp', $anggotaNonSiswa->NoTelpHp) }}" placeholder="Masukkan no telp/hp" />
                                    @error('NoTelpHp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="TglDaftar">Tanggal Daftar</label>
                                    <input type="date" class="form-control @error('TglDaftar') is-invalid @enderror" id="TglDaftar" name="TglDaftar" value="{{ old('TglDaftar', $anggotaNonSiswa->TglDaftar ? $anggotaNonSiswa->TglDaftar->format('Y-m-d') : '') }}" />
                                    @error('TglDaftar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                            <a href="{{ route('anggota-non-siswa.index') }}" class="btn btn-secondary ms-2"><i class="bx bx-arrow-back"></i> Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection