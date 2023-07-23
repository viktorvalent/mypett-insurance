@extends('layouts.landing.app')

@push('css')

@endpush

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb py-3 bg-light">
        <div class="container d-flex">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </div>
    </ol>
</nav>
<div class="container">
    <div class="car">
        <div class="card-body">
            <div class="row my-4">
                <div class="col-md-8">
                    <h4>Contact Us</h4>
                    <p>
                        A108 Adam Street <br>
                        New York, NY 535022<br>
                        United States <br><br>
                    </p>
                    <strong><i class="bi bi-telephone"></i> :</strong><a href="tel:+155895548855">  +1 5589 55488 55</a> <br>
                    <strong><i class="bi bi-envelope"></i> :</strong><a href="mailto:mypett@gmail.com">  mypett@gmail.com</a> <br>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
