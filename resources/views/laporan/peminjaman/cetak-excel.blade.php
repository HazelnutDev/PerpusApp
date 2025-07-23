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
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $index => $pinjam)
            @foreach($pinjam->detailPeminjaman as $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pinjam->TglPinjam ? \Carbon\Carbon::parse($pinjam->TglPinjam)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                            {{ $pinjam->NoPinjamM }}
                        @else
                            {{ $pinjam->NoPinjamN }}
                        @endif
                    </td>
                    <td>{{ $pinjam->anggota->NamaAnggota ?? '-' }}</td>
                    <td>
                        @if($pinjam instanceof \App\Models\PeminjamanSiswa)
                            Siswa
                        @else
                            Non-Siswa
                        @endif
                    </td>
                    <td>{{ $detail->buku->Judul ?? '-' }}</td>
                    <td>{{ $detail->petugas->Nama ?? '-' }}</td>
                    <td>{{ $pinjam->TglJatuhTempo ? \Carbon\Carbon::parse($pinjam->TglJatuhTempo)->format('d-m-Y') : '-' }}</td>
                    <td>
                        @if($pinjam->pengembalian)
                            Dikembalikan
                        @else
                            @if($pinjam->TglJatuhTempo < now())
                                Terlambat
                            @else
                                Dipinjam
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table> 