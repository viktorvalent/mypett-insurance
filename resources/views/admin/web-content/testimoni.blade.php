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
            <table id="datatable" class="table w-100">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Pekerjaan</th>
                        <th>Teks</th>
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
                                <label class="form-label w-100">Foto <i class="text-danger">*</i></label>
                                <input id="foto" name="foto" class="form-control" type="file">
                                <small class="text-danger foto_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nama <i class="text-danger">*</i></label>
                                <input id="nama" type="text" name="nama" class="form-control nama" placeholder="Nama">
                                <small class="text-danger nama_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Pekerjaan <i class="text-danger">*</i></label>
                                <input id="pekerjaan" type="text" name="pekerjaan" class="form-control pekerjaan" placeholder="Pekerjaan">
                                <small class="text-danger pekerjaan_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Testimoni Teks <i class="text-danger">*</i></label>
                                <textarea id="testi_text" class="form-control testi_text" name="testi_text" placeholder="Testimoni Text" rows="5"></textarea>
                                <small class="text-danger testi_text_error"></small>
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
                                <label class="form-label w-100">Foto </label>
                                <input id="foto" name="edit_foto" class="form-control edit_foto" type="file">
                                <small class="text-danger foto_error"></small>
                                <div class="old_foto"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nama <i class="text-danger">*</i></label>
                                <input type="hidden" name="id" class="edit_id">
                                <input id="nama" type="text" name="edit_nama" class="form-control edit_nama" placeholder="Nama">
                                <small class="text-danger nama_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Pekerjaan <i class="text-danger">*</i></label>
                                <input id="pekerjaan" type="text" name="edit_pekerjaan" class="form-control edit_pekerjaan" placeholder="Pekerjaan">
                                <small class="text-danger pekerjaan_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Testimoni Teks <i class="text-danger">*</i></label>
                                <textarea id="testi_text" class="form-control edit_testi_text" name="edit_testi_text" placeholder="Testimoni Text" rows="5"></textarea>
                                <small class="text-danger testi_text_error"></small>
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
        _table.set("{{ route('testimoni.data') }}",
            [
                {data: 'foto', name: 'foto'},
                {data: 'nama', name: 'nama'},
                {data: 'pekerjaan', name: 'pekerjaan'},
                {data: 'testi_text', name: 'testi_text'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        );

        _form.reset('.add','#create');

        $(document).on('click','.create',function (e) {
            e.preventDefault();
            var foto = $('#foto')[0].files;
            let data = new FormData();
            data.append('foto',foto[0]);
            data.append('nama',$('#nama').val());
            data.append('pekerjaan',$('#pekerjaan').val());
            data.append('testi_text',$('#testi_text').val());
            _input.loading.start(this);
            _ajax.postWithFile("{{ route('web-content.testimoni.create') }}",data,
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
            $('#modal_edit').modal('show');
            _ajax.get(`{{ url('/auth/dashboard/testimoni/edit') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        $('.edit_nama').val(response.data.nama);
                        $('.edit_id').val(response.data.id);
                        $('.edit_pekerjaan').val(response.data.pekerjaan);
                        $('.edit_testi_text').val(response.data.testi_text);
                        $('.old_foto').html(`<img id="old-foto" src="${response.data.foto}" width="100" class="mt-3" alt="Foto">`)
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
            var foto = $('.edit_foto')[0].files;
            let data = new FormData();
            data.append('foto',foto[0]);
            data.append('nama',$('.edit_nama').val());
            data.append('id',$('.edit_id').val());
            data.append('pekerjaan',$('.edit_pekerjaan').val());
            data.append('testi_text',$('.edit_testi_text').val());
            _input.loading.start(this);
            _ajax.postWithFile(`{{ url('/auth/dashboard/testimoni/update') }}`,data,
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
                    _ajax.get(`{{ url('/auth/dashboard/testimoni/delete') }}/${id}`,
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
