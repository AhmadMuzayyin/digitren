@php
    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT KTS - {{ strtoupper($santri->user->name) }}</title>
</head>

<body>
    <img src="{{ url('img/kts-depan.png') }}" alt="">

    {{-- no induk dan nama --}}
    <p style="position: absolute; margin-top: -30rem; margin-left: 20%; font-size: 27px; color: #333333">
        {{ ucwords($santri->no_induk) }}
        <span style="margin-left: 29rem; margin-top: -10%">
            <img src="{{ 'data:image/png;base64,' . DNS1D::getBarcodePNG($santri->no_induk, 'C128') }}" alt="">
        </span>
    </p>
    <p style="position: absolute; margin-top: -27.3rem; margin-left: 20%; font-size: 27px; color: #333333">
        {{ ucwords($santri->user->name) }}</p>

    {{-- biodata --}}
    @php
        $ttl = $santri->tanggal_lahir . ' ' . $bulan[$santri->bulan_lahir] . ' ' . $santri->tahun_lahir;
    @endphp
    <p style="position: absolute; margin-top: -25rem; margin-left: 45%; font-size: 27px; color: #333333">
        {{ ucwords($santri->tempat_lahir . ', ' . $ttl) }}</p>
    <p style="position: absolute; margin-top: -20.2rem; margin-left: 45%; font-size: 27px; color: #333333">
        {{ ucwords($santri->wali_santri[0]->nama) }}</p>
    <p style="position: absolute; margin-top: -17.7rem; margin-left: 45%; font-size: 27px; color: #333333">
        {{ ucwords($santri->wali_santri[1]->nama) }}</p>
    {{-- alamat --}}
    <p style="position: absolute; margin-top: -15.5rem; margin-left: 45%; font-size: 27px; color: #333333">
        {{ ucwords(strtolower($santri->desa . ', ' . $santri->kecamatan . ', ' . $santri->kabupaten)) }}</p>

    <script>
        window.print()
        setInterval(() => {
            window.close()
        }, 100);
    </script>
</body>

</html>
