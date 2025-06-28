@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Pengembalian</h5>
                    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">Proses Pengembalian</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="filterType" class="form-label">Filter Tipe Anggota:</label>
                        <select class="form-select" id="filterType" onchange="updateFilter(this.value)">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="siswa" {{ request('type') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="non-siswa" {{ request('type') == 'non-siswa' ? 'selected' : '' }}>Non-Siswa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari data...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mainTable">
                            <thead>
                                <tr>
                                    <th>No Pengembalian</th>
                                    <th>No Peminjaman</th>
                                    <th>Tipe Anggota</th>
                                    <th>Nama Anggota</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Denda</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengembalian as $kembali)
                                <tr>
                                    <td>{{ $kembali instanceof \App\Models\PengembalianSiswa ? $kembali->NoKembaliM : $kembali->NoKembaliN }}</td>
                                    <td>{{ $kembali instanceof \App\Models\PengembalianSiswa ? $kembali->peminjaman->NoPinjamM : $kembali->peminjaman->NoPinjamN }}</td>
                                    <td>{{ $kembali instanceof \App\Models\PengembalianSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
                                    <td>{{ $kembali->peminjaman->anggota->NamaAnggota }}</td>
                                    <td>{{ $kembali->peminjaman->TglPinjam }}</td>
                                    <td>{{ $kembali->TglKembali }}</td>
                                    <td>Rp {{ number_format($kembali->Denda, 0, ',', '.') }}
                                        @php
                                            $jatuhTempo = $kembali->peminjaman->TglJatuhTempo;
                                            $tglKembali = $kembali->TglKembali;
                                            $dendaPerHari = 1000;
                                            $hariTerlambat = 0;
                                            if($tglKembali > $jatuhTempo) {
                                                $hariTerlambat = \Carbon\Carbon::parse($tglKembali)->diffInDays(\Carbon\Carbon::parse($jatuhTempo));
                                            }
                                        @endphp
                                        @if($hariTerlambat > 0)
                                            <br><span class="badge bg-danger">Terlambat {{ $hariTerlambat }} hari</span>
                                        @else
                                            <br><span class="badge bg-success">Tepat Waktu</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group gap-2" role="group">
                                            <a href="{{ route('pengembalian.show', $kembali instanceof \App\Models\PengembalianSiswa ? $kembali->NoKembaliM : $kembali->NoKembaliN) }}"
                                               class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('pengembalian.print', $kembali instanceof \App\Models\PengembalianSiswa ? $kembali->NoKembaliM : $kembali->NoKembaliN) }}"
                                               class="btn btn-success btn-sm" target="_blank">Cetak</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pengembalian</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $pengembalian->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFilter(value) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('type', value);
    window.location.href = currentUrl.toString();
}

document.getElementById('searchTable').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#mainTable tbody tr');
    rows.forEach(function(row) {
        let text = row.textContent.toLowerCase();
        row.style.display = text.indexOf(value) > -1 ? '' : 'none';
    });
});
</script>
@endpush
@endsection
