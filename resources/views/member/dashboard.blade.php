@extends('layouts.landing.app')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />
@stack('member_css')
<style>
    #member-dashboard {
        background: url('/img/PetInsurance.jpg');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
    }
</style>
@endpush

@section('content')
<section id="member-dashboard">
    <div class="container">
        @yield('member')
    </div>
</section>
@endsection

@push('js')
@stack('member_js')
@endpush

