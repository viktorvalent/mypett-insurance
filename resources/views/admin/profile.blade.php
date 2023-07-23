@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
@endpush

@section('container')
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Profile Details</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ asset('img/avatar.png') }}" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128">
                <h5 class="card-title mb-1">{{ auth()->user()->username }}</h5>
                <div class="text-muted mb-2">{{ auth()->user()->email }}</div>
                <div>
                    <a class="btn btn-primary btn-sm mt-2" href="#" data-bs-toggle="modal" data-bs-target="#modal_reset">Reset Password</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-9">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Admin Activity</h5>
            </div>
            <div class="card-body h-100">
                <table id="datatable" class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Menu</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_reset" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-2">
                    <form id="create">
                        <div class="mb-2">
                            <label class="form-label required">Password Baru <i class="text-danger">*</i></label>
                            <input type="hidden" name="id" class="id" value="{{ auth()->user()->id }}">
                            <input id="new_pass" type="password" name="new_pass" class="form-control" placeholder="******">
                            <small class="text-danger new_pass_error"></small>
                        </div>
                        <div class="mb-2">
                            <label class="form-label required">Konfirmasi Password Baru <i class="text-danger">*</i></label>
                            <input id="confirm_new_pass" type="password" name="confirm_new_pass" class="form-control" placeholder="******">
                            <small class="text-danger confirm_new_pass_error"></small>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-default ms-2 reset">Kirim</button>
                        </div>
                    </form>
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
    $(document).ready(function () {
        _table.set("{{ route('admin.logs') }}",
            [
                {data: 'tanggal', name: 'tanggal'},
                {data: 'menu', name: 'menu'},
                {data: 'description', name: 'description'},
            ]
        );

        $(document).on('click','.reset',function(e){
            e.preventDefault();
            let data = {
                'id':$('.id').val(),
                'new_pass':$('#new_pass').val(),
                'confirm_new_pass':$('#confirm_new_pass').val(),
            }
            _input.loading.start(this);
            _ajax.post(`{{ route('reset.pass.admin') }}`,data,
            (response)=>{
                    _input.loading.stop('.reset','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                (response)=>{
                    _input.loading.stop('.reset','Kirim');
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
    });
</script>
@endpush
