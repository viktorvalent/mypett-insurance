@extends('layouts.dashboard.app')

@section('title', 'Edit '.$title)

@push('css')
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 col-sm-1"></div>
                <div class="col-md-8 col-sm-10">
                    <form>
                        <h5>Produk</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="hidden" name="id" class="produk_id" value="{{ $data->id }}">
                                    <input type="text" name="nama" class="form-control" id="nama_produk" placeholder="Nama" value="{{ $data->nama_produk }}">
                                    <small class="text-danger nama_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">Kelas Kamar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kelas_kamar" placeholder="Kelas Kamar" value="{{ $data->kelas_kamar }}">
                                    <small class="text-danger kelas_kamar_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Limit Kamar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="limit_kamar" placeholder="Limit Kamar" value="{{ number_format($data->limit_kamar,0,'','.') }}">
                                    <small class="text-danger limit_kamar_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Limit Obat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="limit_obat" placeholder="Limit obat" value="{{ number_format($data->limit_obat,0,'','.') }}">
                                    <small class="text-danger limit_obat_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Satuan Limit Kamar <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="satuan_limit_kamar" placeholder="Satuan" value="{{ number_format($data->satuan_limit_kamar,0,'','.') }}">
                                    <small class="text-danger satuan_limit_kamar_error"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Satuan Limit Obat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="satuan_limit_obat" placeholder="Satuan" value="{{ number_format($data->satuan_limit_obat,0,'','.') }}">
                                    <small class="text-danger satuan_limit_obat_error"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Satuan Limit Dokter <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="satuan_limit_dokter" placeholder="Satuan" value="{{ number_format($data->satuan_limit_dokter,0,'','.') }}">
                                    <small class="text-danger satuan_limit_dokter_error"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Benefit</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Nilai Pertanggungan Minimal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="nilai_pertanggungan_min" name="nilai_pertanggungan_min" placeholder="Rp." value="{{ number_format($data->produk_benefit->nilai_pertanggungan_min,0,'','.') }}">
                                    <small class="text-danger nilai_pertanggungan_min_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Nilai Pertanggungan Maksimal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="nilai_pertanggungan_max" name="nilai_pertanggungan_max" placeholder="Rp." value="{{ number_format($data->produk_benefit->nilai_pertanggungan_max,0,'','.') }}">
                                    <small class="text-danger nilai_pertanggungan_max_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Santunan Mati Kecelakaan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="santunan_mati_kecelakaan" name="santunan_mati_kecelakaan" placeholder="Rp." value="{{ number_format($data->produk_benefit->santunan_mati_kecelakaan_max,0,'','.') }}">
                                    <small class="text-danger santunan_mati_kecelakaan_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Santunan untuk Kecurian <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="santunan_kecurian" name="santunan_kecurian" placeholder="%" value="{{ $data->produk_benefit->santunan_pencurian_max }}">
                                    <small class="text-danger santunan_kecurian_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Tanggung jawab hukum pihak ketiga <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="tanggung_jawab_hukum" name="tanggung_jawab_hukum" placeholder="Rp." value="{{ number_format($data->produk_benefit->hukum_pihak_ketiga_max,0,'','.') }}">
                                    <small class="text-danger tanggung_jawab_hukum_error"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Maksimal Santunan Kremasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="santunan_kremasi" placeholder="Rp." value="{{ number_format($data->produk_benefit->santunan_kremasi_max,0,'','.') }}">
                                    <small class="text-danger santunan_kremasi_error"></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Maksimal Santunan Rawat Inap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="santunan_rawat_inap" placeholder="Rp." value="{{ number_format($data->produk_benefit->santunan_rawat_inap_max,0,'','.') }}">
                                    <small class="text-danger santunan_rawat_inap_error"></small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h5>Konten</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Harga untuk Konten <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control rupiah_format" id="harga_konten" name="harga_konten" placeholder="Rp." value="{{ number_format($data->konten->harga,0,'','.') }}">
                                    <small class="text-danger harga_konten_error"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nohp" class="form-label">Icon untuk konten (Bootstrap Icon) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Bootstrap Icon" value="{{ $data->konten->icon }}">
                                    <small class="text-danger icon_error"></small>
                                </div>
                            </div>
                        </div>
                        <div class="py-4 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary create">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 col-sm-1"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.rupiah_format').on('keyup',function (e) {
            this.value = _input.rupiah(this.value);
        });
        $(document).on('click','.create', function(e) {
            e.preventDefault();
            let data = {
                'id':$('.produk_id').val(),
                'nama_produk':$('#nama_produk').val(),
                'kelas_kamar':$('#kelas_kamar').val(),
                'limit_kamar':parseFloat((($('#limit_kamar').val()).split('.').join(''))),
                'limit_obat':parseFloat((($('#limit_obat').val()).split('.').join(''))),
                'satuan_limit_kamar':parseFloat((($('#satuan_limit_kamar').val()).split('.').join(''))),
                'satuan_limit_obat':parseFloat((($('#satuan_limit_obat').val()).split('.').join(''))),
                'satuan_limit_dokter':parseFloat((($('#satuan_limit_dokter').val()).split('.').join(''))),
                'nilai_pertanggungan_min':parseFloat((($('#nilai_pertanggungan_min').val()).split('.').join(''))),
                'nilai_pertanggungan_max':parseFloat((($('#nilai_pertanggungan_max').val()).split('.').join(''))),
                'santunan_mati_kecelakaan':parseFloat((($('#santunan_mati_kecelakaan').val()).split('.').join(''))),
                'santunan_kecurian':$('#santunan_kecurian').val(),
                'icon':$('#icon').val(),
                'tanggung_jawab_hukum':parseFloat((($('#tanggung_jawab_hukum').val()).split('.').join(''))),
                'santunan_kremasi':parseFloat((($('#santunan_kremasi').val()).split('.').join(''))),
                'santunan_rawat_inap':parseFloat((($('#santunan_rawat_inap').val()).split('.').join(''))),
                'harga_konten':parseFloat((($('#harga_konten').val()).split('.').join(''))),
            }
            _input.loading.start(this);
            _ajax.post("{{ route('master-data.produk-asuransi.update') }}",data,
                (response)=>{
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            window.location.href="{{ route('master-data.produk-asuransi') }}";
                        }, 2000);
                    }
                },
                (response)=>{
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 400) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.responseJSON.error.isi[0],
                            showConfirmButton: false,
                            timer: 1500
                        })
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
