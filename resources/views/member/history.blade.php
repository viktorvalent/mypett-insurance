@extends('layouts.landing.app')

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container my-3">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card shadow my-3">
                <div class="card-body">
                    <h5 class="text-center">Member Activity Log</h5>
                    <table id="datatable" class="table table-bordered table-hover w-100 table-striped" style="font-size: .9rem">
                        <thead class="bg-light">
                            <tr class="text-center align-middle">
                                <th>Tanggal</th>
                                <th>Menu</th>
                                <th>Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr class="text-center align-middle" style="height: 5rem">
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $log->created_at)->format('d/m/Y') }}</td>
                                <td>{{ $log->menu }}</td>
                                <td>
                                    {{ $log->description }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#datatable').DataTable({
            scrollX: true
        });
    });
</script>
@endpush
