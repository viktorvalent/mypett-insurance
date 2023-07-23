<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{ asset('dashboard') }}/img/icons/icon-48x48.png" />
	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />
	<title>Sign In | Dashboard Admin</title>
	<link href="{{ asset('dashboard/css/app.css') }}" rel="stylesheet">
    <link class="js-stylesheet" href="{{ asset('dashboard/css/light.css') }}" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('dashboard/img/login-banner.jpg') }}" as="image"/>
    <style>
        body {
            background-image: url('{{ asset('dashboard/img/login-banner.jpg') }}');
            background-position: left;
            background-repeat: no-repeat;
            background-size: cover;
            min-height: 100vh;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        body::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">
						<div class="card shadow-lg">
							<div class="card-body">
								<div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="{{ asset('img/polis/logo.png') }}" width="150" alt="">
                                        <p class="lead mt-3">
                                            Sign in to Admin Dashboard
                                        </p>
                                    </div>
                                    <div class="invalid_message"></div>
									<form method="POST">
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="Enter your email" required/>
                                            <small class="invalid-feedback text-danger email_error"></small>
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Enter your password" required/>
                                            <small class="invalid-feedback text-danger password_error"></small>
                                        </div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary sign" style="width: 125px;">Sign in</button>
										</div>
                                        <div class="text-end">
                                            <a class="text-end" href="{{ route('forget.password.get') }}">Forgot password?</a>
                                        </div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="{{ asset('dashboard/js/app.js') }}"></script>
    <script src="{{ asset('dashboard/libs/jquery/app.js') }}"></script>
    <script src="{{ asset('dashboard/libs/sweetalert/app.js') }}"></script>
    <script src="{{ asset('dashboard/js/support.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('.sign').click(function (e) {
                e.preventDefault();
                let data = {
                    'email': $('#email').val(),
                    'password': $('#password').val()
                };
                _input.loading.start(this);
                _ajax.post("{{ route('authenticating.admin') }}",data,
                    (response) => {
                        _input.loading.stop('.sign','Sign In');
                        if (response.status == 200) {
                            window.location.href = "{{ route('auth.dashboard') }}";
                        }
                    },
                    (response) => {
                        _input.loading.stop('.sign','Sign In');
                        if (response.status == 400) {
                            _validation.action(response.responseJSON)
                        } else if (response.status == 422) {
                            $('.invalid_message').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <div class="alert-message">
                                            ${response.responseJSON.message}
                                        </div>
                                    </div>`)
                        } else {
                            _swalert(response);
                        }
                    }
                );
            });
        });
    </script>
</body>
</html>
