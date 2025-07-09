@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Anggota</h5>
                    @if (Auth::user()->Role === 'admin')    
                    <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
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
                                    {{-- <th>NIS</th> --}}
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Kelas</th>
                                    <th>No Telp Ortu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota as $item)
                                <tr>
                                    <td>{{ $item->NoAnggotaM }}</td>
                                    {{-- <td>{{ $item->NIS }}</td> --}}
                                    <td>{{ $item->NamaAnggota }}</td>
                                    <td>{{ $item->JenisKelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $item->Kelas }}</td>
                                    <td>{{ $item->NoTelpOrtu }}</td>
                                    <td>
                                        <div class="btn-group gap-1" role="group">
                                            <a href="{{ route('anggota.show', $item) }}" class="btn btn-info btn-sm" title="Detail"> <i class="bx bx-show"></i></a>
                                               @if (Auth::user()->Role === 'admin')
                                               <a href="{{ route('anggota.edit', $item) }}" class="btn btn-warning btn-sm"title="Edit"><i class="bx bx-edit"></i></a>
                                               <form action="{{ route('anggota.destroy', $item) }}" method="POST" class="d-inline">
                                                   @csrf
                                                   @method('DELETE')
                                                   <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')"><i class="bx bx-trash"></i></button>
                                               </form>
                                                @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $anggota->links() }}
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
