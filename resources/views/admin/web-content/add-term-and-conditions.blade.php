@extends('layouts.dashboard.app')

@section('title', 'Tambah '.$title)

@push('css')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
<script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
<style>
    button.trix-button.trix-button--icon.trix-button--icon-attach,
    span.trix-button-group.trix-button-group--file-tools {
        display: none !important;
        visibility: hidden !important;
    }
</style>
@endpush

@section('container')
<div class="row">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Isi term & condition pada input dibawah ini.</h5>
            <form>
                <input type="hidden" name="id" class="id" value="{{ $data->id }}">
                <input id="tnc" type="hidden" name="isi" class="isi" value="{{ $data->isi }}">
                <trix-editor input="tnc"></trix-editor>
                <div class="py-4">
                    <button type="submit" class="btn btn-primary create">
                        Kirim
                    </button>
                </div>
            </form>
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
        $(document).on('click','.create', function(e) {
            e.preventDefault();
            let data = {'isi':$('.isi').val(),'id':$('.id').val()}
            _input.loading.start(this);
            _ajax.post("{{ route('web-content.tnc.updateOrCreate') }}",data,
                (response)=>{
                    _input.loading.stop('.create','Kirim');
                    if (response.status == 200) {
                        _swalert(response);
                        setTimeout(() => {
                            location.href="{{ route('web-content.tnc') }}"
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
