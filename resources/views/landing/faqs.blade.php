@extends('layouts.landing.app')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="rounded my-3">
        <img src="{{ asset('img/faq-bg.jpg') }}" class="w-100 h-100 rounded" alt="">
    </div>
    <section id="faq" class="faq">
        <div class="container" data-aos="fade-up">
            <div class="row gy-4">
                <div class="col-lg-3">
                    <div class="content px-xl-5">
                        <h3>Frequently Asked <strong>Questions</strong></h3>
                        <p>
                            Kami telah menjawab pertanyaan paling umum tentang asuransi hewan peliharaan dan menyertakan beberapa sumber berguna untuk membantu Anda membuat keputusan paling tepat untuk hewan peliharaan Anda.
                        </p>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="accordion accordion-flush" id="faqlist" data-aos="fade-up" data-aos-delay="100">
                    @php($num=1)
                    @foreach ($faqs as $faq)
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-content-{{ $num }}">
                                <span class="num">{{ $num }}</span>
                                {{ $faq->pertanyaan }}
                            </button>
                            </h3>
                            <div id="faq-content-{{ $num }}" class="accordion-collapse collapse" data-bs-parent="#faqlist">
                            <div class="accordion-body">
                                {{ $faq->jawaban }}
                            </div>
                            </div>
                        </div>
                    @php($num++)
                    @endforeach
                    </div>
                    <div class="my-4 d-flex justify-content-center">
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('js')

@endpush
