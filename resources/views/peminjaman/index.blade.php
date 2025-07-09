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
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    </div>
                    @endif

                    {{-- @if(session('success')) 
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
        timer: 4000,
        showConfirmButton: false
    });
</script>
@endif --}}

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
                                        @elseif(\Carbon\Carbon::parse($pinjam->TglJatuhTempo)->toDateString() < now()->toDateString() && !optional($pinjam->pengembalian)->TglKembali)
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning">Pinjam</span>
                                        @endif
                                        
                                    </td>                                   
                                    <td class="text-center">
                                        <div class="btn-group gap-2" role="group">
                                            <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                        ? route('peminjaman.show', $pinjam->NoPinjamM) 
                                                        : route('peminjaman.show', $pinjam->NoPinjamN)}}"
                                               class="btn btn-info btn-sm">Detail</a>
                                            @if(in_array($pinjam->status, ['dipinjam', 'terlambat']))
                                            {{-- {{ dd($pinjam->status) }} --}}
                                                <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                            ? route('pengembalian.create', ['peminjaman_id' => $pinjam->NoPinjamM]) 
                                                            : route('pengembalian.create', ['peminjaman_id' => $pinjam->NoPinjamN]) }}"
                                                   class="btn btn-success btn-sm">Kembalikan</a>
                                            @endif
                                            {{-- <a href="{{ $pinjam instanceof \App\Models\PeminjamanSiswa 
                                                        ? route('peminjaman.edit', $pinjam->NoPinjamM) 
                                                        : route('peminjaman.edit', $pinjam->NoPinjamN) }}"
                                               class="btn btn-warning btn-sm">Edit</a> --}}
                                                  @if (Auth::user()->Role === 'admin' && in_array($pinjam->status, ['dipinjam', 'terlambat']))
                        
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
                                                @endif
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
// Hilangkan alert setelah 5 detik (5000 ms)
    setTimeout(function () {
        let alert = document.querySelector('.alert');
        if (alert) {
            // Tambahkan efek fade out manual
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500); // Hapus dari DOM setelah fade out
        }
    }, 5000);
</script>
@endpush
@endsection
