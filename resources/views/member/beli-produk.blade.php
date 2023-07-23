@extends('member.dashboard')

@section('member')
<div class="row">
    <div class="col-sm-1 col-md-2"></div>
    <div class="col-sm-10 col-md-8 col-12">
        <div class="card shadow" style="opacity: 0.955 !important;">
            <div class="card-header py-3">
                <h4 class="text-center">Silahkan isi form dengan benar.</h4>
            </div>
            <div class="card-body mx-2">
                <form action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="produk" class="form-label">Produk Asuransi <span class="text-danger">*</span></label>
                        <select class="form-select produk" aria-label="Default select example" name="produk" id="produk">
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->nama_produk }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger produk_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis Hewan <span class="text-danger">*</span></label>
                        <select class="form-select jenis" aria-label="Default select example" name="jenis" id="jenis">
                            <option value="0">Pilih Jenis Hewan</option>
                            @foreach ($jeniss as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger bank_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="ras" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                        <div class="ras_select">
                            <select class="form-select ras" aria-label="Default select example" name="ras" id="ras" disabled style="cursor: no-drop">
                                <option value="">Pilih Ras</option>
                            </select>
                        </div>
                        <small class="text-danger bank_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nama_hewan" class="form-label">Nama Hewan Peliharaan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_hewan" placeholder="Nama Hewan">
                        <small class="text-danger nama_hewan_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_pemilik" placeholder="Nama Pemilik">
                        <small class="text-danger nama_pemilik_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Hewan <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="foto" name="foto">
                        <small class="text-danger foto_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Jenis Kelamin Hewan <span class="text-danger">*</span></label>
                        <select class="form-select gender" aria-label="Default select example" name="gender" id="gender">
                            <option value="Jantan">Jantan</option>
                            <option value="Betina">Betina</option>
                        </select>
                        <small class="text-danger gender_error"></small>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="">
                                <label for="tgl_lahir_hewan" class="form-label">Tanggal Lahir Hewan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_lahir" placeholder="Tanggal Lahir">
                                <small class="text-danger tgl_lahir_error"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label for="berat_badan" class="form-label">Bobot Hewan (Kg) <span class="text-danger">*</span></label>
                                <input type="number" min="0" oninput="this.value=Math.abs(this.value)" class="form-control" id="bobot" placeholder="Berat">
                                <small class="text-danger bobot_error"></small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="jangka_waktu" class="form-label">Jangka Waktu Asuransi <span class="text-danger">*</span></label>
                        <select class="form-select jangka_waktu" aria-label="Default select example" name="jangka_waktu" id="jangka_waktu">
                            <option value="1">1 Tahun</option>
                            <option value="2">2 Tahun</option>
                        </select>
                        <small class="text-danger jangka_waktu_error"></small>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="tnc" value="1" id="tnc">
                        <label class="form-check-label" for="tnc" style="font-size: .8em;">
                            Dengan ini saya menyetujui <a href="{{ route('home.tnc') }}" class="fw-bold text-dark" target="_blank">Term & Conditions.</a>
                        </label>
                    </div>
                    <div class="d-flex justify-content-center py-3">
                        <button type="submit" class="btn btn-primary shadow create" style="width: 150px;" disabled="disabled">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-1 col-md-2"></div>
</div>
@endsection

@push('member_js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#tnc').on('change', function () {
            $(this).prop('checked')?$('.create').removeAttr('disabled'):$('.create').attr('disabled','disabled');
        });
        $(document).on('change','#jenis',function(e){
            e.preventDefault()
            let id = $(this).val();

            if (id==0) {
                $('#ras').attr('disabled','disabled');
                $('#ras').css('cursor', 'no-drop');
            } else {
                _ajax.get("{{ url('/pembelian/getRas') }}/"+id,
                    (response) => {
                        if (response.status == 200) {
                            let option = [];

                            response.ras.map(e => {
                                let premi = e.harga_hewan*(5/100);
                                option.push(`<option value='${e.id}'>${e.nama_ras} (premi Rp${premi.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")})</option>`);
                            })
                            $('.ras_select').html(`<select class="form-select ras" aria-label="Default select example" name="ras" id="ras">
                                <option value="">Pilih Ras</option>
                                ${option.join('')}
                            </select>`);
                        }
                    }
                );
            }
        });

        $(document).on('click','.create', function (e) {
            e.preventDefault();
            var files = $('#foto')[0].files;
            let data = new FormData();
            data.append('foto',files[0]);
            data.append('produk_id',$('#produk option:selected').val());
            data.append('jenis_hewan',$('#jenis option:selected').val());
            data.append('ras_hewan',$('#ras option:selected').val());
            data.append('nama_hewan',$('#nama_hewan').val());
            data.append('nama_pemilik',$('#nama_pemilik').val());
            data.append('jenis_kelamin',$('#gender option:selected').val());
            data.append('tgl_lahir',$('#tgl_lahir').val());
            data.append('bobot',$('#bobot').val());
            data.append('jangka_waktu',$('#jangka_waktu option:selected').val());
            _input.loading.start(this);
            Swal.fire({
                title: 'Biaya Pendaftaran',
                html:'<span class="badge text-bg-success fs-5 py-3">IDR 138.000,00</span>',
                showConfirmButton: true,
                confirmButtonText: 'Lanjutkan Pembayaran',
                showCancelButton: true,
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if(result.isConfirmed) {
                    _input.loading.stop('.create','Kirim');
                    _ajax.postWithFile("{{ route('pembelian.create') }}",data,
                        (response) => {
                            if (response.status == 200) {
                                _swalert(response);
                                setTimeout(() => {
                                    window.location.href="{{ route('pembelian.bayar') }}";
                                }, 1500);
                            }
                        },
                        (response) => {
                            if (response.status == 400) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Perhatikan inputan anda dengan benar',
                                })
                                _validation.action(response.responseJSON)
                            } else if (response.status == 404) {
                                _swalert(response);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan!',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        }
                    );
                } else {
                    _input.loading.stop('.create','Kirim');
                }
            })
        });
    });
</script>
@endpush
