@extends('layouts.master')

@section('content')
<div class="row mb-3 justify-content-evenly">
    <div class="col-xxl-6 order-0">
      <div class="card">
        <div class="d-flex align-items-start row">
          <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang <br> {{ Auth::user()->Nama }} 🎉</h5>
                <p class="mb-4">
                  selamat bekerja <span class="fw-bold"></span> nikmati harimu dengan lebih baik
                </p>
  
                <a href="{{route('peminjaman.index')}}" class="btn btn-sm btn-outline-primary">lihat data peminjaman</a>
              </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-6">
              <img src="https://demos.themeselection.com/sneat-bootstrap-html-laravel-admin-template-free/demo/assets/img/illustrations/man-with-laptop.png" height="175" class="scaleX-n1-rtl" alt="View Badge User">
            </div>
          </div>
        </div>
      </div>
    </div>
     <!-- Cards -->
      <div class="col-lg-6 col-md-4 order-1">
      <div class="row">
          <div class="col-sm-6">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center"> Total Peminjaman </span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $peminjaman_siswa->count() + $peminjaman_non_siswa->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                  </div>
              </div>
          </div>
          <div class="col-sm-6">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center">Total Pengembalian</span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $pengembalian_siswa->count() + $pengembalian_non_siswa->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
     
      <!-- Cards -->
      <div class="row mb-4">
          <div class="col-sm-3">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center">Data Petugas</span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $petugas->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                  </div>
              </div>
          </div>
          <div class="col-sm-3">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center">Data Buku</span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $buku->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                  </div>
              </div>
          </div>
          <div class="col-sm-3">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center">Data Siswa</span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $anggota->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                  </div>
              </div>
          </div>
          <div class="col-sm-3">
              <div class="card">
                  <div class="card-body">
                      <span class="fw-semibold d-block mb-1 text-center">Data Non-Siswa</span>
                      <h3 class="card-title mb-2"><div class="fs-5 text-primary text-center">{{ $anggota_non_siswa->count() }}</div></h3>
                      <small class="text-success fw-semibold d-flex justify-content-center"><i class="bx bx-up-arrow-alt"></i> Total</small>
                  </div>
              </div>
          </div>
      </div>
      
   <!-- Cards -->
   <div class="row">
    @foreach($buku as $item)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="d-flex justify-content-center align-items-center" style="height: 180px; background: #f8f9fa;">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}"
                             alt="{{ $item->Judul }}"
                             style="max-height: 160px; max-width: 100%; object-fit: contain; background: #fff;">
                    @else
                        <img src="{{ asset('image/default-book.png') }}"
                             alt="Default Book"
                             style="max-height: 160px; max-width: 100%; object-fit: contain; background: #fff;">
                    @endif
                </div>
                <div class="card-body p-3">
                    <h6 class="card-title mb-2" style="font-size: 1rem; font-weight: 600;">{{ $item->Judul }}</h6>
                    <div style="font-size: 0.95rem;">
                        <div><b>Kode Buku:</b> {{ $item->KodeBuku }}</div>
                        <div><b>Pengarang:</b> {{ $item->Pengarang }}</div>
                        <div><b>Stok:</b> {{ $item->Stok }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
