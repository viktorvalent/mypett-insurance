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
                        <th>Bank</th>
                        <th>Nomor Rekening</th>
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
                                <label class="form-label required">Bank <i class="text-danger">*</i></label>
                                <select class="form-control form-control-sm choice bank" name="bank_id" id="bank_id">
                                    <option value="">Pilih Bank</option>
                                    @foreach ($datas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger bank_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nomor Rekening <i class="text-danger">*</i></label>
                                <input id="nomor_rekening" type="text" name="nomor_rekening" class="form-control" placeholder="Masukkan nomor rekening">
                                <small class="text-danger nomor_rekening_error"></small>
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
                                <label class="form-label required">Bank <i class="text-danger">*</i></label>
                                <input type="hidden" name="edit_id" class="edit_id">
                                <div class="select_edit">
                                    <select class="form-control form-control-sm choice_edit bank" name="bank_id" id="bank_id">
                                        <option value="">Pilih Bank</option>
                                    </select>
                                </div>
                                <small class="text-danger bank_error"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nomor Rekening <i class="text-danger">*</i></label>
                                <input id="nomor_rekening" type="text" name="edit_nomor_rekening" class="form-control edit_nomor_rekening" placeholder="Masukkan nomor rekening">
                                <small class="text-danger nomor_rekening_error"></small>
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
        _table.set("{{ route('no-rek.data') }}",
            [
                {data: 'master_bank.nama', name: 'master_bank.nama'},
                {data: 'nomor_rekening', name: 'nomor_rekening'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        );
        // Choice init
        const choices = new Choices('.choice');
        const choices_edit = new Choices('.choice_edit');
        $('.choices').addClass('mb-0');
        _form.reset('.add','#create');

        $(document).on('click','.create',function (e) {
            e.preventDefault();
            let data = {
                'bank':$('#bank_id option:selected').val(),
                'nomor_rekening':$('#nomor_rekening').val()
            }
            _input.loading.start(this);
            _ajax.post("{{ route('master-data.no-rek.create') }}",data,
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
            _ajax.get(`{{ url('/auth/dashboard/master-nomor-rekening/edit') }}/${id}`,
                (response) => {
                    $('#modal_edit').modal('show');
                    if (response.status == 200) {
                        $('.edit_nomor_rekening').val(response.data.nomor_rekening);
                        $('.edit_id').val(response.data.id);
                        let options = [];
                        response.banks.forEach(e => {
                            response.data.bank_id==e.id?options.push(`<option value="${e.id}" selected>${e.nama}</option>`):options.push(`<option value="${e.id}">${e.nama}</option>`);
                        });
                        $('.select_edit').html(`<select class="form-control form-control-sm choice_edit edit_bank_id bank" name="edit_bank_id" id="bank_id">${options.join('')}</select>`);
                        new Choices('.choice_edit');
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
                'bank':$('.edit_bank_id').val(),
                'nomor_rekening':$('.edit_nomor_rekening').val()
            }
            _input.loading.start(this);
            _ajax.put(`{{ url('/auth/dashboard/master-nomor-rekening/update') }}/${data.id}`,data,
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
                    _ajax.get(`{{ url('/auth/dashboard/master-nomor-rekening/delete') }}/${id}`,
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
