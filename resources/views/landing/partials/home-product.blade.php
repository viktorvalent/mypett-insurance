<section id="pricing" class="pricing sections-bg">
    <div class="container" data-aos="fade-up">

        <div class="section-header">
        <h2>Pricing</h2>
        <p>Kami menawarkan beberapa paket produk asuransi seperti dibawah ini :</p>
        </div>

        <div class="row g-4 py-lg-5" data-aos="zoom-out" data-aos-delay="100">

        @foreach ($packages as $item)
            <div class="col-lg-4">
                <div class="pricing-item">
                <h3>{{ $item->nama }}</h3>
                <div class="icon">
                    {!! $item->icon !!}
                </div>
                <h4 class="fs-4"><sup class="fs-6">IDR</sup> {{ number_format($item->harga,0,'','.') }}<span> / bulan</span></h4>
                <ul style="font-size: .8em;">
                    <li><i class="bi bi-check"></i> Kamar  {{ $item->produk_asuransi->kelas_kamar }}</li>
                    <li><i class="bi bi-check"></i> Limit Kamar Hingga Rp. {{ number_format($item->produk_asuransi->limit_kamar,0,'','.') }}</li>
                    <li><i class="bi bi-check"></i> Limit Obat Hingga Rp. {{ number_format($item->produk_asuransi->limit_obat,0,'','.') }}</li>
                    <li><i class="bi bi-check"></i> Nilai Pertanggunan</li>
                    <li><i class="bi bi-check"></i> Dan Beberapa Santunan</li>
                </ul>
                <div class="text-center"><a href="{{ route('home.package') }}" class="buy-btn">Buy Now</a></div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    </section>
