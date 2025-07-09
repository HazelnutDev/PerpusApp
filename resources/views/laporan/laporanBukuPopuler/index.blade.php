@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Buku Terpopuler</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.buku-populer.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('laporan.buku-populer.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                               class="btn btn-secondary" target="_blank">Cetak PDF</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Rak</th>
                            <th>Total Peminjaman Siswa</th>
                            <th>Total Peminjaman Non-Siswa</th>
                            <th>Total Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukuPopuler as $index => $buku)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $buku->KodeBuku }}</td>
                                <td>{{ $buku->Judul }}</td>
                                <td>{{ optional($buku->kategori)->nama ?? 'Tidak Ada' }}</td>
                                <td>{{ optional($buku->rak)->nama ?? 'Tidak Ada' }}</td>
                                <td>{{ $buku->PeminjamanSiswa ?? 0 }}</td>
                                <td>{{ $buku->PeminjamanNonSiswa ?? 0 }}</td>
                                <td>{{ $buku->total_peminjaman ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
