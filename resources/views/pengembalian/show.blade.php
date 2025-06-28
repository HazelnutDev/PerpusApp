@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pengembalian</h5>
                    <div>
                        @if($nomorKembaliForPrint)
                        <a href="{{ route('pengembalian.print', $nomorKembaliForPrint) }}" 
                           class="btn btn-success" target="_blank">Cetak</a>
                        @endif
                        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    @if(isset($error) && $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endif
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="180">No Pengembalian</th>
                                    <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? optional($pengembalian)->NoKembaliM : optional($pengembalian)->NoKembaliN }}</td>
                                </tr>
                                <tr>
                                    <th>No Peminjaman</th>
                                    <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? optional(optional($pengembalian)->peminjaman)->NoPinjamM : optional(optional($pengembalian)->peminjaman)->NoPinjamN }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Anggota</th>
                                    <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <td>: {{ optional(optional($pengembalian)->peminjaman)->anggota->NamaAnggota ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>: {{ optional(optional($pengembalian)->peminjaman)->TglPinjam ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Batas Kembali</th>
                                    <td>: {{ optional(optional($pengembalian)->peminjaman)->TglJatuhTempo ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengembalian</th>
                                    <td>: {{ optional($pengembalian)->TglKembali ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Denda</th>
                                    <td>: Rp {{ $pengembalian ? number_format($pengembalian->Denda, 0, ',', '.') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h6 class="fw-bold mb-3">Detail Buku yang Dikembalikan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($pengembalian && $pengembalian->peminjaman && $pengembalian->peminjaman->detailPeminjaman)
                                    @foreach($pengembalian->peminjaman->detailPeminjaman as $detail)
                                    <tr>
                                        <td>{{ $detail->KodeBuku }}</td>
                                        <td>{{ $detail->buku->Judul }}</td>
                                        <td>{{ $detail->JumlahBuku }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="3" class="text-center">Tidak ada data buku</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
