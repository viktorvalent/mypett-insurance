@extends('layouts.landing.app')

@push('css')

@endpush

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb py-3 bg-light">
        <div class="container d-flex">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Term & Conditions</li>
        </div>
    </ol>
</nav>
<div class="container">
    <div class="car">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    {!! $data->isi !!}
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
