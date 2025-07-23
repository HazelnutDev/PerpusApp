<table>
    <thead>
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
                <td>{{ $buku->Judul }}</td>
                <td>{{ optional($buku->kategori)->nama ?? 'Tidak Ada' }}</td>
                <td>{{ optional($buku->rak)->nama ?? 'Tidak Ada' }}</td>
                <td>{{ $buku->PeminjamanSiswa ?? 0 }}</td>
                <td>{{ $buku->PeminjamanNonSiswa ?? 0 }}</td>
                <td>{{ $buku->total_peminjaman ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 