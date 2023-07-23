@extends('member.dashboard')

@push('member_css')
{{-- <link rel="stylesheet" href="{{ asset('vendor/filepond/css/app.css') }}" /> --}}
@endpush

@section('member')
        @if (!auth()->user()->member)
            <div class="row">
                <div class="col-sm-1 col-md-2"></div>
                <div class="col-sm-10 col-md-8 col-12">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Peringatan!</strong> Lengkapi dulu data anda sebelum melakukan pembelian asuransi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="card shadow" style="opacity: 0.955 !important;">
                        <div class="card-header py-3">
                            <h4 class="text-center">Silahkan isi dengan benar.</h4>
                        </div>
                        <div class="card-body mx-2">
                            <form action="">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="hidden" name="user_id" class="user_id" value="{{ auth()->user()->id }}">
                                    <input type="text" class="form-control" id="nama" placeholder="Nama">
                                    <small class="text-danger nama_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="nik" class="form-label">Nomor KTP (NIK) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="nik" placeholder="Nomor KTP (NIK)">
                                    <small class="text-danger nik_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nohp" placeholder="Nomor HP">
                                    <small class="text-danger nohp_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <div class="mb-3">
                                        <select class="form-select provinsi" aria-label="Default select example" name="provinsi" id="provinsi">
                                            <option value="" disabled selected>Pilih Provinsi</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->id }}">{{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger provinsi_error"></small>
                                    </div>
                                    <div class="mb-3 select_kabkota">
                                        <select class="form-select kab_kota" aria-label="Default select example" name="kab_kota" id="kab_kota" disabled="disabled">
                                            <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                                        </select>
                                        <small class="text-danger provinsi_id_error"></small>
                                    </div>
                                    <textarea name="alamat" class="form-control" id="alamat" rows="3" placeholder="Alamat"></textarea>
                                    <small class="text-danger alamat_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="bank" class="form-label">Bank <span class="text-danger">*</span></label>
                                    <select class="form-select bank" aria-label="Default select example" name="bank" id="bank">
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger bank_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="rek" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="rek" placeholder="Nomor Rekening">
                                    <small class="text-danger rek_error"></small>
                                </div>
                                <div class="d-flex justify-content-center py-3">
                                    <button type="submit" class="btn btn-primary shadow create" style="width: 150px;">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 col-md-2"></div>
            </div>
        @else
        <div class="row">
            <div class="col-md-2 col-sm-0"></div>
            <div class="col-md-8 col-sm-12">
                <div class="card shadow">
                    <div class="card-body" style="opacity: 0.955 !important;">
                        <h5 class="text-center border-bottom pb-3 mb-3">Member Profile <a class="btn btn-sm btn-warning" href="{{ URL::route('member.edit', ['id'=>$member->id]) }}" role="button"><i class="bi bi-pencil"></i></a></h5>
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between  px-2">
                                    <div class="fw-bold">
                                        Nama
                                    </div>
                                    <div class="">
                                        {{ $member->nama_lengkap }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between px-2">
                                    <div class="fw-bold">
                                        No. KTP (NIK)
                                    </div>
                                    <div class="">
                                        {{ $member->no_ktp }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between px-2">
                                    <div class="fw-bold">
                                        Nomor HP
                                    </div>
                                    <div class="">
                                        {{ $member->no_hp }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="d-flex justify-content-between px-2">
                                    <div class="fw-bold">
                                        Alamat
                                    </div>
                                    <div class="">
                                        {{ $member->alamat }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-0"></div>
        </div>
        @endif
@endsection

@push('member_js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
{{-- <script src="{{ asset('vendor/filepond/js/app.js') }}"></script> --}}
<script>
    $(document).ready(function () {

        $(document).on('click','.create', function (e) {
            e.preventDefault();
            let data = {
                user_id:$('.user_id').val(),
                nama: $('#nama').val(),
                nik: $('#nik').val(),
                nohp: $('#nohp').val(),
                kab_kota:$('#kab_kota option:selected').val(),
                provinsi:$('#provinsi option:selected').val(),
                alamat: $('#alamat').val(),
                bank: $('#bank').val(),
                rek: $('#rek').val(),
            }
            _input.loading.start(this);
            _ajax.post("{{ route('member.create') }}",data,
                (response) => {
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.href="{{ route('member.dashboard') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 400) {
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
        });

        $(document).on('change','#provinsi', function(e){
            e.preventDefault();
            let id = $('#provinsi option:selected').val();
            _ajax.get(`{{ url('/member/get-kab-kota') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        let option = [];(response.data).forEach(e => {option.push(`<option value="${e.id}">${e.nama}</option>`)});$('.select_kabkota').html(`<select class="form-select kab_kota" aria-label="Default select example" name="kab_kota" id="kab_kota"><option value="" disabled selected>Pilih Kabupaten/Kota</option>${option.join('')}</select><small class="text-danger kab_kota_error"></small>`);
                    }
                },(response) => {if (response.status == 404) {
                        _swalert(response);
                    }
                }
            )
        })

    });
</script>
@endpush
