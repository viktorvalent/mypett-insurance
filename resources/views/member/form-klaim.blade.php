@extends('member.dashboard')

@section('member')
<div class="row">
    <div class="col-sm-1 col-md-2"></div>
    <div class="col-sm-10 col-md-8 col-12">
        <div class="card shadow" style="opacity: 0.955 !important;">
            <div class="card-header py-3">
                <h4 class="text-center">Silahkan isi form dengan benar.</h4>
            </div>
            <div class="card-body mx-2">
                <form enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="polis" class="form-label">Polis <span class="text-danger">*</span></label>
                        <input type="hidden" class="member_id" value="{{ auth()->user()->member->id }}">
                        <select class="form-select polis" name="polis" id="polis" placeholder="JJJJ">
                            @foreach ($pembelians as $item)
                                @if ($item->polis()->exists())
                                    @if ($item->polis->tgl_polis_mulai <= \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d'));
                                    <option value="{{ $item->polis->id }}">{{ $item->produk->nama_produk }} - Nomor Polis : {{ $item->polis->nomor_polis }}</option>
                                    @else
                                    <option disabled selected value="0">Tidak ada polis yang aktif</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <small class="text-danger polis_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_rs" class="form-label">Nominal Bayar Rumah Sakit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rupiah_format" id="nominal_rs" placeholder="Rp">
                        <small class="text-danger nominal_rs_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Bukti Bayar Rumah Sakit<span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="bukti" name="bukti">
                        <small class="text-danger bukti_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_obat" class="form-label">Nominal Bayar Obat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rupiah_format" id="nominal_obat" placeholder="Rp">
                        <small class="text-danger nominal_obat_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="resep" class="form-label">Foto Bayar Resep Obat <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="resep" name="resep">
                        <small class="text-danger resep_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="nominal_dokter" class="form-label">Nominal Bayar Diagnosa Dokter <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rupiah_format" id="nominal_dokter" placeholder="Rp">
                        <small class="text-danger nominal_dokter_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">Foto Diagnosa Dokter <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="diagnosa" name="diagnosa">
                        <small class="text-danger diagnosa_error"></small>
                    </div>
                    <div class="mb-3">
                        <label for="ket" class="form-label">Keterangan Klaim <span class="text-danger">*</span></label>
                        <textarea name="ket" class="form-control" id="ket" rows="3" placeholder="Keterangan"></textarea>
                        <small class="text-danger ket_error"></small>
                    </div>
                    <div class="d-flex justify-content-center py-3">
                        <button type="submit" class="btn btn-primary shadow create" style="width: 150px;">Kirim</button>
                    </div>
                </form>
            </div>
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
        $('.rupiah_format').on('keyup',function (e) {
            this.value = _input.rupiah(this.value);
        });

        $(document).on('click','.create', function (e) {
            e.preventDefault();
            const data = new FormData();
            let bukti = $('#bukti')[0].files;
            let resep = $('#resep')[0].files;
            let diagnosa = $('#diagnosa')[0].files;
            data.append('bukti',bukti[0]);
            data.append('resep',resep[0]);
            data.append('diagnosa',diagnosa[0]);
            data.append('member_id',$('.member_id').val());
            data.append('polis',$('#polis option:selected').val());
            data.append('nominal_rs',parseFloat($('#nominal_rs').val().split('.').join('')));
            data.append('nominal_obat',parseFloat($('#nominal_obat').val().split('.').join('')));
            data.append('nominal_dokter',parseFloat($('#nominal_dokter').val().split('.').join('')));
            data.append('ket',$('#ket').val());
            _input.loading.start(this);

            if ($('#polis option:selected').val()==0) {
                var swal = Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Polis harus diisi!',
                        })
                        _input.loading.stop('.create','Kirim');
                return swal;
            }
            _ajax.postWithFile("{{ route('claim.make') }}",data,
                (response) => {
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.href="{{ route('member.claim') }}";
                        }, 1500);
                    }
                },
                (response) => {
                    _input.loading.stop('.create','Kirim');
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
        });
    });
</script>
@endpush
