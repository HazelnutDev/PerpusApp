<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0 0 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
        }
        .bg-success {
            background-color: #28a745;
            color: white;
        }
        .bg-warning {
            background-color: #ffc107;
            color: #000;
        }
        .bg-danger {
            background-color: #dc3545;
            color: white;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>LAPORAN DATA buku</h3>
        <p>PERPUSTAKAAN SMP TEPAL</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
        @if(request('status') == 'tersedia')
            <p>Status: Tersedia</p>
        @elseif(request('status') == 'tidak_tersedia')
            <p>Status: Tidak Tersedia</p>
        @endif
        @if(request('search'))
            <p>Kata Kunci: {{ request('search') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Buku</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($buku as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->KodeBuku }}</td>
                    <td>{{ $item->Judul }}</td>
                    <td>{{ $item->Pengarang ?? '-' }}</td>
                    <td>{{ $item->Penerbit ?? '-' }}</td>
                    <td class="text-center">{{ $item->TahunTerbit ?? '-' }}</td>
                    <td class="text-center">{{ $item->Stok ?? 0 }}</td>
                    <td class="text-center">
                        @php
                            $status = ($item->Stok ?? 0) > 0 ? 'Tersedia' : 'Tidak Tersedia';
                            $badgeClass = $status == 'Tersedia' ? 'bg-success' : 'bg-danger';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div style="margin-top: 50px;">
            <div>Mengetahui,</div>
            <div style="margin-top: 60px;">
                <div>Kepala Perpustakaan</div>
            </div>
        </div>
    </div>
</body>
</html>
