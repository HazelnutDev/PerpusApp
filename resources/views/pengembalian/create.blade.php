@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Proses Pengembalian</h5>
                    <a href="{{ isset($peminjaman) ? route('peminjaman.show', $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN) : '#' }}" 
                       class="btn btn-secondary">Kembali</a>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">No Kembali</th>
                                    <td>{{ isset($nomorKembali) ? $nomorKembali : '-' }}</td>
                                </tr>
                                <tr>
                                    <th width="200">No Pinjam</th>
                                    <td>{{ isset($peminjaman) ? ($peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN) : '-' }}</td>
                                </tr>
                                 <tr>
                                    <th width="200">Kode Petugas</th>
                                    <td>{{ isset($kodePetugas) ? $kodePetugas : '-' }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Tipe Anggota</th>
                                    <td>{{ $peminjaman instanceof \App\Models\PeminjamanSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <td>{{ $peminjaman->anggota->NamaAnggota }}</td>
                                </tr> --}}
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ $peminjaman->TglPinjam }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Batas Kembali</th>
                                    <td>{{ $peminjaman->TglJatuhTempo }}</td>
                                </tr> --}}
                            </table>
                        </div>
                    </div>

                    <h6 class="mb-3">Detail Buku yang Dikembalikan:</h6>
                    <form action="{{ route('pengembalian.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ isset($peminjaman) ? ($peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN) : '' }}">
                        <input type="hidden" name="Denda" id="Denda" value="0">

                        {{-- <div class="table-responsive mb-3">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Buku</th>
                                        <th>Judul Buku</th>
                                        <th>Jumlah Dipinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjaman->detailPeminjaman as $detail)
                                    <tr>
                                        <td>{{ $detail->KodeBuku }}</td>
                                        <td>{{ $detail->buku->Judul }}</td>
                                        <td>{{ $detail->Jumlah }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> --}}

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="TglKembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" name="TglKembali" id="TglKembali" class="form-control" value="{{ old('TglKembali', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        {{-- <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <span id="statusKembali" class="form-text"></span>
                            </div>
                        </div> --}}

                        <div class="row mb-3" id="rowDenda" style="display:none;">
                            <div class="col-md-6">
                                <label class="form-label">Denda</label>
                                <td>Rp <span id="dendaText">0</span></td>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Pastikan semua buku sudah dikembalikan. Lanjutkan?')">
                                Tambah Pengembalian
                            </button>
                            <a href="{{ isset($peminjaman) ? route('peminjaman.show', $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN) : '#' }}" 
                               class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const jatuhTempo = @json($peminjaman->TglJatuhTempo);
const dendaPerHari = 1000;
const inputTglKembali = document.getElementById('TglKembali');
const dendaText = document.getElementById('dendaText');
const dendaInput = document.getElementById('Denda');
const statusKembali = document.getElementById('statusKembali');
const rowDenda = document.getElementById('rowDenda');

function hitungDenda() {
    const tglKembali = inputTglKembali.value;
    if (!tglKembali) return;
    const tglJatuhTempo = new Date(jatuhTempo);
    const tglKembaliDate = new Date(tglKembali);
    let hariTerlambat = 0;
    if (tglKembaliDate > tglJatuhTempo) {
        hariTerlambat = Math.ceil((tglKembaliDate - tglJatuhTempo) / (1000*60*60*24));
    }
    const denda = hariTerlambat * dendaPerHari;
    dendaText.textContent = denda.toLocaleString('id-ID');
    dendaInput.value = denda;
    if(hariTerlambat > 0) {
        statusKembali.innerHTML = `<span class='badge bg-danger'>Terlambat (${hariTerlambat} hari)</span>`;
        rowDenda.style.display = '';
    } else {
        statusKembali.innerHTML = `<span class='badge bg-success'>Tepat Waktu</span>`;
        rowDenda.style.display = 'none';
    }
}
inputTglKembali.addEventListener('change', hitungDenda);
document.addEventListener('DOMContentLoaded', hitungDenda);
</script>
@endpush
