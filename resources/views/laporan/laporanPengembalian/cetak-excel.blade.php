<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peminjam</th>
            <th>Jenis</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Tanggal Kembali</th>
            <th>Petugas</th>
            <th>Denda</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengembalian as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['Nama'] ?? '-' }}</td>
                <td>{{ $item['Jenis'] ?? '-' }}</td>
                <td>{{ $item['Judul'] ?? '-' }}</td>
                <td>{{ $item['TglPinjam'] ? \Carbon\Carbon::parse($item['TglPinjam'])->format('d-m-Y') : '-' }}</td>
                <td>{{ $item['JatuhTempo'] ? \Carbon\Carbon::parse($item['JatuhTempo'])->format('d-m-Y') : '-' }}</td>
                <td>{{ $item['TglKembali'] ? \Carbon\Carbon::parse($item['TglKembali'])->format('d-m-Y') : '-' }}</td>
                <td>{{ $item['Petugas'] ?? '-' }}</td>
                <td>Rp {{ number_format($item['Denda'] ?? 0, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 