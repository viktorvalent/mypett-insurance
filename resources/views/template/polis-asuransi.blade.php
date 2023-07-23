@extends('template.letter')
@push('template_css')
<style>
    * {
        font-family: 'Arial','Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', sans-serif';
    }
    body {
        height: 100%;
        width: 100%;
    }
    body .bg {
        background-image: url('img/pattern/polis.png');
        height: 100%;
        width: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    body .letter {
        padding: 0cm 1cm;
        padding-top: 1.55cm;
    }
    td {
        font-size: 14px;
    }
    tr td:first-child {
        text-align: left;
        width: 225px;
    };
    tr td:last-child {
        padding-left: 20px !important;
    };

    .uppattern {
        margin: 0;
        padding: 0;
    }
    img.pattern-top {
        pointer-events: none;
        position: absolute;
        top: 0;
        left: 0;
        margin: -1.25cm;
        margin-top: -2.75cm;
        width: 100vw;
        z-index: -9;
    }
    .bottompattern {
        margin: 0;
        padding: 0;
    }
    img.pattern-bottom {
        pointer-events: none;
        position: absolute;
        bottom: 0;
        left: 0;
        margin: -1.2cm;
        margin-bottom: -2.75cm;
        margin-left: -1.95cm;
        width: 100vw;
        z-index: -10;
    }
</style>
@endpush
@section('template_body')
<div class="uppattern">
    <img class="pattern-top" src="{{ asset('img/pattern/polisup.png') }}" />
</div>
<div class="letter">
    <table class="mb-4">
        <tr>
            <th>
                <img src="{{ asset('img/polis/logo.png') }}" style="width: 85px;" alt="">
            </th>
            <th class="text-center fw-bold ps-3" style="font-size: 40px;">
                Pet Insurance
            </th>
        </tr>
    </table>
    <table style="max-height: fit-content">
        <tr class="align-top">
            <td>Nomor Polis</td>
            <td>:</td>
            <td>&nbsp;{{ $data->polis->nomor_polis }}</td>
        </tr>
        <tr class="align-top">
            <td>Nama Pemilik</td>
            <td>:</td>
            <td>&nbsp;{{ $data->nama_pemilik }}</td>
        </tr>
        <tr class="align-top">
            <td>ID Member</td>
            <td>:</td>
            <td>&nbsp;{{ $data->member->no_ktp }}</td>
        </tr>
        <tr class="align-top">
            <td>Jenis Hewan (Ras)</td>
            <td>:</td>
            <td>&nbsp;{{ $data->ras_hewan->jenis_hewan->nama }} ({{ $data->ras_hewan->nama_ras }})</td>
        </tr>
        <tr class="align-top">
            <td>Nama Hewan yang diasuransikan</td>
            <td>:</td>
            <td>&nbsp;{{ $data->nama_hewan }}</td>
        </tr>
        <tr class="align-top">
            <td>Tanggal Lahir Hewan</td>
            <td>:</td>
            <td>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d',$data->tgl_lahir_hewan)->format('d/m/Y') }}</td>
        </tr>
        <tr class="align-top">
            <td>Umur Hewan</td>
            <td>:</td>
            <td>&nbsp;{{ \Carbon\Carbon::parse($data->tgl_lahir_hewan)->age }} Tahun</td>
        </tr>
        <tr class="align-top" style="max-height: fit-content;">
            <td>Foto Hewan</td>
            <td>:</td>
            <td>
                <div class="ms-1 mt-1" style="width: 135px;height:90px;">
                    <img src="{{ asset(Storage::url($data->foto)) }}" class="rounded w-100 h-100"  alt="" style="object-fit: cover;object-position: center;">
                </div>
            </td>
        </tr>
    </table>

    <div class="pt-3">
        <div class="mb-2 fw-bold" style="font-size: 14px;">Dengan ketentuan sebagai berikut;</div>
        <table>
            <tbody>
                <tr class="align-top">
                    <td>Jenis Produk Asuransi</td>
                    <td>:</td>
                    <td>&nbsp;{{ $data->produk->nama_produk }}</td>
                </tr>
                <tr class="align-top">
                    <td>Tanggal Pendaftaran</td>
                    <td>:</td>
                    <td>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d',$data->tgl_daftar_asuransi)->format('d/m/Y') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Tanggal Polis dibuat</td>
                    <td>:</td>
                    <td>&nbsp;{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Tanggal Mulai Polis</td>
                    <td>:</td>
                    <td>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d',$data->polis->tgl_polis_mulai)->format('d/m/Y') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Jangka Waktu</td>
                    <td>:</td>
                    <td>&nbsp;{{ $data->polis->jangka_waktu }} Tahun</td>
                </tr>
                <tr class="align-top">
                    <td>Status Polis</td>
                    <td>:</td>
                    <td>&nbsp;{{ $data->polis->status_polis }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pt-3">
        <div class="mb-2 fw-bold" style="font-size: 14px;">PREMI</div>
        <table>
            <tbody>
                <tr class="align-top">
                    <td>Produk Pertanggungan</td>
                    <td>:</td>
                    <td>&nbsp;Rp {{ number_format($data->produk->produk_benefit->nilai_pertanggungan_min,0,'','.') }} s/d Rp {{ number_format($data->produk->produk_benefit->nilai_pertanggungan_max,0,'','.') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Rate</td>
                    <td>:</td>
                    <td>&nbsp;{{ $data->ras_hewan->persen_per_umur }} % / Tahun</td>
                </tr>
                <tr class="align-top">
                    <td>Premi</td>
                    <td>:</td>
                    <td>&nbsp;Rp {{ number_format($data->harga_dasar_premi,0,'','.') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Fee Admin</td>
                    <td>:</td>
                    <td>&nbsp;Rp {{ number_format($data->biaya_pendaftaran,0,'','.') }}</td>
                </tr>
                <tr class="align-top">
                    <td>Total Premi</td>
                    <td>:</td>
                    <td>&nbsp;Rp {{ number_format(($data->harga_dasar_premi+$data->biaya_pendaftaran),0,'','.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-12 pt-3">
        <div class="text-center position-absolute end-0 me-5">
            <div class="">Jakarta, {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM YYYY') }}</div>
            <div class="mb-1">MY PETT</div>
            <img src="{{ asset('img/ttd/mypet-qr-code.svg') }}" width="65" alt="">
        </div>
    </div>
</div>
<div class="bottompattern">
    <img src="{{ asset('img/pattern/polisbottom.png') }}" class="pattern-bottom">
</div>
@endsection
