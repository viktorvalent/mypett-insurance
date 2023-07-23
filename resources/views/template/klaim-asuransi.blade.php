@extends('template.letter')
@push('template_css')
<style>
    * {
        font-family: 'Times New Roman', Times, serif;
        font-size: 15px;
    }
    .letter {
        padding: 0cm 1cm;
        padding-top: 2.25cm;
    }
    td {
        font-size: 14px;
    }
    tr td:first-child {
        text-align: left;
        width: 350px;
    }
    .title {
        font-size: 19px;
        margin-top: 2cm;
        text-decoration: underline;
        text-decoration-thickness: 20%;
    }
    .uppattern {
        margin: 0;
        padding: 0;
    }
    div.logo img {
        margin-top: 2cm;
    }
    img.pattern-top {
        pointer-events: none;
        position: absolute;
        top: 0;
        left: 0;
        margin: -1.25cm;
        padding: -1.25cm;
        margin-top: -1.25cm;
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
        margin: -1.18cm;
        padding: -1.15cm;
        margin-bottom: -1.25cm;
        width: 100vw;
        z-index: -10;
    }
</style>
@endpush
@section('template_body')
<div class="uppattern">
    <img class="pattern-top" src="{{ asset('img/pattern/up.png') }}" />
</div>
<div class="letter">
    <div class="position-absolute left-0 top-0 logo"><img src="{{ asset('img/polis/logo.png') }}" style="width: 85px;" alt=""></div>
    <div class="text-center title fw-bold text-underline">Surat Pengajuan Klaim Asuransi Hewan MYPETT</div>
    <div class="mt-5">Kepada YTH,</div>
    <div class="">{{ $data->member->nama_lengkap }}</div>

    <div class="mt-2">Nomor Polis : {{ $data->polis->nomor_polis }}</div>
    <div class="mt-2">Tanggal Klaim : {{ \Carbon\Carbon::createFromFormat('Y-m-d',$data->tgl_klaim)->format('d-m-Y') }}</div>
    <div class="mt-2 text-capitalized">Keterangan : {{ $data->keterangan_klaim }}</div>

    <div class="mt-4 text-justify">Terima kasih atas kepercayaan Bapak/Ibu yang telah menggunakan Jasa Asuransi MYPETT sebagai mitra perlindungan asuransi hewan Bapak/Ibu. </div>
    <div class="mt-4 text-justify">Pengajuan permohonan klaim sesuai dengan perihal Permohonan asuransi hewan Bapak/Ibu kami terima dengan jumlah sebesar Rp.{{ $data->nominal_disetujui!=null?number_format($data->nominal_disetujui,0,'','.'):number_format(($data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter),0,'','.') }} dengan perincian sebagai berikut : </div>

    <div>
        <table class="mt-4">
            <tr>
                <td>Mata Uang Polis</td>
                <td class="text-end">Rupiah</td>
            </tr>
            @if ($data->konfirmasi_klaim_asuransi()->exists())
            <tr>
                <td>Biaya Dokter</td>
                <td class="text-end">Rp {{ number_format($data->konfirmasi_klaim_asuransi->nominal_bayar_dokter,0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Obat</td>
                <td class="text-end">Rp {{ number_format($data->konfirmasi_klaim_asuransi->nominal_bayar_obat,0,'','.') }}</td>
            </tr>
            <tr class="border-bottom pb-2 border-dark border-black">
                <td>Biaya Rumah Sakit</td>
                <td class="text-end">Rp {{ number_format($data->konfirmasi_klaim_asuransi->nominal_bayar_rs,0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Yang Dibayarkan</td>
                <td class="text-end">Rp {{ number_format($data->nominal_disetujui,0,'','.') }}</td>
            </tr>
            @elseif ($data->limit_confirmation_klaim()->exists())
            <tr>
                <td>Biaya Dokter</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_dokter),0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Obat</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_obat),0,'','.') }}</td>
            </tr>
            <tr class="border-bottom pb-2 border-dark border-black">
                <td>Biaya Rumah Sakit</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_rs),0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Yang Dibayarkan</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_disetujui),0,'','.') }} (Sesuai sisa limit)</td>
            </tr>
            @else
            <tr>
                <td>Biaya Dokter</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_dokter),0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Obat</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_obat),0,'','.') }}</td>
            </tr>
            <tr class="border-bottom pb-2 border-dark border-black">
                <td>Biaya Rumah Sakit</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_rs),0,'','.') }}</td>
            </tr>
            <tr>
                <td>Biaya Yang Dibayarkan</td>
                <td class="text-end">Rp {{ number_format(($data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter),0,'','.') }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="mt-4 text-justify">Dengan surat pengajuan klaim tersebut,maka permohonan klaim akan dipotong oleh limit yang tersedia sesuai dengan pertanggungan yang diperoleh.</div>
    <div class="col-12 pt-3">
        <div class="text-center position-absolute end-0 me-5">
            <div class="">Jakarta, {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('D MMMM YYYY') }}</div>
            <div class="mb-1">MY PETT</div>
            <img src="{{ asset('img/ttd/mypet-qr-code.svg') }}" width="70" alt="">
        </div>
    </div>
</div>
<div class="bottompattern">
    <img src="{{ asset('img/pattern/bottom.png') }}" class="pattern-bottom">
</div>
@endsection
