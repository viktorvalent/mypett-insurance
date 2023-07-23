@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h4 class="mb-3 fw-bold text-center">Preview Polis dengan Nomor : {{ $data->nomor_polis }}</h4>
                    <embed type="application/pdf" src="{{ asset(Storage::url($data->path)) }}" class="w-100" style="height: 568px;"></embed>
                    <a href="{{ route('polis') }}" class="btn btn-secondary my-2 text-center">Kembali</a>
                </div>
                <div class="col-md-2"></div>
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
</script>
@endpush
