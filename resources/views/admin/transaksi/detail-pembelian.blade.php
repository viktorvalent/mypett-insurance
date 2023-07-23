@extends('layouts.dashboard.app')

@section('title', $title)

@push('css')
<link href="{{ asset('dashboard/css/jquery-datatable.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('dashboard/css/zooming.css') }}">
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Tanggal Pendaftaran</div>
                            <input class="pembelian_id" type="hidden" name="pembelian_id" value="{{ $data->id }}">
                            <div class="fs-4 fw-bold">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_daftar_asuransi, 'Asia/Jakarta')->format('d-m-Y') }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Member</div>
                            <div class="fs-4 fw-bold">{{ $data->member->nama_lengkap }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Nama Pemilik</div>
                            <div class="fs-4 fw-bold">{{ $data->nama_pemilik }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Status Pembelian</div>
                            <div class="fs-4">
                                @if ($data->status_pembelian->id==1)
                                    <span class="badge text-bg-light shadow-sm">{{ $data->status_pembelian->status }}</span>
                                @elseif ($data->status_pembelian->id==2)
                                    <span class="badge text-bg-danger text-white shadow-sm">{{ $data->status_pembelian->status }}</span>
                                @elseif ($data->status_pembelian->id==3)
                                    <span class="badge text-bg-success text-white shadow-sm">{{ $data->status_pembelian->status }}</span>
                                @else
                                    <span class="badge text-bg-warning shadow-sm">{{ $data->status_pembelian->status }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="mb-4">Data Pembelian Asuransi</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Nama Hewan</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->nama_hewan }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Jenis Hewan</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->ras_hewan->jenis_hewan->nama }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Ras Hewan</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->ras_hewan->nama_ras }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Jenis Kelamin</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->jenis_kelamin_hewan }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Tanggal Lahir</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_lahir_hewan, 'Asia/Jakarta')->format('d-m-Y') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Umur Hewan</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ \Carbon\Carbon::parse($data->tgl_lahir_hewan)->age }} Tahun
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Berat Hewan</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->berat_badan_kg }} Kg
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Nama Produk</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->produk->nama_produk }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Jangka Waktu</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->jangka_waktu }} Tahun
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Total Pembayaran</div>
                        </div>
                        <div class="col-md-6 text-end fw-bold text-success">
                            Rp {{ number_format(($data->biaya_pendaftaran+$data->harga_dasar_premi),0,'','.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="fw-bold mb-3">Foto Hewan</div>
                    <img src="{{ asset(Storage::url($data->foto)) }}" class="w-100 img-zoomable" alt="Foto Hewan">
                </div>
                <div class="col-md-4">
                    <div class="fw-bold mb-3">Bukti Pembayaran</div>
                    <img src="{{ asset(Storage::url($data->bukti_bayar)) }}" class="w-100 img-zoomable" alt="Bukti Pembayaran">
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                @if ($data->status==3)
                    <button class="btn btn-success" style="width: 200px;height: 35px;" @disabled(true)><i class="bi bi-check2-square"></i> Terima & Buat Polis</button>
                @else
                    <button class="btn btn-success" style="width: 200px;height: 35px;" data-bs-toggle="modal" data-bs-target="#modal_create"><i class="bi bi-check2-square"></i> Terima & Buat Polis</button>
                @endif
            </div>
            <div class="modal fade" id="modal_create" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Buat Polis Asuransi</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body m-1">
                            <form id="create">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-b">
                                            <label class="form-label required">Tanggal Mulai <i class="text-danger">*</i></label>
                                            <input id="tgl_mulai" type="date" name="tgl_mulai" class="form-control" placeholder="Tanggal Mulai">
                                            <small class="text-danger tgl_mulai_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary ms-2 create">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery-datatable.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script src="{{ asset('dashboard/js/zooming.js') }}"></script>
<script>
    $(document).ready(function () {
        new Zooming().listen('.img-zoomable');
        $(document).on('click','.create', function(e){
            e.preventDefault();
            let data = {
                'id': $('.pembelian_id').val(),
                'tgl_mulai':$('#tgl_mulai').val(),
            }
            _input.loading.start(this);
            _ajax.post("{{ route('pembelian.confirm') }}",data,
                (response) => {
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('pembelian') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 400) {
                        _validation.action(response.responseJSON)
                    } else if (response.status == 404) {
                        _swalert(response);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            );
        })
    });
</script>
@endpush
