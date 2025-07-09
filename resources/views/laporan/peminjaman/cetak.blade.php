<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - Perpustakaan SMPN 2 Tepal</title>
    <style>
        
        @page {
            size: A4;
            margin: 2cm 1.5cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 20px 20px 0 20px; /* Menambahkan padding atas dan samping */
        }
        
        .header {
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            margin-top: 15px; /* Jarak dari atas */
        }
        
        .header-content {
            display: table;
            margin: 0 auto;
            border-collapse: separate;
        }
        
        .logo {
            width: 70px;
            height: 70px;
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }

        .logo img {
            width: 60px;
            height: 60px;
          
        }
        
        .school-info {
            display: table-cell;
            vertical-align: middle;
            text-align: left;
            padding-left: 20px;
        }
        
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #696cff;
        }
        
        .school-address {
            font-size: 11px;
            color: #555;
            margin-bottom: 3px;
        }
        
        .report-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 15px;
            text-transform: uppercase;
            text-decoration: underline;
            text-align: center;
        }
        
        .date-section {
            text-align: left;
            margin-bottom: 20px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        .table-container {
            margin-bottom: 40px;
            padding: 0 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        th, td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        
        .col-no { width: 3%; }
        .col-kode { width: 8%; }
        .col-udc { width: 7%; }
        .col-judul { width: 25%; }
        .col-penerbit { width: 12%; }
        .col-pengarang { width: 15%; }
        .col-tahun { width: 6%; }
        .col-deskripsi { width: 15%; }
        .col-isbn { width: 7%; }
        .col-stok { width: 5%; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .signature-section {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            width: 200px;
        }
        
        .signature-title {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .signature-space {
            height: 70px;
            margin-bottom: 5px;
        }
        
        .signature-name {
            font-size: 12px;
            font-weight: bold;
            text-decoration: underline;
            padding-bottom: 2px;
        }
        
        /* Styling untuk data contoh */
        .sample-data {
            font-size: 9px;
        }
        
        .wrap-text {
            word-wrap: break-word;
            word-break: break-word;
        }
        
        /* Media query untuk print/PDF */
        @media print {
            body {
                padding: 15px 15px 0 15px;
            }
            
            .header {
                margin-top: 10px;
            }
            
            .header-content {
                page-break-inside: avoid;
            }
            
            .logo {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <img src="{{ public_path('assets/icons/reading.svg') }}" alt="icon buku">
            </div>
            <div class="school-info">
                <div class="school-name">PERPUSTAKAAN SMP TEPAL</div>
                <div class="school-address">Jl. Soekarno Hatta, Kec. Batu Lanteh, Sumbawa, NTB. 84361</div>
                <div class="school-address">Telp. (0374) 123456 | Email: perpus@smptepal.sch.id</div>
            </div>
        </div>
    </div>
    
    <div class="report-title">Laporan Peminjaman</div>
    @if ($startDate != $endDate)
    <div class="date-section">
        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}
    </div>
    @else
    <div class="date-section">
        Tanggal: {{ \Carbon\Carbon::now()->format('d M Y') }}
    </div>
    @endif

    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Peminjaman</th>
                    <th>Tanggal Pinjam</th>
                    <th>Nama Peminjam</th>
                    <th>Jenis Anggota</th>
                    <th>Daftar Buku</th>
                    <th>Petugas</th>
                    <th>Batas Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data contoh - ganti dengan data dinamis dari Laravel -->
               @foreach ($peminjaman as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            @if($item instanceof \App\Models\PeminjamanSiswa)
                                            {{ $item->NoPinjamM }}
                                        @else
                                            {{ $item->NoPinjamN }}
                                        @endif
                        </td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->TglPinjam)->format('d/m/Y') }}</td>
                        <td>{{ $item->anggota->Nama ?? $item->anggota->NamaAnggota ?? '-' }}</td>
                        <td class="text-center">
                            {{ $item instanceof \App\Models\PeminjamanSiswa ? 'Siswa' : 'Non-Siswa' }}
                        </td>
                        <td class="wrap-text">
                            @foreach ($item->detailPeminjaman as $detail)
                                - {{ $detail->buku->Judul }}<br>
                            @endforeach
                        </td>
                        <td>{{ $item->petugas->Nama }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($item->TglKembali)->format('d/m/Y') }}
                        </td>
                        <td class="text-center">
                            {{ $item->Status == 'dikembalikan' ? 'Sudah Kembali' : 'Belum Kembali' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-title">Mengetahui,</div>
            <div class="signature-title">Kepala Perpustakaan</div>
            <div class="signature-space"></div>
            <div class="signature-name">(Detiani, S.Pd)</div>
        </div>
    </div>
</body>
</html>