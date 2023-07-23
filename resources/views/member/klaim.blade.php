@extends('member.dashboard')

@push('member_css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
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
                <h5 class="text-center border-bottom pb-3 mb-3">Daftar Asuransi Anda</a></h5>
                @if (count($member->klaims)<1)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Pemberitahuan!</strong> Anda belum mempunyai klaim.
                    </div>
                    @php($c=0)
                    @foreach ($pembelians as $item)
                        @if ($item->polis)
                            @php($c=1)
                        @endif
                    @endforeach
                    @if ($c==1)
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('member.claim.form') }}" class="btn btn-primary btn-sm"><i class="bi bi-file-earmark-lock fs-5"></i> Ajukan Klaim</a>
                        </div>
                    @else
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary btn-sm" disabled="disabled"><i class="bi bi-file-earmark-lock fs-5"></i> Ajukan Klaim</button>
                        </div>
                    @endif
                @else
                <div class="mb-3">
                    <a href="{{ route('member.claim.form') }}" class="btn btn-sm btn-primary btn-sm"><i class="bi bi-file-earmark-lock"></i> Ajukan Klaim</a>
                </div>
                    <table id="datatable" class="table table-bordered table-hover w-100" style="font-size: .9rem">
                        <thead class="bg-light">
                            <tr class="text-center align-middle">
                                <th>No.</th>
                                <th>Nomor Polis</th>
                                <th>Total Klaim</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=1)
                            @foreach ($klaims as $item)
                            <tr class="text-center align-middle" style="height: 3.75rem">
                                <td class="fw-bold">{{ $no }}</td>
                                <td>{{ $item->polis->nomor_polis }}</td>
                                <td class="{{ ($item->status_set->id==5?'text-danger':'') }}">
                                    @if ($item->nominal_disetujui!=null)
                                    Rp {{ number_format(($item->nominal_disetujui),0,'','.') }}
                                    @else
                                    Rp {{ number_format(($item->nominal_bayar_rs+$item->nominal_bayar_dokter+$item->nominal_bayar_obat),0,'','.') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_set->id==1)
                                        <span class="badge text-bg-light shadow-sm">{{ $item->status_set->status }}</span>
                                    @elseif ($item->status_set->id==2)
                                        <span class="badge text-bg-danger shadow-sm">{{ $item->status_set->status }}</span>
                                    @elseif ($item->status_set->id==3)
                                        <span class="badge text-bg-success shadow-sm">{{ $item->status_set->status }}</span>
                                    @elseif ($item->status_set->id==6)
                                        <span class="badge text-bg-info shadow-sm">{{ $item->status_set->status }}</span>
                                    @else
                                        <span class="badge text-bg-warning shadow-sm">{{ $item->status_set->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_set->id==1)
                                        <button class="btn btn-sm btn-secondary" style="font-size: .825rem;cursor:default;" data-bs-toggle="tooltip" data-bs-placement="top" title="Awaiting for Admin Confirmation"><i class="bi bi-clock-history"></i></button>
                                        <button class="btn btn-sm btn-secondary" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Nota" @disabled(true)><i class="bi bi-download"></i></button>
                                    @elseif ($item->status_set->id==2)
                                        <button data-id="{{ $item->id }}" class="btn btn-sm btn-secondary detail" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Alasan Penolakan"><i class="bi bi-search"></i></button>
                                        <a href="{{ URL::route('member.claim.revisi',['id'=>$item->id]) }}" class="btn btn-sm btn-warning" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Revisi Klaim"><i class="bi bi-pencil"></i></a>
                                    @elseif ($item->status_set->id==3)
                                        <button data-id="{{ $item->id }}" class="btn btn-sm btn-secondary detail" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Bukti Pembayaran Klaim"><i class="bi bi-search"></i></button>
                                        <a href="{{ URL::route('member.download.nota_klaim', ['id'=>$item->id]) }}" class="btn btn-sm btn-success" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Nota"><i class="bi bi-download"></i></a>
                                    @elseif ($item->status_set->id==5)
                                        <button data-id="{{ $item->id }}" class="btn btn-sm btn-danger limit_confirm" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Nominal Klaim"><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-sm btn-secondary" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Nota" @disabled(true)><i class="bi bi-download"></i></button>
                                    @elseif ($item->status_set->id==6)
                                        <button data-id="{{ $item->id }}" class="btn btn-sm btn-info partial_confirm" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Konfirmasi Pembagian Klaim"><i class="bi bi-question-circle"></i></button>
                                        <button class="btn btn-sm btn-secondary" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Unduh Nota" @disabled(true)><i class="bi bi-download"></i></button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" @disabled(true) style="font-size: .825rem;"><i class="bi bi-download"></i>&nbsp;&nbsp;Unduh Nota</button>
                                    @endif
                                </td>
                            </tr>
                            @php($no++)
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="modal fade" id="modal_accept" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col-12 detail_data">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $('#datatable').DataTable({
            scrollX: true
        });
        $(document).on('click','.detail', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            _ajax.get(`{{ url('/claim/cek-detail') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        $('#modal_accept').modal('show')
                        if (response.cek) {
                            $('.detail_data').html(`<div class="fs-6 mb-1">Keterangan :</div><div class="fst-italic text-success mb-2">"${response.data.terima_klaim_asuransi.keterangan_alasan}."</div><div class="fs-6 mb-1">Bukti Pembayaran Klaim : </div><img src="${response.data.terima_klaim_asuransi.bukti_bayar_klaim}" style="width:100%;" class="mt-3" alt="Logo" />`);
                        } else {
                            $('.detail_data').html(`<div class="fs-6 mb-2">Alasan klaim ditolak :</div><div class="fst-italic text-danger fw-bold">"${response.data.tolak_klaim_asuransi.alasan_menolak}."</div>`);
                        }
                    }
                }
            )
        });

        $(document).on('click','.limit_confirm', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            _ajax.get(`{{ url('/claim/confirm-detail') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        $('#modal_accept').modal('show')
                        console.log(response.data);
                        $('.detail_data').html(`<div class="fs-6 mb-1">Klaim tidak bisa dibayarkan secara penuh karena :</div><div class="fst-italic text-danger fw-bold">"${response.data.limit_confirmation_klaim.alasan}."</div><hr />
                        <div class="mt-3">Jumlah yang diajukan : <span class="text-secondary fw-bold">Rp ${_input.rupiah((response.data.limit_confirmation_klaim.nominal_pengajuan).toString())}</span></div><div class="mt-3">Sisa limit klaim sekarang : <span class="text-warning fw-bold">Rp ${_input.rupiah((response.data.limit_confirmation_klaim.nominal_limit).toString())}</span></div><input type="hidden" class="klaim_id" value="${response.data.id}">
                        <input type="hidden" class="agree_nominal_ditwarkan" value="${response.data.limit_confirmation_klaim.nominal_ditawarkan}"><div class="mt-3 ">Jumlah yang kami tawarkan : <span class="text-success fw-bold">Rp ${_input.rupiah((response.data.limit_confirmation_klaim.nominal_ditawarkan).toString())}</span></div><div class="mt-3 d-flex justify-content-center"><button class="btn btn-success btn-sm me-2 agree_limit"><i class="bi bi-check"></i> Setuju</button><a href="{{ URL::route('member.claim.revisi',['id'=>$item->id]) }}" class="btn btn-sm btn-warning" style="font-size: .825rem;" data-bs-toggle="tooltip" data-bs-placement="top" title="Revisi Klaim"><i class="bi bi-pencil"></i> Revisi</a></div>`);
                    }
                }
            )
        })

        $(document).on('click','.partial_confirm', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            _ajax.get(`{{ url('/claim/partial-confirm') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        $('#modal_accept').modal('show')
                        $('.detail_data').html(`<div class="fs-6 mb-2">Klaim tidak bisa dibayarkan secara penuh karena :</div><div class="fst-italic text-danger fw-bold">"${response.data.konfirmasi_klaim_asuransi.alasan}."</div><hr />
                        <div class="mt-3">Jumlah yang diajukan : <span class="text-secondary fw-bold">Rp ${_input.rupiah((response.data.nominal_bayar_rs+response.data.nominal_bayar_obat+response.data.nominal_bayar_dokter).toString())}</span></div>
                        <div class="mt-2 ">Jumlah yang kami tawarkan : <span class="text-success fw-bold">Rp ${_input.rupiah((response.data.konfirmasi_klaim_asuransi.nominal_ditawarkan).toString())}</span></div>
                        <input type="hidden" class="klaim_id" value="${response.data.id}">
                        <input type="hidden" class="agree_nominal" value="${response.data.konfirmasi_klaim_asuransi.nominal_ditawarkan}">
                        <div class="d-flex justify-content-center mt-4 mb-3"><button class="btn btn-success btn-sm me-2 agree_partial"><i class="bi bi-check"></i> Setuju</button><button class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x"></i> Batal</button></div>`);
                    }
                }
            )
        });

        $(document).on('click','.agree_partial',function(e){
            e.preventDefault();
            let data = {
                'klaim_id':$('.klaim_id').val(),
                'nominal_disetujui':$('.agree_nominal').val(),
            }
            _ajax.post("{{ route('agree.partial') }}",data,
                (response) => {
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                (response) => {
                    if (response.status == 404) {
                        _swalert(response);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
        });

        $(document).on('click','.agree_limit',function(e){
            e.preventDefault();
            let data = {
                'klaim_id':$('.klaim_id').val(),
                'nominal_disetujui':$('.agree_nominal_ditwarkan').val(),
            }
            _ajax.post("{{ route('agree.limit') }}",data,
                (response) => {
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                },
                (response) => {
                    if (response.status == 404) {
                        _swalert(response);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
        })
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
