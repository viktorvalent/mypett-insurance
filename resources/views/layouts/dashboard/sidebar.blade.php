<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('auth.dashboard') }}">
            <span class="sidebar-brand-text align-middle">
                <img src="{{ asset('img/polis/logo.png') }}" class="me-2" width="50" alt="">
                MYPETT
            </span>
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                <path d="M20 12L12 16L4 12"></path>
                <path d="M20 16L12 20L4 16"></path>
            </svg>
        </a>
        <ul class="sidebar-nav">

            <li class="sidebar-header">
                Navigasi
            </li>

            <li class="sidebar-item {{ $title=='Dashboard'?'active':'' }}{{ $title=='Profile'?'active':'' }}">
                <a class="sidebar-link" href="{{ route('auth.dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ $title=='Pembelian Asuransi Member'?'active':'' }}{{ $title=='Detail Pembelian Asuransi Member'?'active':'' }}">
                <a class="sidebar-link" href="{{ route('pembelian') }}">
                    <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Pembelian</span>
                </a>
            </li>

            <li class="sidebar-item {{ $title=='Polis Asuransi Member'?'active':'' }}{{ $title=='Polis Preview'?'active':'' }}">
                <a class="sidebar-link" href="{{ route('polis') }}">
                    <i class="align-middle" data-feather="file-text"></i> <span class="align-middle">Polis</span>
                </a>
            </li>

            <li class="sidebar-item {{ $title=='Klaim Asuransi Member'?'active':'' }}{{ $title=='Detail Klaim Asuransi Member'?'active':'' }}">
                <a class="sidebar-link" href="{{ route('klaim') }}">
                    <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Klaim</span>
                </a>
            </li>

            <li class="sidebar-item {{ $title=='Master Bank'?'active':'' }}{{ $title=='Petshop Terdekat'?'active':'' }}{{ $title=='Master Provinsi'?'active':'' }}{{ $title=='Master Kabupaten/Kota'?'active':'' }}{{ $title=='Master Jenis Hewan'?'active':'' }}{{ $title=='Master Ras Hewan'?'active':'' }}{{ $title=='Produk Asuransi'?'active':'' }}{{ $title=='Tambah Produk Asuransi'?'active':'' }}{{ $title=='Master Nomor Rekening'?'active':'' }}">
                <a data-bs-target="#dashboards" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Master Data</span>
                </a>
                <ul id="dashboards" class="sidebar-dropdown list-unstyled collapse {{ $title=='Master Bank'?'show':'' }}{{ $title=='Petshop Terdekat'?'show':'' }}{{ $title=='Master Kabupaten/Kota'?'show':'' }}{{ $title=='Master Provinsi'?'show':'' }}{{ $title=='Master Jenis Hewan'?'show':'' }}{{ $title=='Master Ras Hewan'?'show':'' }}{{ $title=='Produk Asuransi'?'show':'' }}{{ $title=='Tambah Produk Asuransi'?'show':'' }}{{ $title=='Master Nomor Rekening'?'show':'' }}"
                    data-bs-parent="#sidebar" style="">
                    <li class="sidebar-item">
                        <a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">Bank Payment</a>
                        <ul id="multi-2" class="sidebar-dropdown list-unstyled collapse {{ $title=='Master Bank'?'show':'' }}{{ $title=='Master Nomor Rekening'?'show':'' }}">
                            <li class="sidebar-item {{ $title=='Master Bank'?'active':'' }}">
                                <a class="sidebar-link" href="{{ route('master-data.bank') }}">Daftar Bank</a>
                            </li>
                            <li class="sidebar-item {{ $title=='Master Nomor Rekening'?'active':'' }}">
                                <a class="sidebar-link" href="{{ route('master-data.no-rek') }}">Nomor Rekening</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="sidebar-item"><a class="sidebar-link" href="dashboard-ecommerce.html">E-Commerce</a></li> --}}
                    <li class="sidebar-item {{ $title=='Master Jenis Hewan'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.jenis-hewan') }}">Jenis Hewan</a>
                    </li>

                    <li class="sidebar-item {{ $title=='Master Ras Hewan'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.ras-hewan') }}">Ras Hewan</a>
                    </li>

                    <li class="sidebar-item {{ $title=='Produk Asuransi'?'active':'' }}{{ $title=='Tambah Produk Asuransi'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.produk-asuransi') }}">Produk Asuransi</a>
                    </li>

                    <li class="sidebar-item {{ $title=='Master Provinsi'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.provinsi') }}">Provinsi</a>
                    </li>

                    <li class="sidebar-item {{ $title=='Master Kabupaten/Kota'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.kab-kota') }}">Kabupaten/Kota</a>
                    </li>

                    <li class="sidebar-item {{ $title=='Petshop Terdekat'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('master-data.petshop-terdekat') }}">Petshop Terdekat</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item {{ $title=='FAQ'?'active':'' }}{{ $title=='Testimoni'?'active':'' }}{{ $title=='Term & Conditions'?'active':'' }}{{ $title=='Tambah Term & Conditions'?'active':'' }}">
                <a data-bs-target="#webcontents" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                    <i class="align-middle" data-feather="monitor"></i> <span class="align-middle">Konten Web</span>
                </a>
                <ul id="webcontents" class="sidebar-dropdown list-unstyled collapse {{ $title=='FAQ'?'show':'' }}{{ $title=='Testimoni'?'show':'' }}{{ $title=='Term & Conditions'?'show':'' }}{{ $title=='Tambah Term & Conditions'?'show':'' }}" data-bs-parent="#sidebar" style="">
                    {{-- <li class="sidebar-item">
                        <a data-bs-target="#multi-2" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">Master Bank</a>
                        <ul id="multi-2" class="sidebar-dropdown list-unstyled collapse
                            {{ $title=='Master Bank'?'show':'' }}">
                            <li class="sidebar-item {{ $title=='Master Bank'?'active':'' }}">
                                <a class="sidebar-link" href="{{ route('master-data.bank') }}">Daftar Bank</a>
                            </li>
                            <li class="sidebar-item {{ $title=='Master Nomor Rekening'?'active':'' }}">
                                <a class="sidebar-link" href="{{ route('master-data.no-rek') }}">Nomor Rekening</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li class="sidebar-item"><a class="sidebar-link" href="dashboard-ecommerce.html">E-Commerce</a></li> --}}
                    {{-- <li class="sidebar-item {{ $title=='Hero'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('web-content.hero') }}">Hero</a>
                    </li> --}}
                    <li class="sidebar-item {{ $title=='Term & Conditions'?'active':'' }}{{ $title=='Tambah Term & Conditions'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('web-content.tnc') }}">Term & Conditions</a>
                    </li>
                    <li class="sidebar-item {{ $title=='FAQ'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('web-content.faq') }}">FAQ</a>
                    </li>
                    <li class="sidebar-item {{ $title=='Testimoni'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('web-content.testimoni') }}">Testimoni</a>
                    </li>
                    <li class="sidebar-item {{ $title=='Paket Konten'?'active':'' }}">
                        <a class="sidebar-link" href="{{ route('web-content.package-content') }}">Paket Konten</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item {{ $title=='Users'?'active':'' }}">
                <a href="#auth" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Manajemen User</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse {{ $title=='Users'?'show':'' }}" data-bs-parent="#sidebar">
                    <li class="sidebar-item {{ $title=='Users'?'active':'' }}"><a class="sidebar-link" href="{{ route('user.manage') }}">User</a></li>
                    {{-- <li class="sidebar-item"><a class="sidebar-link" href="pages-sign-in.html">Member</a></li> --}}
                </ul>
            </li>

        </ul>
    </div>
</nav>
