<nav id="navbar" class="navbar">
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
                <li><a href="{{ route('home.package') }}">Package</a></li>
                <li><a href="{{ route('home.calculator') }}">Calculator</a></li>
                <li><a href="{{ route('member.nearest-petshop') }}">Nearest Petshop</a></li>
            </ul>
        </li>
        <li><a href="{{ route('home.about') }}">About</a></li>
        <li><a href="{{ route('home.contact') }}">Contact</a></li>
        <li class="dropdown"><a href="javascript:void(0);"><span>
            @guest
                <i class="bi bi-person fs-5"></i>
            @endguest
            @auth
                @can('is_member')
                    <i class="bi bi-person-fill fs-5"></i>
                @endcan
            @endauth
            </span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
                @guest
                    <li><a href="{{ route('sign-in.member') }}">Masuk/Register</a></li>
                @endguest
                @auth
                    @can('is_member')
                        <li><a href="{{ route('member.dashboard') }}">Profile</a></li>
                        <li><a href="{{ route('member.cart') }}">My Cart</a></li>
                        <li><a href="{{ route('member.my-insurance') }}">My Insurance</a></li>
                        <li><a href="{{ route('member.claim') }}">My Claim</a></li>
                        {{-- <li><a href="{{ route('member.nearest-petshop') }}">Nearest Petshop</a></li> --}}
                        {{-- <li><a href="{{ route('member.log') }}">Activity Log</a></li> --}}
                        <hr class="py-0 my-0">
                        <li><a href="{{ route('sign-out.member') }}">Sign Out</a></li>
                    @endcan
                @endauth
            </ul>
        </li>
    </ul>
</nav>
