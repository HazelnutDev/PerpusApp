@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Data Buku</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.buku.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status Ketersediaan</label>
                            <select class="form-control" id="status" name="status">
                                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Cari Judul/Pengarang</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Cari judul atau pengarang...">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('laporan.buku.cetak', request()->query()) }}"
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
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->KodeBuku }}</td>
                                <td>{{ $item->Judul }}</td>
                                <td>{{ $item->Pengarang ?? '-' }}</td>
                                <td>{{ $item->Penerbit ?? '-' }}</td>
                                <td>{{ $item->TahunTerbit ?? '-' }}</td>
                                <td>{{ $item->Stok ?? 0 }}</td>
                                <td>
                                    @php
                                        $status = ($item->Stok ?? 0) > 0 ? 'Tersedia' : 'Tidak Tersedia';
                                        $badgeClass = $status == 'Tersedia' ? 'bg-success' : 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data buku</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(method_exists($buku, 'links'))
                    <div class="mt-3">
                        {{ $buku->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
