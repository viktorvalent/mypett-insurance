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
            <div class="row">
                <div class="col-md-8">
                    <p>Visi:</p>

<p>Menjadi pengusaha sukses yang perusahaannya dikenal di nasional sampai mancanegara.</p>

<p>Misi:</p>

<p>Mencari relasi dengan investor agar perusahaan tambah berkembang. Memprioritaskan kualitas untuk meningkatkan penjualan. Melakukan strategi marketing yang baik. Menetapkan kebijakan perusahaan yang baik dan selalu mengkaji ulang untuk membuat regulasi yang semakin sempurna untuk kemajuan perusahaan.</p>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
