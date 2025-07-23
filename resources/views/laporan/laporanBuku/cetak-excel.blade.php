<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Buku</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>No UDC</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        @foreach($buku as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->KodeBuku }}</td>
                <td>{{ $item->Judul }}</td>
                <td>{{ $item->Pengarang }}</td>
                <td>{{ $item->Penerbit }}</td>
                <td>{{ $item->TahunTerbit }}</td>
                <td>{{ $item->NoUDC ?? '-' }}</td>
                <td>{{ $item->Stok }}</td>
            </tr>
        @endforeach
    </tbody>
</table> 