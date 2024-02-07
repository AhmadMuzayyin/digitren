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

    <style>
        @media print {
            @page {
                margin: 0;
                size: landscape
                    /* Menghilangkan margin default untuk kertas cetak */
            }

            body {
                width: 240px;
                height: 295px;
            }
        }

        .bg {
            position: relative;
            z-index: 0;
        }

        .foto-santri {
            position: absolute;
            margin-left: 3.5%;
            margin-top: -30.3%;
            z-index: 0;
            width: 17.3%;
        }
    </style>
</head>

<body>
    <img src="{{ url('img/kts-depan.png') }}" alt="" class="bg">

    {{-- no induk dan nama --}}
    <p>
    <div class="row"style="position: absolute; margin-top: -30rem; margin-left: 15%; font-size: 27px; color: #333333">
        <div class="col" style="margin-top: -1%">
            {{ ucwords($santri->no_induk) }}
        </div>
        <div class="col" style="margin-left: 35.3rem; margin-top: -2rem">
            <span>
                <img src="{{ 'data:image/png;base64,' . DNS1D::getBarcodePNG($santri->no_induk, 'I25', 3, 60, [1, 1, 1]) }}"
                    alt="">
            </span>
        </div>
    </div>
    </p>
    <p style="position: absolute; margin-top: -28.5rem; margin-left: 15%; font-size: 27px; color: #333333">
        {{ ucwords($santri->user->name) }}</p>

    {{-- biodata --}}
    <p style="position: absolute; margin-top: -26rem; margin-left: 34%; font-size: 27px; color: #333333">
        {{ ucwords($santri->tempat_lahir . ', ' . date('d-m-Y', strtotime($santri->tanggal_lahir))) }}</p>
    <p style="position: absolute; margin-top: -21.2rem; margin-left: 34%; font-size: 27px; color: #333333">
        {{ ucwords($santri->wali_santri->nama_ayah) }}</p>
    <p style="position: absolute; margin-top: -18.7rem; margin-left: 34%; font-size: 27px; color: #333333">
        {{ ucwords($santri->wali_santri->nama_ibu) }}</p>
    {{-- alamat --}}
    <p style="position: absolute; margin-top: -16.5rem; margin-left: 34%; font-size: 27px; color: #333333">
        {{ ucwords(strtolower($santri->alamat_santri->kelurahan->name . ', ' . $santri->alamat_santri->kecamatan->name . ', ' . $santri->alamat_santri->kabupaten->name)) }}
    </p>

    {{-- foto santri --}}
    <img src="{{ url('/storage/uploads/santri/' . $santri->foto) }}" alt="{{ $santri->foto }}" class="foto-santri">
    <script>
        window.print()
        setInterval(() => {
            window.close()
        }, 1000);
    </script>
</body>

</html>
