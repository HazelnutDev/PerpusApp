@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Anggota Siswa</h5>
                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="NoAnggotaM">No Anggota</label>
                                    <input type="text" class="form-control @error('NoAnggotaM') is-invalid @enderror" id="NoAnggotaM" name="NoAnggotaM" value="{{ $noAnggota }}" required readonly/>
                                    @error('NoAnggotaM')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NIS">NIS</label>
                                    <input type="text" class="form-control @error('NIS') is-invalid @enderror" id="NIS" name="NIS" value="{{ old('NIS') }}" required />
                                    @error('NIS')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NamaAnggota">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('NamaAnggota') is-invalid @enderror" id="NamaAnggota" name="NamaAnggota" value="{{ old('NamaAnggota') }}" required />
                                    @error('NamaAnggota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="mb-3">
                                    <label class="form-label" for="TanggalLahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('TanggalLahir') is-invalid @enderror" id="TanggalLahir" name="TanggalLahir" value="{{ old('TanggalLahir') }}" />
                                    @error('TanggalLahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="JenisKelamin">Jenis Kelamin</label>
                                    <select class="form-control @error('JenisKelamin') is-invalid @enderror" id="JenisKelamin" name="JenisKelamin" required>
                                        <option value="L" {{ old('JenisKelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('JenisKelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('JenisKelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                 <div class="mb-3">
                                    <label class="form-label" for="Kelas">Kelas</label>
                                    <input type="text" class="form-control @error('Kelas') is-invalid @enderror" id="Kelas" name="Kelas" value="{{ old('Kelas') }}" required />
                                    @error('Kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="Alamat">Alamat</label>
                                    <textarea class="form-control @error('Alamat') is-invalid @enderror" name="Alamat" id="Alamat" rows="5">{{ old('Alamat') }}</textarea>
                                    @error('Alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NoTelp">No Telp</label>
                                    <input type="text" class="form-control @error('NoTelp') is-invalid @enderror" id="NoTelp" name="NoTelp" value="{{ old('NoTelp') }}" required />
                                    @error('NoTelp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NamaOrtu">Nama Orang Tua</label>
                                    <input type="text" class="form-control @error('NamaOrtu') is-invalid @enderror" id="NamaOrtu" name="NamaOrtu" value="{{ old('NamaOrtu') }}" required />
                                    @error('NamaOrtu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NoTelpOrtu">No Telp Orang Tua</label>
                                    <input type="text" class="form-control @error('NoTelpOrtu') is-invalid @enderror" id="NoTelpOrtu" name="NoTelpOrtu" value="{{ old('NoTelpOrtu') }}" required />
                                    @error('NoTelpOrtu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
