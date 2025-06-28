<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Data Anggota</title>
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
        .bg-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>LAPORAN DATA anggota</h3>
        <p>PERPUSTAKAAN SMP TEPAL</p>
        <p>Periode: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Anggota</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggota as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->NoAnggotaM ?? $item->NoAnggotaN ?? '-' }}</td>
                    <td>{{ $item->NamaAnggota ?? $item->Nama ?? '-' }}</td>
                    <td class="text-center">{{ $item->JenisKelamin ?? '-' }}</td>
                    <td>{{ $item->Alamat ?? '-' }}</td>
                    <td>{{ $item->NoTelp ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $status = $item->StatusAktif ?? $item->Status ?? 'Tidak Aktif';
                            $badgeClass = $status == 'Aktif' ? 'bg-success' : 'bg-secondary';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data anggota</td>
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
