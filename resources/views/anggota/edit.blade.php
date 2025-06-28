@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Anggota Siswa</h5>
                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('anggota.update', $anggota->NoAnggotaM) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="NoAnggotaM">No Anggota</label>
                                    <input type="text" class="form-control @error('NoAnggotaM') is-invalid @enderror" id="NoAnggotaM" name="NoAnggotaM" value="{{ old('NoAnggotaM', $anggota->NoAnggotaM) }}" required readonly />
                                    @error('NoAnggotaM')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NIS">NIS</label>
                                    <input type="text" class="form-control @error('NIS') is-invalid @enderror" id="NIS" name="NIS" value="{{ old('NIS', $anggota->NIS) }}" required />
                                    @error('NIS')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Nama">Nama</label>
                                    <input type="text" class="form-control @error('Nama') is-invalid @enderror" id="Nama" name="Nama" value="{{ old('Nama', $anggota->NamaAnggota) }}" required />
                                    @error('Nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Kelas">Kelas</label>
                                    <input type="text" class="form-control @error('Kelas') is-invalid @enderror" id="Kelas" name="Kelas" value="{{ old('Kelas', $anggota->Kelas) }}" required />
                                    @error('Kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="TTL">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('TTL') is-invalid @enderror" id="TTL" name="TTL" value="{{ old('TTL', $anggota->TTL ? $anggota->TTL->format('Y-m-d') : '') }}" />
                                    @error('TTL')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="Alamat">Alamat</label>
                                    <input type="text" class="form-control @error('Alamat') is-invalid @enderror" id="Alamat" name="Alamat" value="{{ old('Alamat', $anggota->Alamat) }}" required />
                                    @error('Alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="NoTelpHp">No Telp/HP</label>
                                    <input type="text" class="form-control @error('NoTelpHp') is-invalid @enderror" id="NoTelpHp" name="NoTelpHp" value="{{ old('NoTelpHp', $anggota->NoTelp) }}" required />
                                    @error('NoTelpHp')
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
