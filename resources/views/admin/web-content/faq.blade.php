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
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
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
                                <label class="form-label required">Pertanyaan <i class="text-danger">*</i></label>
                                <textarea id="pertanyaan" class="form-control pertanyaan" name="pertanyaan" placeholder="Pertanyaan" rows="3"></textarea>
                                <small class="text-danger pertanyaan_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jawaban</label>
                                <textarea id="jawaban" class="form-control jawaban" name="jawaban" placeholder="Jawaban" rows="5"></textarea>
                                <small class="text-danger jawaban_error"></small>
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
                                <label class="form-label required">Pertanyaan <i class="text-danger">*</i></label>
                                <input type="hidden" name="id" class="edit_id">
                                <textarea id="pertanyaan" class="form-control edit_pertanyaan" name="edit_pertanyaan" placeholder="Pertanyaan" rows="3"></textarea>
                                <small class="text-danger pertanyaan_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jawaban</label>
                                <textarea id="jawaban" class="form-control edit_jawaban" name="edit_jawaban" placeholder="Jawaban" rows="5"></textarea>
                                <small class="text-danger jawaban_error"></small>
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
        _table.set("{{ route('faq.data') }}",
            [
                {data: 'pertanyaan', name: 'pertanyaan'},
                {data: 'jawaban', name: 'jawaban'},
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
            let data = {
                'pertanyaan':$('#pertanyaan').val(),
                'jawaban':$('#jawaban').val()
            }
            _input.loading.start(this);
            _ajax.post("{{ route('web-content.faq.create') }}",data,
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
            _ajax.get(`{{ url('/auth/dashboard/faq/edit') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        $('.edit_pertanyaan').val(response.data.pertanyaan);
                        $('.edit_id').val(response.data.id);
                        $('.edit_jawaban').val(response.data.jawaban).html().replace(/\n/g, "<br />");
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
                'pertanyaan':$('.edit_pertanyaan').val(),
                'jawaban':$('.edit_jawaban').val()
            }
            console.log(data);
            _input.loading.start(this);
            _ajax.put(`{{ url('/auth/dashboard/faq/update') }}/${data.id}`,data,
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
                    _ajax.get(`{{ url('/auth/dashboard/faq/delete') }}/${id}`,
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
