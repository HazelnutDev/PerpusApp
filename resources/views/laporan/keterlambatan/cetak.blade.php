<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keterlambatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            margin-bottom: 20px;
        }
        .periode {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KETERLAMBATAN PENGEMBALIAN BUKU</h1>
        <div class="periode">
            Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pinjam</th>
                <th>No Peminjaman</th>
                <th>Nama Anggota</th>
                <th>Jenis Anggota</th>
                <th>Judul Buku</th>
                <th>Petugas</th>
                <th>Batas Waktu</th>
                <th>Keterlambatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keterlambatan as $index => $pinjam)
                @foreach($pinjam->detailPeminjaman as $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pinjam->TglPinjam ? $pinjam->TglPinjam->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                                {{ $pinjam->NoPinjamM ?? '-' }}
                            @else
                                {{ $pinjam->NoPinjamN ?? '-' }}
                            @endif
                        </td>
                        <td>
                            @if($pinjam->anggota)
                                {{ $pinjam->anggota->NamaAnggota ?? $pinjam->anggota->Nama ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                                Siswa
                            @else
                                Non-Siswa
                            @endif
                        </td>
                        <td>{{ $detail->buku->Judul ?? '-' }}</td>
                        <td>{{ $pinjam->petugas->Nama ?? '-' }}</td>
                        <td>{{ $pinjam->TglJatuhTempo ? $pinjam->TglJatuhTempo->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($pinjam->TglJatuhTempo)
                                {{ now()->diffInDays($pinjam->TglJatuhTempo) }} hari
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
