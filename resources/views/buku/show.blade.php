@extends('layouts.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="menu-icon tf-icons bx bx-book me-2"></i>
                        <h5 class="mb-0">Detail Buku</h5>
                    </div>
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="card mb-4">
                            <h5 class="card-header">Informasi Buku</h5>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Kode Buku</label>
                                    <p class="form-control-static fw-semibold">{{ $buku->KodeBuku }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">No UDC</label> 
                                    <p class="form-control-static fw-semibold">{{ $buku->NoUDC }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Judul</label>
                                    <p class="form-control-static fw-semibold">{{ $buku->Judul }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Penerbit</label>
                                    <p class="form-control-static fw-semibold">{{ $buku->Penerbit }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label text-muted">Pengarang</label>
                                    <p class="form-control-static fw-semibold">{{ $buku->Pengarang }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <h5 class="card-header">Informasi Lainnya</h5>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Tahun Terbit</label>
                                        <p class="form-control-static fw-semibold">{{ $buku->TahunTerbit ? $buku->TahunTerbit : '' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Deskripsi</label>
                                        <p class="form-control-static fw-semibold">{{ $buku->Deskripsi}}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">ISBN</label>
                                        <p class="form-control-static fw-semibold">{{ $buku->ISBN }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Stok</label>
                                        <p class="form-control-static fw-semibold">{{ $buku->Stok }}</p>
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
