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

    <!-- Tables -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Data Peminjaman Terbaru (Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No Pinjam</th>
                                <th>Nama</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($peminjaman_siswa as $pinjam)
                            <tr>
                                <td>{{ $pinjam->NoPinjamM }}</td>
                                <td>{{ $pinjam->NamaAnggota }}</td>
                                <td>{{ $pinjam->TglPinjam }}</td>
                                <td>{{ $pinjam->TglJatuhTempo }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <div class="card">
                <h5 class="card-header">Data Peminjaman Terbaru (Non-Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No Pinjam</th>
                                <th>Nama</th>
                                <th>Tanggal Pinjam</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($peminjaman_non_siswa as $pinjam)
                            <tr>
                                <td>{{ $pinjam->NoPinjamN }}</td>
                                <td>{{ $pinjam->NamaAnggota }}</td>
                                <td>{{ $pinjam->TglPinjam }}</td>
                                <td>{{ $pinjam->TglJatuhTempo }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Data Pengembalian Terbaru (Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No Kembali</th>
                                <th>Nama</th>
                                <th>Tanggal Kembali</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($pengembalian_siswa as $kembali)
                            <tr>
                                <td>{{ $kembali->NoKembaliM }}</td>
                                <td>{{ $kembali->NamaAnggota }}</td>
                                <td>{{ $kembali->TglKembali }}</td>
                                <td>Rp {{ number_format($kembali->Denda, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
         <div class="col-md-12 mt-4">
            <div class="card">
                <h5 class="card-header">Data Pengembalian Terbaru (Non-Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No Kembali</th>
                                <th>Nama</th>
                                <th>Tanggal Kembali</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($pengembalian_non_siswa as $kembali)
                            <tr>
                                <td>{{ $kembali->NoKembaliN }}</td>
                                <td>{{ $kembali->NamaAnggota }}</td>
                                <td>{{ $kembali->TglKembali }}</td>
                                <td>Rp {{ number_format($kembali->Denda, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Statistik Peminjaman (Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Total Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($statistik_peminjaman_siswa as $stat)
                            <tr>
                                <td>{{ $stat->NamaAnggota }}</td>
                                <td>{{ $stat->total_pinjam }} kali</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Statistik Peminjaman (Non-Siswa)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Total Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($statistik_peminjaman_non_siswa as $stat)
                            <tr>
                                <td>{{ $stat->NamaAnggota }}</td>
                                <td>{{ $stat->total_pinjam }} kali</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
