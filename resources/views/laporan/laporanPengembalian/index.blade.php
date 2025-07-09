@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Pengembalian</h4>

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
            @if ($message)
                <div class="alert alert-info alert-dismissible" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form method="GET" action="{{ route('laporan.laporanPengembalian.index') }}" class="mb-4">
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
                            @if ($pengembalian->isNotEmpty() && $startDate && $endDate)
                                <a href="{{ route('laporan.laporanPengembalian.cetak', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                    class="btn btn-success" target="_blank">Cetak PDF</a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($pengembalian->isEmpty())
                <p class="text-muted">Silakan pilih periode tanggal untuk menampilkan data pengembalian.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Peminjam</th>
                                <th>Jenis</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                                <th>Tanggal Kembali</th>
                                <th>Petugas</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengembalian as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item['Nama'] ?? '-' }}</td>
                                    <td>{{ $item['Jenis'] ?? '-' }}</td>
                                    <td>{{ $item['Judul'] ?? '-' }}</td>
                                    <td>{{ $item['TglPinjam'] ? \Carbon\Carbon::parse($item['TglPinjam'])->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $item['JatuhTempo'] ? \Carbon\Carbon::parse($item['JatuhTempo'])->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $item['TglKembali'] ? \Carbon\Carbon::parse($item['TglKembali'])->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $item['Petugas'] ?? '-' }}</td>
                                    <td>Rp {{ number_format($item['Denda'] ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
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