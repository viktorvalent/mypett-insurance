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
                        <th>Tanggal Klaim</th>
                        <th>Member</th>
                        <th>Nomor Polis</th>
                        <th>Total Nominal Klaim</th>
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
    _table.set("{{ route('klaim.data') }}",
        [
            {data: 'tgl_klaim', name: 'tgl_klaim'},
            {data: 'member_id.member.nama_lengkap', name: 'member_id.member.nama_lengkap'},
            {data: 'polis_id.polis.nomor_polis', name: 'polis_id.polis.nomor_polis'},
            {data: 'total_klaim', name: 'total_klaim'},
            {data: 'status_klaim.status_set.status', name: 'status_klaim.status_set.status'},
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
