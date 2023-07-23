@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
@endpush

@section('container')
<div class="row">
    <div class="card">
            <div class="row">
                <div class="col-md-2 col-sm-0"></div>
                <div class="col-md-8 col-sm-12">
                        <div class="card-body" style="opacity: 0.955 !important;">
                            <h5 class="text-center border-bottom pb-3 mb-3">Member Profile</h5>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between  px-2">
                                        <div class="fw-bold">
                                            Nama
                                        </div>
                                        <div class="">
                                            {{ $data->nama_lengkap }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between px-2">
                                        <div class="fw-bold">
                                            No. KTP (NIK)
                                        </div>
                                        <div class="">
                                            {{ $data->no_ktp }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between px-2">
                                        <div class="fw-bold">
                                            Nomor HP
                                        </div>
                                        <div class="">
                                            {{ $data->no_hp }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between px-2">
                                        <div class="fw-bold">
                                            Alamat
                                        </div>
                                        <div class="">
                                            {{ $data->alamat }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between px-2">
                                        <div class="fw-bold">
                                            Bank
                                        </div>
                                        <div class="">
                                            {{ $data->master_bank->nama }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between px-2">
                                        <div class="fw-bold">
                                            Nomor Rekening
                                        </div>
                                        <div class="">
                                            {{ $data->no_rekening }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-md-2 col-sm-0"></div>
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
@endpush
