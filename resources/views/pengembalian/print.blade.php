<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pengembalian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18pt;
        }
        .info table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info table th {
            text-align: left;
            width: 200px;
            padding: 5px;
        }
        .info table td {
            padding: 5px;
        }
        .books table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .books table th,
        .books table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .books table th {
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUKTI PENGEMBALIAN BUKU</h1>
    </div>

    <div class="info">
        <table>
            <tr>
                <th>No. Pengembalian</th>
                <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? optional($pengembalian)->NoKembaliM : optional($pengembalian)->NoKembaliN }}</td>
            </tr>
            <tr>
                <th>No. Peminjaman</th>
                <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? optional(optional($pengembalian)->peminjaman)->NoPinjamM : optional(optional($pengembalian)->peminjaman)->NoPinjamN }}</td>
            </tr>
            <tr>
                <th>Nama Anggota</th>
                <td>: {{ $pengembalian->peminjaman->anggota->NamaAnggota }}</td>
            </tr>
            <tr>
                <th>Tipe Anggota</th>
                <td>: {{ $pengembalian instanceof \App\Models\PengembalianSiswa ? 'Siswa' : 'Non-Siswa' }}</td>
            </tr>
            <tr>
                <th>Tanggal Pinjam</th>
                <td>: {{ $pengembalian->peminjaman->TglPinjam }}</td>
            </tr>
            <tr>
                <th>Tanggal Jatuh Tempo</th>
                <td>: {{ $pengembalian->peminjaman->TglJatuhTempo }}</td>
            </tr>
            <tr>
                <th>Tanggal Kembali</th>
                <td>: {{ $pengembalian->TglKembali }}</td>
            </tr>
            <tr>
                <th>Denda</th>
                <td>: Rp {{ number_format($pengembalian->Denda, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="books">
        <h3>Detail Buku:</h3>
        <table>
            <thead>
                <tr>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengembalian->peminjaman->detailPeminjaman as $detail)
                <tr>
                    <td>{{ $detail->KodeBuku }}</td>
                    <td>{{ $detail->buku->Judul }}</td>
                    <td>{{ $detail->JumlahBuku }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>
            {{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}<br>
            Petugas,<br><br><br><br>
            {{ Auth::user()->NamaPetugas }}
        </p>
    </div>
</body>
</html>
