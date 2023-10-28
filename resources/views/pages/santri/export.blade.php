<table>
    <thead>
        <tr>
            <th>Nomor Induk</th>
            <th>Nama Lengkap</th>
            <th>Tingkat - Kelas</th>
            <th>Kamar</th>
            <th>Dusun</th>
            <th>Desa</th>
            <th>Kecamatan</th>
            <th>Kabupaten</th>
            <th>Provinsi</th>
            <th>Jenis Kelamin</th>
            <th>Data Kependudukan</th>
            <th>No Whatsapp</th>
            <th>Tempat Tanggal Lahir</th>
            <th>Tahun Masuk M/H</th>
            <th>Tanggal Boyong M/H</th>
            <th>Status</th>
            <th>Wali Santri</th>
        </tr>
    </thead>
    <tbody>
        @foreach($santri as $person)
            <tr>
                <td>{{ $person->no_induk }}</td>
                <td>{{ $person->user->name }}</td>
                <td>{{ $person->kelas->tingkatan . ' - ' . $person->kelas->kelas }}</td>
                <td>{{ $person->kamar->nama }}</td>
                <td>{{ $person->dusun }}</td>
                <td>{{ $person->desa }}</td>
                <td>{{ $person->kecamatan }}</td>
                <td>{{ $person->kabupaten }}</td>
                <td>{{ $person->provinsi }}</td>
                <td>{{ $person->jenis_kelamin }}</td>
                <td>{{ "NIK: $person->nik - KK: $person->kk" }}</td>
                <td>{{ "https://wa.me/$person->whatsapp" }}</td>
                <td>{{ "$person->tempat_lahir, $person->tanggal_lahir $person->bulan_lahir $person->tahun_lahir" }}</td>
                <td>{{ "$person->tahun_masuk / $person->tahun_masuk_hijriyah" }}</td>
                <td>{{ "$person->tanggal_boyong / $person->tanggal_boyong_hijriyah" }}</td>
                <td>{{ $person->status }}</td>
                <td>
                    {{
                        "Nama Ayah: " . $person->wali_santri[0]->nama.
                        " Nama Ibu: " . $person->wali_santri[1]->nama
                    }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
