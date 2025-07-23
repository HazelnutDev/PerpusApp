@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Peminjaman</h4>

    <div class="card mb-4">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="GET" action="{{ route('laporan.peminjaman.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                id="start_date" name="start_date"
                                value="{{ old('start_date', $startDate ?? now()->subDays(7)->format('Y-m-d')) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">Tanggal Akhir</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                id="end_date" name="end_date"
                                value="{{ old('end_date', $endDate ?? now()->format('Y-m-d')) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            @if ($peminjaman->isNotEmpty())
                                <a href="{{ route('laporan.peminjaman.cetak', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                    class="btn btn-success" target="_blank">Cetak PDF</a>
                                <a href="{{ route('laporan.peminjaman.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                    class="btn btn-info ms-2" target="_blank">Cetak Excel</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($peminjaman->isEmpty())
                <p class="text-muted">Silakan pilih periode tanggal untuk menampilkan data peminjaman.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pinjam</th>
                                <th>No Peminjaman</th>
                                <th>Nama Anggota</th>
                                <th>Jenis Anggota</th>
                                <th>Judul Buku</th>
                                <th>Petugas</th>
                                <th>Batas Waktu</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman as $index => $pinjam)
                                @foreach($pinjam->detailPeminjaman as $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pinjam->TglPinjam ? \Carbon\Carbon::parse($pinjam->TglPinjam)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                                                {{ $pinjam->NoPinjamM }}
                                            @else
                                                {{ $pinjam->NoPinjamN }}
                                            @endif
                                        </td>
                                        <td>{{ $pinjam->anggota->NamaAnggota ?? '-' }}</td>
                                        <td>
                                            @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                                                Siswa
                                            @else
                                                Non-Siswa
                                            @endif
                                        </td>
                                        <td>{{ $detail->buku->Judul ?? '-' }}</td>
                                        <td>{{ $detail->petugas->Nama ?? '-' }}</td>
                                        <td>{{ $pinjam->TglJatuhTempo ? \Carbon\Carbon::parse($pinjam->TglJatuhTempo)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            @if($pinjam->pengembalian)
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @else
                                                @if($pinjam->TglJatuhTempo < now())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning">Dipinjam</span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Validasi tanggal di sisi klien
    document.getElementById('end_date').addEventListener('change', function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = this.value;
        if (startDate && endDate && endDate < startDate) {
            alert('Tanggal akhir tidak boleh sebelum tanggal mulai.');
            this.value = '';
        }
    });
</script>
@endsection