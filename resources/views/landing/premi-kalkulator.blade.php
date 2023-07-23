@extends('layouts.landing.app')

@push('css')
<style>
    tr {
        height: 4rem !important;
    }
</style>
@endpush

@section('content')
<div class="container my-3">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="text-center">Kalkulator Simulasi Premi</h5>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td class="align-middle" style="width: 30%;">Jenis Hewan</td>
                                <td class="align-middle">
                                    <select class="form-select jenis_hewan" aria-label="Default select example">
                                        <option selected disabled>Pilih Jenis Hewan</option>
                                        @foreach ($jeniss as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 30%;">Ras Hewan</td>
                                <td class="align-middle select_ras">
                                    <select class="form-select" aria-label="Default select example" disabled="disabled" style="cursor: no-drop !important;">
                                        <option selected disabled>Pilih Ras Hewan</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 30%;">Harga Hewan</td>
                                <td class="align-middle">
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="text" class="form-control rupiah_format harga_hewan" aria-label="Harga Hewan" placeholder="Harga Hewan">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 30%;">Umur Hewan</td>
                                <td class="align-middle">
                                    <div class="input-group">
                                        <input type="number" min="0" oninput="this.value=Math.abs(this.value)" class="form-control umur_hewan" aria-label="Harga Hewan" placeholder="Umur Hewan">
                                        <span class="input-group-text">Tahun</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 30%;">Bunga Premi</td>
                                <td class="align-middle">
                                    {{-- <div class="input-group">
                                        <input type="number" min="0" oninput="this.value=Math.abs(this.value)" class="form-control premi" aria-label="Harga Hewan" placeholder="Umur Hewan">
                                        <span class="input-group-text">%</span>
                                    </div> --}}
                                    <select class="form-select premi" aria-label="Default select example">
                                        <option selected disabled>Pilih Premi</option>
                                        <option value="5">Premi 5%</option>
                                        <option value="10">Premi 10%</option>
                                        <option value="15">Premi 15%</option>
                                    </select>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center my-2 mb-3">
                        <button class="btn btn-primary btn-default hitung">Hitung Simulasi</button>
                    </div>
                    <div class="result">
                        <div class="bg-light rounded p-3">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    Jumlah Premi per Bulan
                                </div>
                                <div class="col-sm-6 text-end fw-bold">
                                    <span>Rp</span><span class="jumlah_premi">0</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    Biaya Admin
                                </div>
                                <div class="col-sm-6 text-end fw-bold">
                                    <span>Rp</span><span class="biaya_adm">0</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6 fw-bold">
                                    Total
                                </div>
                                <div class="col-sm-6 text-end fw-bold">
                                    <span>Rp</span><span class="biaya_adm"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('dashboard/js/jquery.js') }}"></script>
<script src="{{ asset('dashboard/js/support.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.rupiah_format').on('keyup',function (e) {
            this.value = _input.rupiah(this.value);
        });
        $(document).on('change','.jenis_hewan', function(e){
            e.preventDefault();
            let id = $('.jenis_hewan option:selected').val();
            _ajax.get(`{{ url('calculator/get-ras-hewan') }}/${id}`,
                (response) => {
                    if (response.status == 200) {
                        let option = [];
                        response.data.map(e=>{option.push(`<option value="${e.id}" data-persen="${e.persen_per_umur}" data-harga="${e.harga_hewan}">${e.nama_ras}</option>`)});
                        $('.select_ras').html(`<select class="form-select ras_hewan"><option selected disabled>Pilih Ras Hewan</option>${option.join('')}</select>`)
                    }
                }
            )
        });

        $(document).on('click','.hitung', function(e){
            e.preventDefault();
            let data = {
                "persen_umur":parseInt($('.ras_hewan option:selected').data('persen')),
                "harga_hewan":parseFloat(($('.harga_hewan').val()).split('.').join('')),
                "umur_hewan":parseFloat($('.umur_hewan').val()),
                "premi":parseInt($('.premi option:selected').val()),
            }

            let jumlah_premi = data.harga_hewan*(data.premi/100);
            jumlah_premi = jumlah_premi+(jumlah_premi*((data.persen_umur*data.umur_hewan)/100))
            let total = jumlah_premi+138000;

            $('.result').html(`<div class="bg-light rounded p-3"><div class="row mb-2"><div class="col-6 col-sm-6">Jumlah Premi per Bulan</div><div class="col-6 col-sm-6 text-end fw-bold"><span>Rp</span><span>${_input.rupiah(jumlah_premi.toString())}</span></div></div><div class="row mb-2"><div class="col-6 col-sm-6">Biaya Admin</div><div class="col-6 col-sm-6 text-end fw-bold"><span>Rp</span><span>138.000</span></div></div><hr><div class="row"><div class="col-6 col-sm-6 fw-bold">Total</div><div class="col-6 col-sm-6 text-end fw-bold"><span>Rp</span><span>${_input.rupiah(total.toString())}</span></div></div></div>`);
        })
    });
</script>
@endpush
