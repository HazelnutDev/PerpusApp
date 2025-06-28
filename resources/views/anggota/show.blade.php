@extends('layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-user me-2"></i>
                        <h5 class="mb-0">Detail Anggota Siswa</h5>
                    </div>
                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Pribadi Siswa</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">No Anggota</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->NoAnggotaM }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">NIS</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->NIS }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nama</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->NamaAnggota }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tanggal Lahir</label>
                                        <p class="form-control-static fw-semibold">
                                            {{ optional($anggota->TanggalLahir)->format('d/m/Y') ?: 'Data Tanggal Lahir Tidak Ada' }}
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Kelas</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->Kelas }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Kontak</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Alamat</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->Alamat }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">No Telp/HP</label>
                                        <p class="form-control-static fw-semibold">{{ $anggota->NoTelp }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
