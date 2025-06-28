@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Buku</h5>
                    <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('buku.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Judul --}}
                                <div class="mb-3">
                                    <label class="form-label" for="Judul">Judul</label>
                                    <input type="text" class="form-control @error('Judul') is-invalid @enderror" id="Judul" name="Judul" value="{{ old('Judul') }}" required />
                                    @error('Judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- No UDC --}}
                                <div class="mb-3">
                                    <label class="form-label" for="NoUDC">No UDC</label>
                                    <input type="text" class="form-control @error('NoUDC') is-invalid @enderror" id="NoUDC" name="NoUDC" value="{{ old('NoUDC') }}" required />
                                    @error('NoUDC')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Penerbit --}}
                                <div class="mb-3">
                                    <label class="form-label" for="Penerbit">Penerbit</label>
                                    <input type="text" class="form-control @error('Penerbit') is-invalid @enderror" id="Penerbit" name="Penerbit" value="{{ old('Penerbit') }}" required />
                                    @error('Penerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pengarang --}}
                                <div class="mb-3">
                                    <label class="form-label" for="Pengarang">Pengarang</label>
                                    <input type="text" class="form-control @error('Pengarang') is-invalid @enderror" id="Pengarang" name="Pengarang" value="{{ old('Pengarang') }}" required />
                                    @error('Pengarang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tahun Terbit --}}
                                <div class="mb-3">
                                    <label class="form-label" for="TahunTerbit">Tahun Terbit</label>
                                    <input type="number" class="form-control @error('TahunTerbit') is-invalid @enderror" id="TahunTerbit" name="TahunTerbit" value="{{ old('TahunTerbit') }}" required />
                                    @error('TahunTerbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Deskripsi --}}
                                <div class="mb-3">
                                    <label class="form-label" for="Deskripsi">Deskripsi</label>
                                    <textarea class="form-control @error('Deskripsi') is-invalid @enderror" name="Deskripsi" id="Deskripsi" rows="5">{{ old('Deskripsi') }}</textarea>
                                    @error('Deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ISBN --}}
                                <div class="mb-3">
                                    <label class="form-label" for="ISBN">ISBN</label>
                                    <input type="text" class="form-control @error('ISBN') is-invalid @enderror" id="ISBN" name="ISBN" value="{{ old('ISBN') }}" />
                                    @error('ISBN')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="mb-3">
                                    <label class="form-label" for="Stok">Stok</label>
                                    <input type="number" class="form-control @error('Stok') is-invalid @enderror" id="Stok" name="Stok" value="{{ old('Stok') }}" required />
                                    @error('Stok')
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
