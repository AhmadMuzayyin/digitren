<div class="row mt-5">
    <div class="col">
        <ul>
            <li>Minimal Setoran Rp. 50.000</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="card bg-info">
            <div class="card-body">
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jenis_transaksi" id="jenis_transaksi" value="Setoran">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" id="santri_noinduk" name="santri_noinduk"
                                readonly>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" id="santri_nama" name="santri_nama" readonly>
                        </div>
                    </div>
                    <div class="input-group mt-4">
                        <span class="input-group-text" id="basic-addon1">Rp</span>
                        <input type="text" class="form-control" placeholder="Nominal" name="debit" id="debit"
                            required>
                    </div>
                    <div class="row mt-5">
                        <div class="col text-end">
                            <button type="submit" class="btn btn-warning">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col text-center">
        <div class="card bg-info">
            <div class="card-body">
                <div style="display: none" id="foto_santri">
                    <img src="" alt="santri" class="img-fluid rounded-circle" id="santri_profile"
                        width="175">
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        $(document).ready(function() {
            $('#debit').on('input', function() {
                // Hanya membiarkan angka (0-9) dan tombol khusus lainnya seperti Enter dan Backspace
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
        $(document).ready(function() {
            $('#no_induk').on('input', function() {
                if ($(this).val() !== '') {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length == 8) {
                        $('#spinner').show()
                        setTimeout(() => {
                            $.ajax({
                                url: "{{ route('transaksi.index') }}",
                                method: "GET",
                                data: {
                                    no_induk: $(this).val()
                                },
                                success: (res) => {
                                    if (res.data) {
                                        var data = res.data
                                        $('#santri_noinduk').val(data.no_induk)
                                        $('#santri_nama').val(data.name)
                                        $('#foto_santri').show()
                                        if (data.foto === 'santri.png') {
                                            $('#santri_profile').attr('src',
                                                '/img/' + data
                                                .foto)
                                        } else {
                                            $('#santri_profile').attr('src',
                                                '/storage/uploads/santri/' + data
                                                .foto)
                                        }
                                        $('#santri_id').val(data.id)
                                        $('#debit').focus()
                                        $('#saldo').text(data.saldo)
                                        $('#spinner').hide()
                                    } else {
                                        $('#spinner').hide()
                                        $('#santri_noinduk').val("")
                                        $('#santri_nama').val("")
                                        $('#foto_santri').hide()
                                        $('#saldo').text("000000")
                                        Lobibox.notify('error', {
                                            pauseDelayOnHover: true,
                                            icon: 'bx bx-error',
                                            continueDelayOnInactiveTab: false,
                                            position: 'top right',
                                            size: 'mini',
                                            msg: res.message
                                        });
                                    }
                                }
                            })
                        }, 1000);
                    }
                } else {
                    $('#spinner').show()
                    setTimeout(() => {
                        $('#spinner').hide()
                        $('#santri_noinduk').val("")
                        $('#santri_nama').val("")
                        $('#foto_santri').hide()
                        $('#saldo').text("000000")
                    }, 500);
                }
            })
        })
    </script>
@endpush
