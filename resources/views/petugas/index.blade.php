@extends('layouts.master')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Petugas</h5>
                    <a href="{{ route('petugas.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Petugas
                    </a>
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
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Petugas</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($petugas as $item)
                                <tr>
                                    <td>{{ $item->KodePetugas }}</td>
                                    <td>{{ $item->Nama }}</td>
                                    <td>{{ $item->Username }}</td>
                                    <td>{{ $item->Role }}</td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1" role="group">
                                            <a href="{{ route('petugas.show', ['petuga' => $item->KodePetugas]) }}" class="btn btn-info btn-sm" title="Detail"><i class="bx bx-show"></i></a>
                                            <a href="{{ route('petugas.edit', ['petuga' => $item->KodePetugas]) }}" class="btn btn-warning btn-sm" title="Edit"><i class="bx bx-edit"></i></a>
                                            <form action="{{ route('petugas.destroy', ['petuga' => $item->KodePetugas]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')"><i class="bx bx-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data petugas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $petugas->links() }}
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
