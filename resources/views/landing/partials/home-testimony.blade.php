@if (!$testimonials->isEmpty())
<section id="testimonials" class="testimonials">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
            <h2>Testimonials</h2>
            <p>Beberapa testimoni dari member yang menggunakan Mypett Asuransi.</p>
            </div>

            <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
            @forelse ($testimonials as $data)
                <div class="swiper-slide">
                    <div class="testimonial-wrap">
                        <div class="testimonial-item">
                        <div class="d-flex align-items-center">
                            @if ($data->foto!=null)
                                <img src="{{ asset(Storage::url($data->foto)) }}" class="testimonial-img flex-shrink-0" alt="">
                            @else
                                <img src="{{ asset('img/avatar.png') }}" class="testimonial-img flex-shrink-0" alt="">
                            @endif
                            <div>
                                <h3>{{ $data->nama }}</h3>
                                <h4>{{ $data->pekerjaan }}</h4>
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                        <p>
                            <i class="bi bi-quote quote-icon-left"></i>
                            {{ $data->testi_text }}
                            <i class="bi bi-quote quote-icon-right"></i>
                        </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center mt-3">
                    <p class="bg-light d-inline p-3 rounded fst-italic">
                        Testimoni belum tersedia.
                    </p>
                </div>
            @endforelse

                {{-- <div class="swiper-slide">
                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('landing/') }}/img/testimonials/testimonials-2.jpg" class="testimonial-img flex-shrink-0" alt="">
                        <div>
                        <h3>Sara Wilsson</h3>
                        <h4>Designer</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                        <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    </div>
                </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('landing/') }}/img/testimonials/testimonials-3.jpg" class="testimonial-img flex-shrink-0" alt="">
                        <div>
                        <h3>Jena Karlis</h3>
                        <h4>Store Owner</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                        <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    </div>
                </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('landing/') }}/img/testimonials/testimonials-4.jpg" class="testimonial-img flex-shrink-0" alt="">
                        <div>
                        <h3>Matt Brandon</h3>
                        <h4>Freelancer</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore.
                        <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    </div>
                </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                <div class="testimonial-wrap">
                    <div class="testimonial-item">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('landing/') }}/img/testimonials/testimonials-5.jpg" class="testimonial-img flex-shrink-0" alt="">
                        <div>
                        <h3>John Larson</h3>
                        <h4>Entrepreneur</h4>
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        </div>
                    </div>
                    <p>
                        <i class="bi bi-quote quote-icon-left"></i>
                        Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore.
                        <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                    </div>
                </div>
                </div><!-- End testimonial item --> --}}

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
