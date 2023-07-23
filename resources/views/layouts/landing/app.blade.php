<!DOCTYPE html>
<html lang="en">
@php(date_default_timezone_set('Asia/Jakarta'))
<head>
    <base href="{{ url('../') }}">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title }} | Mypett Insurance</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('landing') }}/img/mypet-logo.png" rel="icon">
    <link href="{{ asset('landing') }}/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('landing') }}/css/main.css" rel="stylesheet">
    @stack('css')
</head>

<body>
    <section id="topbar" class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
        </div>
        </div>
    </section>

    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('landing') }}/img/mypet-logo.png" alt="">
                <h1 style="font-family: 'Fredoka One', cursive;">MYPETT<span>.</span></h1>
            </a>
            @include('layouts.landing.navbar')
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        </div>
    </header>
    @yield('hero')
    <main id="main">
        @yield('content')
        {{-- <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
            <h2>About Us</h2>
            <p>Aperiam dolorum et et wuia molestias qui eveniet numquam nihil porro incidunt dolores placeat sunt id nobis omnis tiledo stran delop</p>
            </div>

            <div class="row gy-4">
            <div class="col-lg-6">
                <h3>Voluptatem dignissimos provident quasi corporis</h3>
                <img src="{{ asset('landing') }}/img/about.jpg" class="img-fluid rounded-4 mb-4" alt="">
                <p>Ut fugiat ut sunt quia veniam. Voluptate perferendis perspiciatis quod nisi et. Placeat debitis quia recusandae odit et consequatur voluptatem. Dignissimos pariatur consectetur fugiat voluptas ea.</p>
                <p>Temporibus nihil enim deserunt sed ea. Provident sit expedita aut cupiditate nihil vitae quo officia vel. Blanditiis eligendi possimus et in cum. Quidem eos ut sint rem veniam qui. Ut ut repellendus nobis tempore doloribus debitis explicabo similique sit. Accusantium sed ut omnis beatae neque deleniti repellendus.</p>
            </div>
            <div class="col-lg-6">
                <div class="content ps-0 ps-lg-5">
                <p class="fst-italic">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                    magna aliqua.
                </p>
                <ul>
                    <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                    <li><i class="bi bi-check-circle-fill"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                    <li><i class="bi bi-check-circle-fill"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                </ul>
                <p>
                    Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                    velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident
                </p>

                <div class="position-relative mt-4">
                    <img src="{{ asset('landing') }}/img/about-2.jpg" class="img-fluid rounded-4" alt="">
                    <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                </div>
                </div>
            </div>
            </div>

        </div>
        </section> --}}

        {{-- <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-header">
            <h2>Contact</h2>
            <p>Nulla dolorum nulla nesciunt rerum facere sed ut inventore quam porro nihil id ratione ea sunt quis dolorem dolore earum</p>
            </div>

            <div class="row gx-lg-0 gy-4">

            <div class="col-lg-4">

                <div class="info-container d-flex flex-column align-items-center justify-content-center">
                <div class="info-item d-flex">
                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                    <h4>Location:</h4>
                    <p>A108 Adam Street, New York, NY 535022</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                    <i class="bi bi-envelope flex-shrink-0"></i>
                    <div>
                    <h4>Email:</h4>
                    <p>info@example.com</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                    <i class="bi bi-phone flex-shrink-0"></i>
                    <div>
                    <h4>Call:</h4>
                    <p>+1 5589 55488 55</p>
                    </div>
                </div><!-- End Info Item -->

                <div class="info-item d-flex">
                    <i class="bi bi-clock flex-shrink-0"></i>
                    <div>
                    <h4>Open Hours:</h4>
                    <p>Mon-Sat: 11AM - 23PM</p>
                    </div>
                </div><!-- End Info Item -->
                </div>

            </div>

            <div class="col-lg-8">
                <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <div class="row">
                    <div class="col-md-6 form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group mt-3">
                    <textarea class="form-control" name="message" rows="7" placeholder="Message" required></textarea>
                </div>
                <div class="my-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit">Send Message</button></div>
                </form>
            </div><!-- End Contact Form -->

            </div>

        </div>
        </section> --}}
    </main>

    @include('layouts.landing.footer')

    <a id="top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>
    <script src="{{ asset('landing') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landing') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('landing') }}/vendor/glightbox/js/glightbox.min.js"></script>
    {{-- <script src="{{ asset('landing') }}/vendor/purecounter/purecounter_vanilla.js"></script> --}}
    <script src="{{ asset('landing') }}/vendor/swiper/swiper-bundle.min.js"></script>
    {{-- <script src="{{ asset('landing') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script> --}}
    {{-- <script src="{{ asset('landing') }}/vendor/php-email-form/validate.js"></script> --}}
    <script src="{{ asset('landing') }}/js/main.js"></script>
    @stack('js')
    <script>
        document.getElementById("top").addEventListener("click",()=>{window.scrollTo(0, 0)})
    </script>
</body>

</html>
