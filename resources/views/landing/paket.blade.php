@extends('layouts.landing.app')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="rounded my-3">
        <img src="{{ asset('img/paket-bg.jpg') }}" class="w-100 h-100 rounded" alt="">
    </div>
    <div class="card bg-light my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Mypett Insurance.</h5>
                    <p class="text-danger">Perlindungan untuk hewan peliharaan kesayangan anda.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('home.faqs') }}" class="btn btn-warning fw-bold">FAQs</a>
                    @guest
                        <a href="{{ route('sign-in.member') }}" class="btn btn-success fw-bold" >BELI SEKARANG</a>
                    @endguest

                    @can('is_member')
                        <a href="{{ route('pembelian.produk') }}" class="btn btn-success fw-bold" >BELI SEKARANG</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="my-3 fw-bold fs-6">Pilihan Paket Jaminan Mypett Insurance :</div>
        <p>Simas Pet Insurance memiliki {{ $pakets->count() }} paket jaminan yang dapat Anda pilih sesuai dengan kebutuhan :</p>
    </div>
    @foreach ($pakets as $paket)
        <div class="mb-4">
            <div class="my-3 fw-bold fs-6">{{ $paket->nama_produk }} - Nilai Pertanggungan: {{ number_format($paket->produk_benefit->nilai_pertanggungan_min,0,"",".") }} sd {{ number_format($paket->produk_benefit->nilai_pertanggungan_max,0,"",".") }},-</div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 50%;">Jaminan</th>
                                <th style="width: 50%;">Uang Pertanggungan</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: .85rem;" class="align-middle">
                            <tr>
                                <td class="fw-bold">A. Kecelakaan Diri</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Manfaat kematian akibat kecelakaan</td>
                                <td class="text-end">Sesuai dengan Nilai Pertanggungan atau maksimal Rp. {{ number_format($paket->produk_benefit->santunan_mati_kecelakaan_max,0,"",".") }},-</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">B. Pencurian</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Manfaat kehilangan akibat pencurian disertai dengan kekerasan</td>
                                <td class="text-end">Maksimum {{ $paket->produk_benefit->santunan_pencurian_max }}% dari Nilai Pertanggungan Jaminan A (Kecelakaan Diri)</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">C. Tanggung jawab hukum terhadap pihak ketiga </td>
                                <td class="text-end">Maksimum Rp {{ number_format($paket->produk_benefit->hukum_pihak_ketiga_max,0,"",".") }},- </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">JAMINAN TAMBAHAN</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Santunan Kremasi</td>
                                <td class="text-end">Maksimum Rp. {{ number_format($paket->produk_benefit->santunan_kremasi_max,0,"",".") }},-</td>
                            </tr>
                            <tr>
                                <td>Santunan Rawat Inap</td>
                                <td class="text-end">Maksimum Rp. {{ number_format($paket->produk_benefit->santunan_rawat_inap_max,0,"",".") }},- per tahun</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('js')

@endpush
