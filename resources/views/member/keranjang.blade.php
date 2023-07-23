@extends('member.dashboard')

@push('member_css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<style>
    .dataTables_scroll {
        padding: 1rem 0;
    }
</style>
@endpush

@section('member')
<div class="row">
    <div class="col-md-1 col-sm-0"></div>
    <div class="col-md-10 col-sm-12">
        <div class="card shadow" style="opacity: .955 !important;">
            <div class="card-body">
                <h5 class="text-center border-bottom pb-3 mb-3">Keranjang Pembelian Asuransi</a></h5>
                @if ($member!=null && !$member->pembelian_produk()->exists())
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Pemberitahuan!</strong> Anda belum melakukan pembelian asuransi.
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('home.package') }}" class="btn btn-primary btn-sm"><i class="bi bi-cart3 fs-5"></i> Paket Asuransi</a>
                    </div>
                @else
                <table id="datatable" class="table table-bordered table-hover w-100" style="font-size: .9rem">
                    <thead class="bg-light">
                        <tr class="text-center align-middle">
                            <th>No.</th>
                            <th>Paket Asuransi</th>
                            <th>Nama Hewan (Ras)</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($no=1)
                        @foreach ($pembelians as $item)
                        <tr class="text-center align-middle" style="height: 5rem">
                            <td class="fw-bold">{{ $no }}</td>
                            <td>{{ $item->produk->nama_produk }}</td>
                            <td>{{ $item->nama_hewan }} ({{ $item->ras_hewan->jenis_hewan->nama }} - {{ $item->ras_hewan->nama_ras }})</td>
                            <td class="text-danger fw-bold">Rp {{ number_format(($item->harga_dasar_premi+$item->biaya_pendaftaran),0,'','.') }}</td>
                            <td>
                                <span class="badge text-bg-secondary shadow-sm">UNPAID</span>
                            </td>
                            <td>
                                <a href="{{ URL::route('pembelian.bayar.cart', ['id'=>$item->id]) }}" class="btn btn-sm btn-success" style="font-size: .825rem;"><i class="bi bi-cash"></i>&nbsp;&nbsp;BAYAR</a>
                            </td>
                        </tr>
                        @php($no++)
                        @endforeach
                    </tbody>
                </table>

                @endif
            </div>
        </div>
    </div>
    <div class="col-md-1 col-sm-0"></div>
</div>
@endsection

@push('member_js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            scrollX: true
        });
    });
</script>
@endpush
