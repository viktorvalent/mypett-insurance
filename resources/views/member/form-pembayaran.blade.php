@extends('member.dashboard')

@section('member')
<div class="row">
    <div class="col-sm-1 col-md-2"></div>
    <div class="col-sm-10 col-md-8 col-12">
        <div class="card shadow mb-3" style="opacity: 0.955 !important;">
            <div class="card-header py-3">
                <h4 class="text-center">Form Pembayaran</h4>
            </div>
            <div class="card-body mx-2" style="font-size: .85em">
                <div class="d-flex justify-content-between mb-2 ">
                    <div class="fw-bold">Nama Produk</div>
                    <div class="">{{ $notpayed->produk->nama_produk }}</div>
                </div>
                <div class="d-flex justify-content-between mb-3 border-bottom py-2">
                    <div class="fw-bold">Jenis Hewan</div>
                    <div class="">{{ $notpayed->ras_hewan->jenis_hewan->nama }} ({{ $notpayed->ras_hewan->nama_ras }})</div>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <div class="fw-bold">Harga Dasar Premi</div>
                    <div class="">Rp {{ number_format($notpayed->harga_dasar_premi,0,'','.') }}</div>
                </div>
                <div class="d-flex justify-content-between mb-2 border-bottom pb-2">
                    <div class="fw-bold">Biaya Pendaftaran</div>
                    <div class="">Rp {{ number_format($notpayed->biaya_pendaftaran,0,'','.') }}</div>
                </div>
                <div class="d-flex justify-content-between my-2">
                    <div class="fw-bold">Total Pembayaran</div>
                    <div class="text-success fw-bold">Rp {{ number_format(($notpayed->harga_dasar_premi+$notpayed->biaya_pendaftaran),0,'','.') }}</div>
                </div>
            </div>
        </div>
        <div class="card shadow" style="opacity: 0.955 !important;">
            <div class="card-body mx-2 mt-3" style="font-size: .85em">
                <h6>Transfer pembayaran ke salah satu bank dibawah ini :</h6>
                <div class="row justify-content-center">
                    @foreach ($banks as $item)
                        @if (count($item->nomor_rekening_bank)<1)
                            <em class="my-3">Metode Pembayaran belum tersedia...</em>
                        @else
                            <div class="col-md-6 shadow m-3 px-2 rounded" style="width:17rem;">
                                <div class="d-flex">
                                    <div class="d-flex align-items-center ps-2">
                                        <img src="{{ asset(Storage::url($item->logo)) }}" style="width: 50px;" alt="">
                                    </div>
                                    <div class="row ps-4 py-2">
                                        <div class="col-12">Bank {{ $item->nama }}</div>
                                        <div class="col-12 text-primary fw-semibold">{{ $item->nomor_rekening_bank[0]->nomor_rekening }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <form id="create" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="bukti" class="form-label">Bukti Pembayaran <span class="text-danger">*</span> <em>(jpg/png)</em></label>
                        <input type="hidden" name="pembelian_id" class="pembelian_id" value="{{ $notpayed->id }}">
                        <input class="form-control" type="file" id="bukti" name="bukti">
                        <small class="text-danger bukti_error"></small>
                    </div>
                    <div class="d-flex justify-content-center py-3">
                        <button type="submit" class="btn btn-primary shadow create" style="width: 150px;">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    <div class="col-sm-1 col-md-2"></div>
</div>
@endsection

@push('member_js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script>
    $(document).ready(function () {
        $(document).on('click','.create', function(e){
            e.preventDefault();
            var files = $('#bukti')[0].files;
            let data = new FormData();
            data.append('bukti',files[0]);
            data.append('pembelian_id',$('.pembelian_id').val());
            _ajax.postWithFile("{{ route('pembelian.bayar.konfirmasi') }}",data,
                (response) => {
                    if(response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.href="{{ route('member.my-insurance') }}";
                        }, 2000);
                    }
                },
                (response) => {
                    if (response.status == 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Perhatikan inputan anda dengan benar',
                        })
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
