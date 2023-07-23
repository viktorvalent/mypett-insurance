@extends('member.dashboard')

@push('member_css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<style>
    iframe {
        width: 100%;
        height: 18rem;
    }
</style>
@endpush

@section('member')
<div class="row">
    <div class="col-md-1 col-sm-0"></div>
    <div class="col-md-10 col-sm-12">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <h5 class="text-center">Pet Shop Terdekat sekitar {{ $member->kab_kota->nama }}</h5>
        </div>
        <div class="row">
            @forelse ($petshops as $petshop)
            <div class="col-md-6">
                <div class="card shadow" style="width: 100%;">
                    {!! $petshop->gmaps_iframe !!}
                    <div class="card-body p-4">
                        <h5 class="card-title my-2">{{ $petshop->nama_petshop }}</h5>
                        <p class="card-text" style="font-size: .875rem">{{ $petshop->alamat }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center mt-3">
                <p class="bg-light d-inline p-3 rounded fst-italic">
                    Petshop terdekat belum tersedia.
                </p>
            </div>
            @endforelse
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $petshops->links() }}
        </div>
    </div>
    <div class="col-md-1 col-sm-0"></div>
</div>
@endsection

@push('member_js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script>
    $(document).ready(function () {
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
