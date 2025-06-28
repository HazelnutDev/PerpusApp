@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Peminjaman</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.peminjaman.index') }}" class="mb-4">
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
                            <a href="{{ route('laporan.peminjaman.cetak', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
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
                        @php $counter = 1; @endphp
                        @foreach($peminjaman as $pinjam)
                            @php
                                $isSiswa = $pinjam instanceof \App\Models\PeminjamanSiswa;
                                $anggota = $pinjam->anggota;
                                $petugas = $pinjam->petugas;
                            @endphp

                            @foreach($pinjam->detailPeminjaman as $detail)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $pinjam->TglPinjam ? (is_string($pinjam->TglPinjam) ? \Carbon\Carbon::parse($pinjam->TglPinjam)->format('d/m/Y') : $pinjam->TglPinjam->format('d/m/Y')) : '-' }}</td>
                                    <td>{{ $isSiswa ? $pinjam->NoPinjamM : $pinjam->NoPinjamN }}</td>
                                    <td>{{ $anggota->NamaAnggota ?? '-' }}</td>
                                    <td>{{ $isSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
                                    <td>{{ $detail->buku->Judul ?? '-' }}</td>
                                    <td>{{ $petugas->Nama ?? '-' }}</td>
                                    <td>{{ $pinjam->TglJatuhTempo ? (is_string($pinjam->TglJatuhTempo) ? \Carbon\Carbon::parse($pinjam->TglJatuhTempo)->format('d/m/Y') : $pinjam->TglJatuhTempo->format('d/m/Y')) : '-' }}</td>
                                    <td>
                                        @php
                                            $tglJatuhTempo = $pinjam->TglJatuhTempo ? (is_string($pinjam->TglJatuhTempo) ? \Carbon\Carbon::parse($pinjam->TglJatuhTempo) : $pinjam->TglJatuhTempo) : null;
                                        @endphp
                                        @if(isset($pinjam->pengembalian))
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @elseif($tglJatuhTempo && $tglJatuhTempo->lt(now()))
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
