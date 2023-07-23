@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table w-100">
                <thead>
                    <tr>
                        <th style="width: 90%">Term & Conditions</th>
                        <th style="width: 10%">Action</th>
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
        _table.set("{{ route('tnc.data') }}",
            [
                {data: 'isi', name: 'isi'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
            ]
        );

        $(document).on('click','.edit', function(e) {
            e.preventDefault()
            let id = $(this).data('id');
            window.location.href="{{ url('/auth/dashboard/tnc/edit') }}/"+id;
        });
    });
</script>
@endpush
