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
                <td>{{ $item->tempat_lahir . ', ' . date('d F Y', strtotime($item->tanggal_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>ALamat</td>
                <td>
                    @if (isset($item->alamat_santri))
                        {{ ucwords(strtolower($item->alamat_santri->dusun . ', ' . $item->alamat_santri->kelurahan->name . ', ' . $item->alamat_santri->kecamatan->name . ', ' . $item->alamat_santri->kabupaten->name)) }}
                    @endif
                </td>
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
                @if ($item->foto !== 'santri.png')
                    <img src="{{ url('storage/uploads/santri') . '/' . $item->foto }}" alt="santri" class="img-fluid"
                        width="100px">
                @else
                    <img src="{{ url('img') . '/' . $item->foto }}" alt="santri" class="img-fluid rounded-circle"
                        width="100px">
                @endif
            </tr>
            <tr>
                <td>Data Kependudukan</td>
                <td>{{ 'NIK : ' . $item->nik . ' - KK : ' . $item->kk }}</td>
            </tr>
            @if ($item->status == 'Santri Aktif')
                <tr>
                    <td>Kelas</td>
                    <td>{{ isset($item->kelas_santri) ? $item->kelas_santri->kelas->tingkatan . ' - ' . $item->kelas_santri->kelas->kelas : '' }}
                    </td>
                </tr>
                <tr>
                    <td>Kamar</td>
                    <td>{{ isset($item->kamar_santri) ? $item->kamar_santri->kamar->nama . ' BLOK ' . $item->kamar_santri->kamar->blok : '' }}
                    </td>
                </tr>
            @endif
            <tr>
                <td>Nama Ayah</td>
                <td>{{ isset($item->wali_santri) ? $item->wali_santri->nama_ayah : '' }}</td>
            </tr>
            <tr>
                <td>Nama Ibu</td>
                <td>{{ isset($item->wali_santri) ? $item->wali_santri->nama_ibu : '' }}</td>
            </tr>
        </tbody>
    </table>
</div>
