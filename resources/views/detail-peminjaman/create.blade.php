{{-- @extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Detail Peminjaman</h5>
                    <a href="{{ route('peminjaman.show', [
    'peminjaman' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN
]) }}" class="btn btn-secondary">Kembali</a>
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
                                    <th width="200">No Peminjaman</th>
                                    <td>{{ $peminjaman->NoPinjamM }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <td>{{ $peminjaman->anggota->NamaAnggota }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ $peminjaman->TglPinjam }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td>{{ $peminjaman->TglKembali }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <form action="{{ route('detail-peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                        <div class="mb-3">
                            <label for="buku_id" class="form-label">Buku</label>
                            <select name="buku_id" id="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                                <option value="">Pilih Buku</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->id }}" data-stok="{{ $buku->Stok }}">
                                        {{ $buku->Judul }} (Stok: {{ $buku->Stok }})
                                    </option>
                                @endforeach
                            </select>
                            @error('buku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Buku</label>
                            <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                                   id="jumlah" name="jumlah" min="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('peminjaman.show', [
    'peminjaman' => $peminjaman instanceof \App\Models\PeminjamanSiswa ? $peminjaman->NoPinjamM : $peminjaman->NoPinjamN
]) }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bukuSelect = document.getElementById('buku_id');
    const jumlahInput = document.getElementById('jumlah');

    jumlahInput.addEventListener('change', function() {
        const selectedOption = bukuSelect.options[bukuSelect.selectedIndex];
        if (selectedOption) {
            const stok = parseInt(selectedOption.dataset.stok);
            const jumlah = parseInt(this.value);
            
            if (jumlah > stok) {
                alert('Jumlah melebihi stok yang tersedia!');
                this.value = '';
            }
        }
    });
});
</script>
@endpush
@endsection --}}
