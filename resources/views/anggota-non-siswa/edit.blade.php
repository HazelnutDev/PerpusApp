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
                                    <label class="form-label" for="NoAnggotaN">No Anggota</label>
                                    <input type="text" class="form-control @error('NoAnggotaN') is-invalid @enderror" id="NoAnggotaN" name="NoAnggotaN" value="{{ old('NoAnggotaN', $anggotaNonSiswa->NoAnggotaN) }}" required readonly />
                                    @error('NoAnggotaN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NIP">NIP</label>
                                    <input type="text" class="form-control @error('NIP') is-invalid @enderror" id="NIP" name="NIP" value="{{ old('NIP', $anggotaNonSiswa->NIP) }}"/>
                                    @error('NIP')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NamaAnggota">Nama Anggota</label>
                                    <input type="text" class="form-control @error('NamaAnggota') is-invalid @enderror" id="NamaAnggota" name="NamaAnggota" value="{{ old('NamaAnggota', $anggotaNonSiswa->NamaAnggota) }}" />
                                    @error('NamaAnggota')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                 <div class="mb-3">
                                    <label class="form-label" for="TanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('TanggalLahir') is-invalid @enderror" id="TanggalLahir" name="TanggalLahir" value="{{ old('TanggalLahir', $anggotaNonSiswa->TanggalLahir ? $anggotaNonSiswa->TanggalLahir->format('Y-m-d') : '') }}" />
                                    @error('TanggalLahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <!-- Tambahkan field lain sesuai kebutuhan -->
                            </div>
                            <div class="col-md-6">
                                 <div class="mb-3">
                                    <label class="form-label" for="JenisKelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('JenisKelamin') is-invalid @enderror" id="JenisKelamin" name="JenisKelamin" required>
                                        <option value="L" {{ old('JenisKelamin', $anggotaNonSiswa->JenisKelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('JenisKelamin', $anggotaNonSiswa->JenisKelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('JenisKelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control @error('Pekerjaan') is-invalid @enderror" id="Pekerjaan" name="Pekerjaan" value="{{ old('Pekerjaan', $anggotaNonSiswa->Pekerjaan) }}" required/>
                                    @error('Pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Alamat">Alamat</label>
                                    <input type="text" class="form-control @error('Alamat') is-invalid @enderror" id="Alamat" name="Alamat" value="{{ old('Alamat', $anggotaNonSiswa->Alamat) }}" required/>
                                    @error('Alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NoTelp">No Telp</label>
                                    <input type="text" class="form-control @error('NoTelp') is-invalid @enderror" id="NoTelp" name="NoTelp" value="{{ old('NoTelp', $anggotaNonSiswa->NoTelp) }}"/>
                                    @error('NoTelp')
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