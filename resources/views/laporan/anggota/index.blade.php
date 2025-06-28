@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Laporan Data Anggota</h4>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.anggota.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jenis_anggota">Jenis Anggota</label>
                            <select class="form-control" id="jenis_anggota" name="jenis_anggota">
                                <option value="semua" {{ request('jenis_anggota') == 'semua' ? 'selected' : '' }}>Semua</option>
                                <option value="siswa" {{ request('jenis_anggota') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="non-siswa" {{ request('jenis_anggota') == 'non-siswa' ? 'selected' : '' }}>Non-Siswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('laporan.anggota.cetak', request()->query()) }}"
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
                            <th>No. Anggota</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->NoAnggotaM ?? $item->NoAnggotaN }}</td>
                                <td>{{ $item->NamaAnggota ?? $item->Nama }}</td>
                                <td>{{ $item->JenisKelamin ?? '-' }}</td>
                                <td>{{ $item->Alamat ?? '-' }}</td>
                                <td>{{ $item->NoTelp ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ ($item->StatusAktif ?? $item->Status) == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $item->StatusAktif ?? ($item->Status ?? 'Tidak Aktif') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data anggota</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
