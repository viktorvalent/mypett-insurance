<section id="faq" class="faq">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="content px-xl-5">
                    <h3>Frequently Asked <strong>Questions</strong></h3>
                    <p>

Kami telah menjawab 5 pertanyaan paling umum tentang asuransi hewan peliharaan dan menyertakan beberapa sumber berguna untuk membantu Anda membuat keputusan paling tepat untuk hewan peliharaan Anda.
                    </p>
                </div>
            </div>

            <div class="col-lg-8">
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
                    </div><!-- # Faq item-->
                @php($num++)
                @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
