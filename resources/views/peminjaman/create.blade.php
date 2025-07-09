@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tambah Peminjaman Baru</h5>
                    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tipe_anggota" class="form-label">Tipe Anggota</label>
                            <select name="tipe_anggota" id="tipe_anggota" class="form-select @error('tipe_anggota') is-invalid @enderror" required>
                                <option value="">Pilih Tipe Anggota</option>
                                <option value="siswa" {{ old('tipe_anggota') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                <option value="non-siswa" {{ old('tipe_anggota') == 'non-siswa' ? 'selected' : '' }}>Non-Siswa</option>
                            </select>
                            @error('tipe_anggota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="anggota_id" class="form-label">Anggota</label>
                            <select name="anggota_id" id="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
                                <option value="">Pilih Anggota</option>
                            </select>
                            @error('anggota_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        <div class="mb-3">
                            <label for="TglPinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control @error('TglPinjam') is-invalid @enderror" 
                                   id="TglPinjam" name="TglPinjam" value="{{ old('TglPinjam', date('Y-m-d')) }}" readonly required>
                            @error('TglPinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="TglJatuhTempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" class="form-control @error('TglJatuhTempo') is-invalid @enderror" 
                                   id="TglJatuhTempo" name="TglJatuhTempo" value="{{ old('TglJatuhTempo') }}" required>
                            @error('TglJatuhTempo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div><div class="mb-3">
                            <label class="form-label">Buku Yang Ingin Di Pinjam</label>
                            <div id="detail-buku-container">
                                <div class="row detail-buku-row mb-2">
                                    <div class="col-md-5">
                                        <select name="buku_id[]" class="form-select buku-select" required>
                                            <option value="">Pilih Buku</option>
                                            @foreach($bukus as $buku)
                                                <option value="{{ $buku->KodeBuku }}" data-stok="{{ $buku->Stok }}">
                                                    {{ $buku->Judul }} (Stok: {{ $buku->Stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="jumlah[]" class="form-control jumlah-input" 
                                               placeholder="Jumlah" min="1" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-detail">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="add-detail">Tambah Buku</button>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
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
    // Handle tipe anggota change
    const tipeAnggotaSelect = document.getElementById('tipe_anggota');
    const anggotaSelect = document.getElementById('anggota_id');

    // Load initial anggota data
    function loadAnggotaOptions(tipeAnggota) {
        // Clear current options
        anggotaSelect.innerHTML = '<option value="">Pilih Anggota</option>';
        
        if (tipeAnggota === 'siswa') {
            // Show student members
            @foreach($anggotas as $anggota)
            anggotaSelect.innerHTML += `<option value="{{ $anggota->NoAnggotaM }}">{{ $anggota->NamaAnggota }}</option>`;
            @endforeach
        } else if (tipeAnggota === 'non-siswa') {
            // Show non-student members
            @foreach($anggotaNonSiswas as $anggota)
            anggotaSelect.innerHTML += `<option value="{{ $anggota->NoAnggotaN }}">{{ $anggota->NamaAnggota }}</option>`;
            @endforeach
        }
    }

    tipeAnggotaSelect.addEventListener('change', function() {
        loadAnggotaOptions(this.value);
    });

    // Handle detail buku
    const detailContainer = document.getElementById('detail-buku-container');
    const addDetailBtn = document.getElementById('add-detail');

    function createDetailRow() {
        const row = document.querySelector('.detail-buku-row').cloneNode(true);
        row.querySelector('.buku-select').value = '';
        row.querySelector('.jumlah-input').value = '';
        return row;
    }

    addDetailBtn.addEventListener('click', function() {
        detailContainer.appendChild(createDetailRow());
    });

    detailContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-detail')) {
            const rows = document.querySelectorAll('.detail-buku-row');
            if (rows.length > 1) {
                e.target.closest('.detail-buku-row').remove();
            }
        }
    });

    // Validate stok when jumlah is entered
    detailContainer.addEventListener('change', function(e) {
        if (e.target.classList.contains('jumlah-input')) {
            const row = e.target.closest('.detail-buku-row');
            const bukuSelect = row.querySelector('.buku-select');
            const selectedOption = bukuSelect.options[bukuSelect.selectedIndex];
            
            if (selectedOption) {
                const stok = parseInt(selectedOption.dataset.stok);
                const jumlah = parseInt(e.target.value);
                
                if (jumlah > stok) {
                    alert('Jumlah melebihi stok yang tersedia!');
                    e.target.value = '';
                }
            }
        }
    });
});
</script>
@endpush
@endsection
