<table>
    <thead>
    <tr>
        <th>Nomor Induk</th>
        <th>Debit</th>
        <th>Kredit</th>
        <th>Saldo</th>
        <th>Tanggal Transaksi</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tabungan as $val)
        <tr>
            <td>{{ $val->santri->no_induk }}</td>
            <td>
                @if($val->jenis_transaksi === 'Setoran')
                    {{ $val->jumlah_transaksi }}
                @endif
            </td>
            <td>
                @if($val->jenis_transaksi === 'Penarikan')
                    {{ $val->jumlah_transaksi }}
                @endif
            </td>
            <td>{{ $val->saldo_saatini }}</td>
            <td>{{ $val->tanggal_transaksi }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
