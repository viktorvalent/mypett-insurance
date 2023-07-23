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
                        <th>Nomor Polis</th>
                        <th>Member</th>
                        <th>Tanggal Mulai</th>
                        <th>Jangka Waktu</th>
                        <th>Status</th>
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
    _table.set("{{ route('polis.data') }}",
        [
            {data: 'nomor_polis', name: 'nomor_polis'},
            {data: 'pembelian_id.member.nama_lengkap', name: 'pembelian_id.member.nama_lengkap'},
            {data: 'tgl_polis_mulai', name: 'tgl_polis_mulai'},
            {data: 'jangka_waktu', name: 'jangka_waktu'},
            {data: 'status_polis', name: 'status_polis'},
        ]
    );
</script>
@endpush
