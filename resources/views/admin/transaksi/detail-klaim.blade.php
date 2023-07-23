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
                            <div class="fs-5 text-muted mb-2">Tanggal Klaim</div>
                            <input class="klaim_id" type="hidden" name="klaim_id" value="{{ $data->id }}">
                            <div class="fs-4 fw-bold">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $data->tgl_klaim, 'Asia/Jakarta')->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Member</div>
                            <div class="fs-4 fw-bold">{{ $data->member->nama_lengkap }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Nomor Polis</div>
                            <input type="hidden" name="polis_id" class="polis_id" value="{{ $data->polis->id }}">
                            <div class="fs-4 fw-bold">{{ $data->polis->nomor_polis }}</div>
                        </div>
                        <div class="col-md-3 p-1 rounded">
                            <div class="fs-5 text-muted mb-2">Status Klaim</div>
                            <div class="fs-4">
                                @if ($data->status_set->id==1)
                                    <span class="badge text-bg-light shadow-sm">{{ $data->status_set->status }}</span>
                                @elseif ($data->status_set->id==2)
                                    <span class="badge text-bg-danger text-white shadow-sm">{{ $data->status_set->status }}</span>
                                @elseif ($data->status_set->id==3)
                                    <span class="badge text-bg-success text-white shadow-sm">{{ $data->status_set->status }}</span>
                                @elseif ($data->status_set->id==7)
                                    <span class="badge text-bg-info text-white shadow-sm">{{ $data->status_set->status }}</span>
                                @else
                                    <span class="badge text-bg-warning shadow-sm">{{ $data->status_set->status }}</span>
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
            <h4 class="mb-4">Data Klaim Asuransi</h4>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex mb-3 justify-content-between pb-2">
                        <div class="col-md-6">
                            <div class="fw-bold">Keterangan Klaim</div>
                        </div>
                        <div class="col-md-6 text-end">
                            {{ $data->keterangan_klaim }}
                        </div>
                    </div>
                    <div class="my-3 fs-4">
                        Rincian Biaya :
                    </div>
                    <div class="d-flex mb-3 justify-content-between border-bottom pb-2">
                        <div class="col-md-6">
                            <div class="fw-bold">Nominal Pembayaran Rumah Sakit</div>
                        </div>
                        <div class="col-md-6 text-end">
                            Rp{{ number_format($data->nominal_bayar_rs,0,'','.') }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between border-bottom pb-2">
                        <div class="col-md-6">
                            <div class="fw-bold">Nominal Pembayaran Resep Obat</div>
                        </div>
                        <div class="col-md-6 text-end">
                            Rp{{ number_format($data->nominal_bayar_obat,0,'','.') }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between border-bottom pb-2">
                        <div class="col-md-6">
                            <div class="fw-bold">Nominal Pembayaran Diagnosa Dokter</div>
                        </div>
                        <div class="col-md-6 text-end">
                            Rp{{ number_format($data->nominal_bayar_dokter,0,'','.') }}
                        </div>
                    </div>
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Total Nominal Klaim</div>
                        </div>
                        <div class="col-md-6 text-end fw-bold {{ $data->status_klaim==7 || $data->nominal_disetujui!=null?'text-muted text-decoration-line-through':'text-success' }}">
                            Rp{{ number_format(($data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter),0,'','.') }}
                        </div>
                    </div>
                    @if ($data->status_klaim==7 || $data->nominal_disetujui!=null)
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Total Nominal Disetujui</div>
                        </div>
                        <div class="col-md-6 text-end fw-bold text-success">
                            Rp{{ number_format(($data->nominal_disetujui),0,'','.') }}
                        </div>
                    </div>
                    @endif
                    @if ($data->status_klaim==6)
                    <div class="d-flex mb-3 justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Total Nominal Ditawarkan</div>
                        </div>
                        <div class="col-md-6 text-end fw-bold text-info">
                            Rp{{ number_format(($data->konfirmasi_klaim_asuransi->nominal_ditawarkan),0,'','.') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="fw-bold mb-3">Bukti Bayar Rumah Sakit</div>
                    <img src="{{ asset(Storage::url($data->foto_bukti_bayar)) }}" class="w-100 img-zoomable" alt="Bukti Bayar Rumah Sakit">
                </div>
                <div class="col-md-4 mb-3">
                    <div class="fw-bold mb-3">Bukti Bayar Resep Obat</div>
                    <img src="{{ asset(Storage::url($data->foto_resep_obat)) }}" class="w-100 img-zoomable" alt="Bukti Bayar Resep Obat">
                </div>
                <div class="col-md-4 mb-3">
                    <div class="fw-bold mb-3">Bukti Bayar Diagnosa Dokter</div>
                    <img src="{{ asset(Storage::url($data->foto_diagnosa_dokter)) }}" class="w-100 img-zoomable" alt="Bukti Bayar Diagnosa Dokter">
                </div>
            </div>
        </div>
    </div>
</div>

@if ($data->status_klaim!=3)
<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-2"></div>
                <div class="col-md-8 px-4">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Status Limit</div>
                        </div>
                        @if ($status)
                        <div class="col-md-6 text-end fw-bold">
                            <span class="badge text-white bg-success">SUFFICIENT</span>
                        </div>
                        @else
                        <div class="col-md-6 text-end fw-bold">
                            <span class="badge text-white bg-danger">INSUFFICIENT</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8 px-4">
                    <div class="d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="fw-bold">Sisa Limit Klaim Sekarang</div>
                        </div>
                        <div class="col-md-6 text-end fw-bold {{ $status?'text-success':'text-danger' }}">
                            Rp{{ number_format(($limit_klaim),0,'','.') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                @if ($data->status_klaim==3)
                    <button class="btn btn-secondary me-2" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-check2-square"></i> Terima & Buat Nota Klaim</button>
                    <button class="btn btn-secondary" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                @elseif ($data->status_klaim==2)
                    <button class="btn btn-secondary me-2" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-check2-square"></i> Terima & Buat Nota Klaim</button>
                    <button class="btn btn-secondary" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                @elseif ($data->status_klaim==6)
                    <button class="btn btn-secondary me-2" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-check2-square"></i> Terima & Buat Nota Klaim</button>
                    <button class="btn btn-secondary" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                @elseif ($data->status_klaim==5)
                    <button class="btn btn-secondary me-2" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                    <button class="btn btn-secondary" style="width: 300px;height: 35px;" @disabled(true)><i class="bi bi-pencil-square"></i> Tolak & Konfirmasi Nominal</button>
                @elseif (!$status)
                    <button class="btn btn-danger me-2" style="width: 300px;height: 35px;" data-bs-toggle="modal" data-bs-target="#modal_reject"><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                    <button class="btn btn-warning" style="width: 300px;height: 35px;" data-bs-toggle="modal" data-bs-target="#modal_nominal"><i class="bi bi-pencil-square"></i> Tolak & Konfirmasi Nominal</button>
                @else
                    <button class="btn btn-success me-2" style="width: 300px;height: 35px;" data-bs-toggle="modal" data-bs-target="#modal_accept"><i class="bi bi-check2-square"></i> Terima & Buat Nota Klaim</button>
                    <button class="btn btn-danger" style="width: 300px;height: 35px;" data-bs-toggle="modal" data-bs-target="#modal_reject"><i class="bi bi-x-circle"></i> Tolak & Butuh Revisi</button>
                @endif
                {{-- <a href="{{ URL::route('test.pdf', $data->id) }}" class="btn btn-secondary ms-2" style="width: 200px;height: 35px;"><i class="bi bi-check2-square"></i> Test PDF</a> --}}
            </div>

            <div class="modal fade" id="modal_reject" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tolak Klaim Asuransi</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body mx-3">
                            <form id="create">
                                <div class="mb-3">
                                    <textarea id="alasan" class="form-control alasan" name="alasan" placeholder="Alasan menolak" rows="3"></textarea>
                                    <small class="text-danger alasan_error"></small>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary ms-2 btn-default reject">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_nominal" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tolak Klaim Asuransi</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body mx-3">
                            <form id="create">
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Nominal yang bisa diberikan <i class="text-danger">*</i></label>
                                    <input type="hidden" name="diajukan" class="diajukan" value="{{ $data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter }}">
                                    <input type="hidden" name="limit" class="limit_sekarang" value="{{ $limit_klaim }}">
                                    <input class="form-control rupiah_format" type="text" id="nominal_ditawarkan" name="nominal" placeholder="Rp. 00,0" value="{{ number_format(($limit_klaim),0,'','.') }}">
                                    <small class="text-danger nominal_ditawarkan_error"></small>
                                </div>
                                <div class="mb-3">
                                    <textarea id="alasan" class="form-control alasan_nominal" name="alasan_nominal" placeholder="Alasan konfirmasi nominal" rows="3"></textarea>
                                    <small class="text-danger alasan_error"></small>
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="reset" class="btn btn-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary ms-2 btn-default nominal_confirm">Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal_accept" tabindex="-1" aria-modal="true" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body mx-3">
                            <div class="d-flex justify-content-between mb-3">
                                <h4 class="modal-title">Konfirmasi Klaim Asuransi</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="row mb-4 border p-2 rounded shadow-xl bg-light">
                                <div class="col-12">
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Bank
                                        </div>
                                        <div class="col-md-6 text-end">
                                            {{ $data->member->master_bank->nama }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Nomor Rekening
                                        </div>
                                        <div class="col-md-6 text-end">
                                            {{ $data->member->no_rekening }}
                                        </div>
                                    </div>
                                    <hr class="my-0 mb-2 py-0" />
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Sisa Limit Pengajuan
                                        </div>
                                        <div class="col-md-6 text-end {{ $status?'text-success':'text-danger' }}">
                                            Rp {{ number_format(($limit_klaim),0,'','.') }}
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Jumlah Pengajuan Klaim
                                        </div>
                                        <div class="col-md-6 text-end {{ $data->status_klaim==7?'text-muted text-decoration-line-through':'text-success' }}">
                                            Rp {{ number_format(($data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter),0,'','.') }}
                                        </div>
                                    </div>
                                    @if ($data->status_klaim==7)
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Jumlah Yang Disetujui
                                        </div>
                                        <div class="col-md-6 text-end text-success fw-bold">
                                            Rp <span>{{ number_format(($data->nominal_disetujui),0,'','.') }}</span>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row mb-2">
                                        <div class="col-md-6 fw-bold">
                                            Jumlah Yang Disetujui
                                        </div>
                                        <div class="col-md-6 text-end">
                                            Rp <span class="agree_total">{{ number_format(($data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter),0,'','.') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <form id="create">
                                @if ($data->status_klaim!=7)
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input tg_radio" type="radio" name="tanggungan" id="semua" value="1" style="width: 20px;height:20px;" checked>
                                                <label class="form-check-label mt-1 ms-2" for="semua">
                                                    Tanggung Semua
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input tg_radio" type="radio" name="tanggungan" id="sebagian" value="2" style="width: 20px;height:20px;">
                                                <label class="form-check-label mt-1 ms-2" for="sebagian">
                                                    Tanggung Sebagian
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="rs" class="form-label">Tanggungan Biaya RS</label>
                                    <div class="row">
                                        <div class="col-md-5 mb-2">
                                            <div class="form-check form-switch d-flex align-item-center">
                                                <input class="form-check-input tg_prop full full_rs" type="checkbox" id="full_rs" checked disabled>
                                                <label class="form-check-label ms-2" for="full_rs"><i class="text-primary"><small>Tanggung Penuh Rp{{ number_format(($data->nominal_bayar_rs),0,'','.') }}</small></i></label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <input class="form-control tg_prop rupiah_format rs" type="text" id="rs" name="rs" placeholder="00,0" value="{{ number_format(($data->nominal_bayar_rs),0,'','.') }}" disabled>
                                            <small class="text-danger rs_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="obat" class="form-label">Tanggungan Biaya Obat</label>
                                    <div class="row">
                                        <div class="col-md-5 mb-2">
                                            <div class="form-check form-switch d-flex align-item-center">
                                                <input class="form-check-input tg_prop full full_obat" type="checkbox" id="full_obat" checked disabled>
                                                <label class="form-check-label ms-2" for="full_obat"><i class="text-primary"><small>Tanggung Penuh Rp{{ number_format(($data->nominal_bayar_obat),0,'','.') }}</small></i></label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <input class="form-control tg_prop rupiah_format obat" type="text" id="obat" name="obat" placeholder="00,0" value="{{ number_format(($data->nominal_bayar_obat),0,'','.') }}" disabled>
                                            <small class="text-danger obat_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="dokter" class="form-label">Tanggungan Biaya Diagnosa Dokter</label>
                                    <div class="row">
                                        <div class="col-md-5 mb-2">
                                            <div class="form-check form-switch d-flex align-item-center">
                                                <input class="form-check-input tg_prop full full_dokter" type="checkbox" id="full_dokter" checked disabled>
                                                <label class="form-check-label ms-2" for="full_dokter"><i class="text-primary"><small>Tanggung Penuh Rp{{ number_format(($data->nominal_bayar_dokter),0,'','.') }}</small></i></label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <input class="form-control tg_prop rupiah_format dokter" type="text" id="dokter" name="dokter" placeholder="00,0" value="{{ number_format(($data->nominal_bayar_dokter),0,'','.') }}" disabled>
                                            <small class="text-danger dokter_error"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-3">
                                    <button class="btn btn-sm btn-success rounded count__total" disabled="disabled">Hitung</button>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <textarea id="keterangan" class="form-control keterangan" name="keterangan" placeholder="Keterangan/Alasan" rows="3"></textarea>
                                    <small class="text-danger keterangan_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="foto" class="form-label">Foto Bukti Bayar Klaim</label>
                                    <input class="form-control" type="file" id="bukti_bayar_klaim" name="bukti_bayar_klaim">
                                    <input class="form-control" type="hidden" id="total_klaim" name="total_klaim" value="{{ $data->status_klaim!=7?$data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter:$data->nominal_disetujui }}">
                                    <small class="text-danger bukti_bayar_klaim_error"></small>
                                </div>
                                <div class="d-flex justify-content-center mt-4 mb-2">
                                    <button type="reset" class="btn btn-outline-secondary cancel" data-bs-dismiss="modal">Batal</button>
                                    <div class="cg__btn">
                                        <button type="submit" class="btn btn-primary btn-default ms-2 accept">Kirim</button>
                                    </div>
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
        $('.rupiah_format').on('keyup',function(e){this.value=_input.rupiah(this.value)});
        $(document).on('click','.reject', function(e){
            e.preventDefault();
            let data = {
                'id': $('.klaim_id').val(),
                'alasan':$('#alasan').val()
            }
            _input.loading.start(this);
            _ajax.post("{{ route('klaim.reject') }}",data,
                (response) => {
                    _input.loading.stop('.reject','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('klaim') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.reject','Kirim');
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
        });

        $(document).on('click','.accept', function(e){
            e.preventDefault();
            let data = new FormData();
            let bukti = $('#bukti_bayar_klaim')[0].files;
            data.append('bukti_bayar_klaim',bukti[0]);
            data.append('id',$('.klaim_id').val());
            data.append('keterangan',$('.keterangan').val());
            data.append('total_klaim',$('#total_klaim').val());
            _input.loading.start(this);
            _ajax.postWithFile("{{ route('klaim.confirm') }}",data,
                (response) => {
                    _input.loading.stop('.accept','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('klaim') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.accept','Kirim');
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

        $(document).on('click','.nominal_confirm', function(e){
            e.preventDefault();
            let data = {
                'id': $('.klaim_id').val(),
                'nominal_limit':parseFloat($('.limit_sekarang').val()),
                'nominal_pengajuan':parseFloat($('.diajukan').val()),
                'nominal_ditawarkan':$('#nominal_ditawarkan').val()==''?null:parseFloat($('#nominal_ditawarkan').val().split(".").join("")),
                'alasan':$('.alasan_nominal').val()
            }
            _input.loading.start(this);
            _ajax.post("{{ route('klaim.nominal-confirmation') }}",data,
                (response) => {
                    _input.loading.stop('.nominal_confirm','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('klaim') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.nominal_confirm','Kirim');
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
        });

        $(document).on('click','.partial_confirm', function(e){
            e.preventDefault();
            let rs = $('.rs').val()==''?0:parseFloat($('.rs').val().split(".").join(""));
            let obat = $('.obat').val()==''?0:parseFloat($('.obat').val().split(".").join(""));
            let dokter = $('.dokter').val()==''?0:parseFloat($('.dokter').val().split(".").join(""));
            let data = {
                'id': $('.klaim_id').val(),
                'nominal_ditawarkan':rs+obat+dokter,
                'keterangan':$('#keterangan').val(),
                'rs':rs,
                'obat':obat,
                'dokter':dokter
            }
            _input.loading.start(this);
            _ajax.post("{{ route('klaim.partial-confirmation') }}",data,
                (response) => {
                    _input.loading.stop('.partial_confirm','Konfirmasi');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('klaim') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.partial_confirm','Konfirmasi');
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


        $(document).on('change','.tg_radio', function(e){
            e.preventDefault();
            let tg = parseInt($('.tg_radio:checked').val());
            if(tg === 1) {
                $('input.tg_prop').attr('disabled','disabled');
                $('.count__total').attr('disabled','disabled');
                $('.full').prop('checked',true);
                $('input#bukti_bayar_klaim').removeAttr('disabled');
                $('.agree_total').html(_input.rupiah(({!! $data->nominal_bayar_rs+$data->nominal_bayar_obat+$data->nominal_bayar_dokter !!}).toString()))
                $('.rs').val(_input.rupiah(({!! $data->nominal_bayar_rs !!}).toString()));
                $('.obat').val(_input.rupiah(({!! $data->nominal_bayar_obat !!}).toString()));
                $('.dokter').val(_input.rupiah(({!! $data->nominal_bayar_dokter !!}).toString()));
                $('.cg__btn').html('<button type="submit" class="btn btn-primary btn-default ms-2 accept">Kirim</button>');

            } else {
                $('input#bukti_bayar_klaim').attr('disabled','disabled');
                $('input.tg_prop').removeAttr('disabled');
                $('.count__total').removeAttr('disabled');
                $('input.tg_prop').prop('checked', false);
                $('.agree_total').html('0');
                $('input.tg_prop').val('');
                $('.cg__btn').html('<button type="submit" class="btn btn-primary btn-default ms-2 partial_confirm">Konfirmasi</button>');
            }
        });

        $(document).on('click','.count__total', function(e){
            e.preventDefault()
            let rs = $('.rs').val()==''?0:parseFloat($('.rs').val().split(".").join(""));
            let obat = $('.obat').val()==''?0:parseFloat($('.obat').val().split(".").join(""));
            let dokter = $('.dokter').val()==''?0:parseFloat($('.dokter').val().split(".").join(""));
            $('.agree_total').html(_input.rupiah((rs+obat+dokter).toString()));
        });

        const autoFullCheckbox = (elChange,elTarget,acc) => {
            $(document).on('change',elChange, function(e){
                e.preventDefault();
                if($(this).is(':checked')) {
                    $(elTarget).val(_input.rupiah(acc.toString()));
                } else {
                    $(elTarget).val('');
                }
            });
        };

        const checkboxFull = (elKeyup,elTarget,acc) => {
            $(document).on('keyup',elKeyup, function(e){
                e.preventDefault();
                let val = parseInt($(this).val().split(".").join(""));

                if (val>=acc) {
                    $(elTarget).prop('checked',true)
                } else {
                    $(elTarget).prop('checked',false)
                }
            });
        }

        checkboxFull('.rs','.full_rs',{!! $data->nominal_bayar_rs !!})
        checkboxFull('.obat','.full_obat',{!! $data->nominal_bayar_obat !!})
        checkboxFull('.dokter','.full_dokter',{!! $data->nominal_bayar_dokter !!})

        autoFullCheckbox('.full_rs','.rs',{!! $data->nominal_bayar_rs !!});
        autoFullCheckbox('.full_obat','.obat',{!! $data->nominal_bayar_obat !!});
        autoFullCheckbox('.full_dokter','.dokter',{!! $data->nominal_bayar_dokter !!});
    });
</script>
@endpush
