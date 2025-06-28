@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Peminjaman</h5>
                    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
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
                                    <th>No Peminjaman</th>
                                    <th>Tipe Anggota</th>
                                    <th>Nama Anggota</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Jatuh Tempo</th>
                                    <th>Kode Petugas</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $pinjam)
                                <tr>
                                    <td>{{ $pinjam instanceof \App\Models\PeminjamanSiswa ? $pinjam->NoPinjamM : $pinjam->NoPinjamN }}</td>
                                    <td>{{ $pinjam instanceof \App\Models\PeminjamanSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
                                    <td>{{ $pinjam->anggota->NamaAnggota }}</td>
                                    <td>{{ $pinjam->TglPinjam }}</td>
                                    <td>{{ $pinjam->TglJatuhTempo }}</td>
                                    {{-- <td>{{ optional($pinjam->pengembalian)->TglKembali ?? '-' }}</td> --}}
                                    <td>{{ $pinjam->KodePetugas }}</td>
                                    <td>
                                        @if(optional($pinjam->pengembalian) && optional($pinjam->pengembalian)->TglKembali)
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @elseif($pinjam->TglJatuhTempo < now() && !optional($pinjam->pengembalian)->TglKembali)
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning">Pinjam</span>
                                        @endif
                                    </td>                                   
                                    <td class="text-center">
                                        <div class="btn-group gap-2" role="group">
                                            <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                        ? route('peminjaman.show', $pinjam->NoPinjamM) 
                                                        : route('peminjaman.show', $pinjam->NoPinjamN) }}"
                                               class="btn btn-info btn-sm">Detail</a>
                                            @if($pinjam->status === 'dipinjam')
                                                <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                            ? route('pengembalian.create', ['peminjaman_id' => $pinjam->NoPinjamM]) 
                                                            : route('pengembalian.create', ['peminjaman_id' => $pinjam->NoPinjamN]) }}"
                                                   class="btn btn-success btn-sm">Kembalikan</a>
                                            @endif
                                            {{-- <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                        ? route('peminjaman.edit', $pinjam->NoPinjamM) 
                                                        : route('peminjaman.edit', $pinjam->NoPinjamN) }}"
                                               class="btn btn-warning btn-sm">Edit</a> --}}
                                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                                  action="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                            ? route('peminjaman.destroy', $pinjam->NoPinjamM) 
                                                            : route('peminjaman.destroy', $pinjam->NoPinjamN) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {{ $peminjaman->links() }}
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
