@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<style>
    iframe {
        width: 150px;
        height: 80px;
    }
</style>
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary add" data-bs-toggle="modal" data-bs-target="#modal_create">
                <i class="align-middle" data-feather="plus"></i> Tambah Data
            </button>
        </div>
        <div class="card-body">
            <table id="datatable" class="table w-100 table-hover">
                <thead>
                    <tr>
                        <th>Nama Petshop</th>
                        <th>Kabupaten/Kota</th>
                        <th>Keterangan</th>
                        <th>Google Maps</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="modal fade" id="modal_create" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Data {{ $title }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="create">
                            <div class="mb-3">
                                <label class="form-label required">Kabupaten/Kota <i class="text-danger">*</i></label>
                                <select class="form-control form-control-sm choice kab_kota" name="kab_kota" id="kab_kota">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach ($kabkotas as $kk)
                                        <option value="{{ $kk->id }}">{{ $kk->nama }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger kab_kota_id_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nama Petshop <i class="text-danger">*</i></label>
                                <input id="nama" type="text" name="nama" class="form-control" placeholder="Nama">
                                <small class="text-danger nama_petshop_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Petshop <i class="text-danger">*</i></label>
                                <textarea id="alamat" class="form-control alamat" name="alamat" placeholder="Alamat" rows="2"></textarea>
                                <small class="text-danger alamat_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">GMAPS Iframe <i class="text-danger">*</i></label>
                                <textarea id="gmaps_iframe" class="form-control gmaps_iframe" name="gmaps_iframe" placeholder="Tag iframe dari google maps" rows="2"></textarea>
                                <small class="text-danger gmaps_iframe_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea id="keterangan" class="form-control keterangan" name="keterangan" placeholder="Keterangan Petshop" rows="2"></textarea>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary ms-2 create">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_edit" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Data {{ $title }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <form id="edit">
                            <div class="mb-3">
                                <label class="form-label required">Kabupaten/Kota <i class="text-danger">*</i></label>
                                <div class="select_edit">
                                    <select class="form-control form-control-sm">
                                        <option value="">Loading...</option>
                                    </select>
                                </div>
                                <small class="text-danger provinsi_id_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nama Petshop <i class="text-danger">*</i></label>
                                <input type="hidden" name="edit_id" class="edit_id">
                                <input id="edit_nama" type="text" name="edit_nama" class="form-control" placeholder="Nama">
                                <small class="text-danger nama_petshop_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Petshop <i class="text-danger">*</i></label>
                                <textarea id="edit_alamat" class="form-control alamat" name="edit_alamat" placeholder="Alamat" rows="2"></textarea>
                                <small class="text-danger alamat_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">GMAPS Iframe <i class="text-danger">*</i></label>
                                <textarea id="edit_gmaps_iframe" class="form-control gmaps_iframe" name="edit_gmaps_iframe" placeholder="Tag iframe dari google maps" rows="2"></textarea>
                                <small class="text-danger gmaps_iframe_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea id="edit_keterangan" class="form-control keterangan" name="edit_keterangan" placeholder="Keterangan Petshop" rows="2"></textarea>
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary ms-2 update">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script src="{{ asset('dashboard/libs/choice-js/js/app.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script>
    $(document).ready(function () {
        _table.set("{{ route('petshop-terdekat.data') }}",
            [
                {data: 'nama_petshop', name: 'nama_petshop'},
                {data: 'kab_kota_id.nama', name: 'kab_kota_id.nama'},
                {data: 'keterangan_petshop', name: 'keterangan_petshop'},
                {data: 'gmaps_iframe', name: 'gmaps_iframe'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        );
        new Choices('.choice');
        _form.reset('.add','#create');

        $(document).on('click','.create',function (e) {
            e.preventDefault();
            let data = {
                'nama_petshop':$('#nama').val(),
                'keterangan_petshop':$('#keterangan').val(),
                'gmaps_iframe':$('#gmaps_iframe').val(),
                'alamat':$('#alamat').val(),
                'kab_kota_id':$('#kab_kota option:selected').val(),
            }
            _input.loading.start(this);
            _ajax.post("{{ route('master-data.petshop-terdekat.create') }}",data,
                (response)=>{
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        _table.reload();
                    }
                },
                (response)=>{
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

        $(document).on('click','.edit', function(e) {
            e.preventDefault()
            $('form#edit').trigger('reset');
            let id = $(this).data('id');
            _ajax.get(`{{ url('/auth/dashboard/petshop-terdekat/edit') }}/${id}`,
                (response) => {
                    $('#modal_edit').modal('show');
                    if (response.status == 200) {
                        $('#edit_nama').val(response.data.nama_petshop);
                        $('.edit_id').val(response.data.id);
                        $('#edit_keterangan').val(response.data.keterangan_petshop);
                        $('#edit_alamat').val(response.data.alamat);
                        $('#edit_gmaps_iframe').val(response.data.gmaps_iframe);
                        let options = [];response.kabkota.forEach(e=>{response.data.kab_kota_id==e.id?options.push(`<option value="${e.id}" selected>${e.nama}</option>`):options.push(`<option value="${e.id}">${e.nama}</option>`);});$('.select_edit').html(`<select class="form-control form-control-sm choice_edit edit_kab_kota" name="edit_kab_kota" id="kab_kota">${options.join('')}</select>`);new Choices('.choice_edit');
                    }
                },
                (response) => {
                    if (response.status == 422) {
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

        $(document).on('click','.update', function(e){
            e.preventDefault();
            let data = {
                'id':$('.edit_id').val(),
                'nama_petshop':$('#edit_nama').val(),
                'keterangan_petshop':$('#edit_keterangan').val(),
                'gmaps_iframe':$('#edit_gmaps_iframe').val(),
                'alamat':$('#edit_alamat').val(),
                'kab_kota_id':$('.edit_kab_kota option:selected').val(),
            }
            _input.loading.start(this);
            _ajax.put(`{{ url('/auth/dashboard/petshop-terdekat/update') }}/${data.id}`,data,
                (response) => {
                    _input.loading.stop('.update','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        _table.reload();
                    }
                },
                (response) => {
                    _input.loading.stop('.update','Kirim');
                    if (response.status == 400) {
                        _validation.action(response.responseJSON);
                    } else if (response.status == 404) {
                        _swalert(response);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                }
            );
        });

        $(document).on('click','.delete', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apa Anda Yakin ?',
                text: "Anda tidak akan dapat mengembalikan data ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus data ini !',
            }).then((result) => {
                if (result.isConfirmed) {
                    let id = $(this).data('id');
                    _ajax.get(`{{ url('/auth/dashboard/petshop-terdekat/delete') }}/${id}`,
                        (response)=>{
                            if (response.status == 200) {
                                Swal.fire({
                                    title: 'Data terhapus!',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                _table.reload();
                            }
                        },
                        (response)=>{
                            Swal.fire({
                                title: 'Data tidak terhapus!',
                                icon: 'info',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    );
                }
            });
        })

    });
</script>
@endpush
