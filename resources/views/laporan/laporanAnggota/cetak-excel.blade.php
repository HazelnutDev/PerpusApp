<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>No Anggota</th>
            <th>Nama</th>
            <th>NIS / NIP</th>
            <th>Kelas / Pekerjaan</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Nama Ortu</th>
            <th>No Telp Ortu</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($anggota as $index => $a)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $a->jenis }}</td>
                <td>{{ $a->KodeAnggota ?? ($a->NoAnggotaM ?? $a->NoAnggotaN ?? '-') }}</td>
                <td>{{ $a->NamaAnggota ?? '-' }}</td>
                <td>{{ $a->NIS ?? $a->NIP ?? '-' }}</td>
                <td>{{ $a->Kelas ?? $a->Pekerjaan ?? '-' }}</td>
                <td>{{ $a->JenisKelamin ?? '-' }}</td>
                <td>{{ $a->TanggalLahir ? \Carbon\Carbon::parse($a->TanggalLahir)->format('d-m-Y') : '-' }}</td>
                <td>{{ $a->Alamat ?? '-' }}</td>
                <td>{{ $a->NoTelp ?? '-' }}</td>
                <td>{{ $a->NamaOrtu ?? '-' }}</td>
                <td>{{ $a->NoTelpOrtu ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 