@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table w-100 table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Member</th>
                        <th>Hewan</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script>
    _table.set("{{ route('pembelian.data') }}",
        [
            {data: 'tgl_daftar_asuransi', name: 'tgl_daftar_asuransi'},
            {data: 'produk_id.produk.nama_produk', name: 'produk_id.produk'},
            {data: 'member_id.member.nama_lengkap', name: 'member_id.member.nama_lengkap'},
            {data: 'ras_hewan_id.ras_hewan.nama_ras', name: 'ras_hewan_id.ras_hewan.nama_ras'},
            {data: 'status.status_pembelian.nama', name: 'status.status_pembelian.nama'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
            },
        ]
    );
</script>
@endpush
