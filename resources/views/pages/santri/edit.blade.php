@extends('layouts.app')

@section('title', 'Santri | DIGITREN')

@section('content')
    <div>
        <!--page-wrapper-->
        <div class="page-wrapper">
            <!--page-content-wrapper-->
            <div class="page-content-wrapper">
                <div class="page-content">
                    <x-breadcrumb url="{{ route('dashboard') }}" attribute="required" path='Santri'></x-breadcrumb>
                    <div class="card">
                        <div class="card-body">
                            <div id="invoice">
                                <div class="toolbar hidden-print">
                                    <div class="text-end">
                                        <a href="{{ route('santri.index') }}" type="button" class="btn btn-primary">
                                            Kembali
                                        </a>
                                    </div>
                                    <hr />
                                </div>
                            </div>
                            <form action="{{ route('santri.update', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                @include('pages.santri.include.form')
                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route('santri.index') }}" type="button" class="btn btn-info">
                                    Kembali
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@if (isset($item->alamat_santri))
    @push('js')
        <script>
            // $('#editModal-' + "{{ $item->id }}").on('shown.bs.modal', function() {
            var provinsiData = {!! json_encode($provinsi) !!};
            $("#provinsi_id-{{ $item->id }}").empty();
            $("#provinsi_id-{{ $item->id }}").append(
                '<option value="" selected disabled>Pilih Provinsi</option>');
            var prov = "{{ $item->alamat_santri->provinsi->id }}";
            $.each(provinsiData, function(key, value) {
                var option = $('<option value="' + value.id + '">' + value
                    .name + '</option>');
                if (value.id == prov) {
                    option.attr('selected', 'selected');
                }
                $("#provinsi_id-{{ $item->id }}").append(option);
            });
            var kab = "{{ $item->alamat_santri->kabupaten->id }}";
            $.ajax({
                url: "{{ route('alamat.kabupaten') }}",
                method: 'GET',
                data: {
                    provinsi_id: prov
                },
                success: function(data) {
                    $("#kabupaten_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kab) {
                            option.attr('selected', 'selected');
                        }
                        $("#kabupaten_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
            var kec = "{{ $item->alamat_santri->kecamatan->id }}";
            $.ajax({
                url: "{{ route('alamat.kecamatan') }}",
                method: 'GET',
                data: {
                    kabupaten_id: kab
                },
                success: function(data) {
                    $("#kecamatan_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kec) {
                            option.attr('selected', 'selected');
                        }
                        $("#kecamatan_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
            var kel = "{{ $item->alamat_santri->kelurahan->id }}";
            $.ajax({
                url: "{{ route('alamat.kelurahan') }}",
                method: 'GET',
                data: {
                    kecamatan_id: kec
                },
                success: function(data) {
                    $("#kelurahan_id-{{ $item->id }}").empty();
                    $.each(data, function(key, value) {
                        var option = $('<option value="' + value.id + '">' + value
                            .name + '</option>');
                        if (value.id == kel) {
                            option.attr('selected', 'selected');
                        }
                        $("#kelurahan_id-{{ $item->id }}").append(option);
                    });
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });

            $("#provinsi_id-{{ $item->id }}").change(function() {
                var selectedProvinsi = $(this).val();
                var selectedKabupaten = "{{ $item->alamat_santri->kabupaten->id }}";
                $.ajax({
                    url: "{{ route('alamat.kabupaten') }}",
                    method: 'GET',
                    data: {
                        provinsi_id: selectedProvinsi
                    },
                    success: function(data) {
                        $("#kabupaten_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKabupaten) {
                                option.attr('selected', 'selected');
                            }
                            $("#kabupaten_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kabupaten_id-{{ $item->id }}").change(function() {
                var kabupaten_id = $(this).val();
                var selectedKecamatan = "{{ $item->alamat_santri->kabupaten->id }}";
                $.ajax({
                    url: "{{ route('alamat.kecamatan') }}",
                    method: 'GET',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    success: function(data) {
                        $("#kecamatan_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKecamatan) {
                                option.attr('selected', 'selected');
                            }
                            $("#kecamatan_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kecamatan_id-{{ $item->id }}").change(function() {
                var kecamatan_id = $(this).val();
                var selectedKelurahan = "{{ $item->alamat_santri->kelurahan->id }}";
                $.ajax({
                    url: "{{ route('alamat.kelurahan') }}",
                    method: 'GET',
                    data: {
                        kecamatan_id: kecamatan_id
                    },
                    success: function(data) {
                        $("#kelurahan_id-{{ $item->id }}").empty();
                        $.each(data, function(key, value) {
                            var option = $('<option value="' + value.id + '">' + value
                                .name + '</option>');
                            if (value.id == selectedKelurahan) {
                                option.attr('selected', 'selected');
                            }
                            $("#kelurahan_id-{{ $item->id }}").append(option);
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            // })
        </script>
    @endpush
@else
    @push('js')
        <script>
            var provinsiData = {!! json_encode($provinsi) !!};
            $('#provinsi_id-{{ $item->id }}').empty();
            $('#provinsi_id-{{ $item->id }}').append('<option value="" selected disabled>Pilih Provinsi</option>');
            $.each(provinsiData, function(key, value) {
                $('#provinsi_id-{{ $item->id }}').append('<option value="' + value.id + '">' + value.name +
                    '</option>');
            });
            $("#provinsi_id-{{ $item->id }}").change(function() {
                var selectedProvinsi = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kabupaten') }}",
                    method: 'GET',
                    data: {
                        provinsi_id: selectedProvinsi
                    },
                    success: function(data) {
                        $('#kabupaten_id-{{ $item->id }}').empty();
                        $.each(data, function(key, value) {
                            $('#kabupaten_id-{{ $item->id }}').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kabupaten_id-{{ $item->id }}").change(function() {
                var kabupaten_id = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kecamatan') }}",
                    method: 'GET',
                    data: {
                        kabupaten_id: kabupaten_id
                    },
                    success: function(data) {
                        $('#kecamatan_id-{{ $item->id }}').empty();
                        $.each(data, function(key, value) {
                            $('#kecamatan_id-{{ $item->id }}').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
            $("#kecamatan_id-{{ $item->id }}").change(function() {
                var kecamatan_id = $(this).val();
                $.ajax({
                    url: "{{ route('alamat.kelurahan') }}",
                    method: 'GET',
                    data: {
                        kecamatan_id: kecamatan_id
                    },
                    success: function(data) {
                        $('#kelurahan_id-{{ $item->id }}').empty();
                        $.each(data, function(key, value) {
                            $('#kelurahan_id-{{ $item->id }}').append(
                                '<option value = "' + value.id + '" > ' + value
                                .name +
                                '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            })
        </script>
    @endpush
@endif
