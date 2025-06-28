@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Peminjaman</h5>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(isset($peminjaman))
                        <form action="{{ route('peminjaman.update', $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN) }}" method="POST">
                    @else
                        <form action="#" method="POST">
                    @endif
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="TglPinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="TglPinjam" name="TglPinjam" value="{{ old('TglPinjam', $peminjaman->TglPinjam) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="TglJatuhTempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control" id="TglJatuhTempo" name="TglJatuhTempo" value="{{ old('TglJatuhTempo', $peminjaman->TglJatuhTempo) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ old('status', $peminjaman->status) == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="terlambat" {{ old('status', $peminjaman->status) == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
