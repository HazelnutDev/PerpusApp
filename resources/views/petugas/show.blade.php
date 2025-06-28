@extends('layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-user me-2"></i>
                        <h5 class="mb-0">Detail Petugas</h5>
                    </div>
                    <a href="{{ route('petugas.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Petugas</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Kode Petugas</label>
                                        <p class="form-control-static fw-semibold">{{ $petugas->KodePetugas }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Nama</label>
                                        <p class="form-control-static fw-semibold">{{ $petugas->Nama }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Username</label>
                                        <p class="form-control-static fw-semibold">{{ $petugas->Username }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Role</label>
                                        <p class="form-control-static fw-semibold">{{ $petugas->Role }}</p>
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
