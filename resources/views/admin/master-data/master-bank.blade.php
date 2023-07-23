@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
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
            <table id="datatable" class="table w-100 table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Logo</th>
                        <th>Deskripsi</th>
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
                        <form id="create" action="{{ route('master-data.bank.create') }}" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label required">Nama Bank <i class="text-danger">*</i></label>
                                <input id="nama" type="text" name="nama" class="form-control" placeholder="Nama Bank">
                                <small class="text-danger nama_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Logo Bank <i class="text-danger">*</i></label>
                                <input id="logo" name="logo" class="form-control" type="file">
                                <small class="text-danger logo_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control" name="deskripsi" placeholder="Deskripsi" rows="2"></textarea>
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
                        <form id="edit" enctype="multipart/form-data">
                            <div class="mb-3">
                                <input type="hidden" name="id" class="id">
                                <label class="form-label required">Nama Bank <i class="text-danger">*</i></label>
                                <input id="nama" type="text" name="edit_nama" class="form-control edit_nama" placeholder="Nama Bank">
                                <small class="text-danger nama_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label w-100">Logo Bank <i class="text-danger">*</i></label>
                                <input id="logo" name="edit_logo" class="form-control edit_logo" type="file">
                                <small class="text-danger logo_error"></small>
                                <div class="old_logo"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control edit_deskripsi" name="edit_deskripsi" placeholder="Deskripsi" rows="2"></textarea>
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
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script>
    _table.set("{{ route('master-bank.data') }}",
        [
            {data: 'nama', name: 'nama'},
            {data: 'logo', name: 'logo'},
            {data: 'deskripsi', name: 'deskripsi'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
            },
        ]
    );

    _form.reset('.add','#create');

    $(document).on('click','.create',function(e) {
        e.preventDefault();
        var files = $('#logo')[0].files;
        let data = new FormData();
        data.append('logo',files[0]);
        data.append('nama',$('#nama').val());
        data.append('deskripsi',$('#deskripsi').val());
        _input.loading.start(this);
        _ajax.postWithFile("{{ route('master-data.bank.create') }}",data,
            (response) => {
                _input.loading.stop('.create','Kirim');
                if (response.status == 200) {
                    _swalert(response);
                    _table.reload();
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
        )
    });

    $(document).on('click','.edit', function(e) {
        e.preventDefault()
        $('form#edit').trigger('reset');
        let id = $(this).data('id');
        _ajax.get(`{{ url('/auth/dashboard/master-bank/edit') }}/${id}`,
            (response) => {
                $('#modal_edit').modal('show');
                if (response.status == 200) {
                    $('.id').val(id);
                    $('.edit_nama').val(response.data.nama);
                    $('.edit_deskripsi').val(response.data.deskripsi);
                    $('.old_logo').html(`<img id="old-logo" src="${response.data.logo}" width="100" class="mt-3" alt="Logo">`)
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

    $(document).on('click','.update',function(e){
        e.preventDefault();
        var files = ($('.edit_logo')[0].files);
        files[0] = files[0]==''?null:files[0];
        let data = new FormData();
        data.append('logo',files[0]);
        data.append('id',$('.id').val());
        data.append('nama',$('.edit_nama').val());
        data.append('deskripsi',$('.edit_deskripsi').val());
        console.log(data);
        _input.loading.start(this);
        _ajax.postWithFile("{{ route('master-data.bank.update') }}",data,
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
        )
    });

    $(document).on('click','.delete', function(e) {
        e.preventDefault()
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
                _ajax.get(`{{ url('/auth/dashboard/master-bank/delete') }}/${id}`,
                    (response) => {
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
                    (response) => {
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

    $('#datatable_paginate').parent().addClass('mt-3');
</script>
@endpush
