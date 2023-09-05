<div class="table-responsive text-uppercase">
    <table class="table">
        <tbody>
            <tr>
                <td>No Induk</td>
                <td>{{ $item->no_induk }}</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $item->user->name }}</td>
            </tr>
            <tr>
                <td>Tempat/Tanggal Lahir</td>
                <td>{{ $item->tempat_lahir . ', ' . date('d', strtotime($item->tanggal_lahir)) . ' ' . date('F',
                    strtotime($item->bulan_lahir)) . ' ' . $item->tahun_lahir }}
                </td>
            </tr>
            <tr>
                <td>ALamat</td>
                <td>{{ $item->dusun . ', ' . $item->desa . ' ' . $item->kecamatan . ' ' . $item->kabupaten }}</td>
            </tr>
            <tr>
                <td>Jeni Kelamin</td>
                <td>{{ $item->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td>Tanggal Masuk</td>
                <td>{{ $item->tahun_masuk . ' - ' . $item->tahun_masuk_hijriyah }}</td>
            </tr>
            @if ($item->status === 'Santri Alumni')
            <tr>
                <td>Tanggal Boyong</td>
                <td>{{ $item->tanggal_boyong . ' - ' . $item->tanggal_boyong_hijriyah }}</td>
            </tr>
            @endif
            <tr>
                <td>Status</td>
                <td>{{ $item->status }}</td>
            </tr>
            <tr>
                <img src="{{ url('storage/uploads/santri') . '/' . $item->foto }}" alt="santri"
                    class="img-fluid rounded-circle" width="100px">
            </tr>
            <tr>
                <td>Data Kependudukan</td>
                <td>{{ 'NIK : ' . $item->nik . ' - KK : ' . $item->kk }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $item->kelas->tingkatan . ' - ' . $item->kelas->kelas }}</td>
            </tr>
            <tr>
                <td>Kamar</td>
                <td>{{ $item->kamar->nama . ' BLOK ' . $item->kamar->blok }}</td>
            </tr>
            <tr>
                <td>Nama Ayah</td>
                <td>{{ !$item->wali_santri->isEmpty() ? $item->wali_santri[0]->nama : '' }}</td>
            </tr>
            <tr>
                <td>Nama Ibu</td>
                <td>{{ !$item->wali_santri->isEmpty() ? $item->wali_santri[1]->nama : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>