@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Anggota Non Siswa</h5>
                    @if (Auth::user()->Role === 'admin')     
                    <a href="{{ route('anggota-non-siswa.create') }}" class="btn btn-primary">Tambah Anggota</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <input type="text" id="searchTable" class="form-control" placeholder="Cari data...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="mainTable">
                            <thead>
                                <tr>
                                    <th>No Anggota</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Pekerjaan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No Telp</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($anggota_non_siswa as $item)
                                <tr>
                                    <td>{{ $item->NoAnggotaN }}</td>
                                    <td>{{ $item->NIP }}</td>
                                    <td>{{ $item->NamaAnggota }}</td>
                                    <td>{{ $item->Pekerjaan }}</td>
                                    <td>{{ optional($item->TanggalLahir)->format('d/m/y') }}</td>
                                    <td>{{ $item->JenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $item->Alamat }}</td>
                                    <td>{{ $item->NoTelp }}</td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1" role="group">
                                            <a href="{{ route('anggota-non-siswa.show', ['anggota_non_siswa' => $item->NoAnggotaN]) }}" class="btn btn-info btn-sm" title="Detail"><i class="bx bx-show"></i></a>
                                               @if (Auth::user()->Role === 'admin')
                                               <a href="{{ route('anggota-non-siswa.edit', ['anggota_non_siswa' => $item->NoAnggotaN]) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                               <form action="{{ route('anggota-non-siswa.destroy', ['anggota_non_siswa' => $item->NoAnggotaN]) }}" method="POST" class="d-inline">
                                                   @csrf
                                                   @method('DELETE')
                                                   <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')"><i class="bx bx-trash"></i></button>
                                               </form>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data anggota non siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                            {{ $anggota_non_siswa->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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