<!DOCTYPE html>
<html lang="en">
@php(date_default_timezone_set('Asia/Jakarta'))
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="mypett asuransi">
	<meta name="author" content="mypett">
	<meta name="keywords" content="mypett">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('dashboard/img/icons/icon-48x48.png') }}" />
	<link rel="canonical" href="https://asuransi-hewan.test/" />
	<title>{{ $title }} | MYPETT ADMIN</title>
	<link href="{{ asset('dashboard/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('dashboard/css/light.css') }}" rel="stylesheet">
	@stack('css')
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body::-webkit-scrollbar{display:none;}
        body{-ms-overflow-style:none;scrollbar-width:none;}
    </style>
</head>

<body>
	<div class="wrapper">
        @include('layouts.dashboard.sidebar')
		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="d-flex align-items-center fs-4 fw-bold ms-2">
                    @yield('title')
                </div>
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                                <img src="{{ asset('img/avatar.png') }}" class="avatar img-fluid rounded-circle rounded me-1" alt="Charles Hall" /> <span class="text-dark">{{ auth()->user()->username }}</span>
                            </a>
							<div class="dropdown-menu dropdown-menu-end mt-3">
								<a class="dropdown-item" href="{{ route('auth.profile') }}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item text-danger" href="{{ route('sign-out.admin') }}"><i class="align-middle me-1" data-feather="log-out"></i> Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<main class="content">
				<div class="container-fluid p-0">
                    @yield('container')
				</div>
			</main>
			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="javascript:void();"><strong>Mypett 2023</strong></a>&copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="{{ asset('dashboard/js/app.js') }}"></script>
	@stack('js')
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
</body>
</html>
