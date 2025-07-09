<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Terpopuler</title>
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
        <h1>LAPORAN BUKU TERPOPULER</h1>
        <div class="periode">
            Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
        </div>
    </div>

    <table>                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Rak</th>
                            <th>Total Peminjaman Siswa</th>
                            <th>Total Peminjaman Non-Siswa</th>
                            <th>Total Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukuPopuler as $index => $buku)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $buku->KodeBuku }}</td>
                                <td>{{ $buku->judul }}</td>
                                <td>{{ $buku->kategori->nama }}</td>
                                <td>{{ $buku->rak->nama }}</td>
                                <td>{{ $buku->peminjaman_siswa_count }}</td>
                                <td>{{ $buku->peminjaman_non_siswa_count }}</td>
                                <td>{{ $buku->total_peminjaman }}</td>
                            </tr>
                        @endforeach
        </tbody>
    </table>
</body>
</html>
