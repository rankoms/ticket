<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.1
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">

<head>
	<base href="./">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
	<meta name="author" content="Łukasz Holeczek">
	<meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
	<title>Redeem Ticket</title>
	<link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="assets/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- Vendors styles-->
	<link rel="stylesheet" href="{{ url('css/simplebar.css') }}">
	<link rel="stylesheet" href="{{ url('css/simplebar2.css') }}">
	<!-- Main styles for this application-->
	<link href="{{ url('css/style.css') }}" rel="stylesheet">
	<!-- We use those styles to show code examples, you should remove them in your application.-->
	<link rel="stylesheet" href="{{ url('css/prism.css') }}">
	<link href="{{ url('css/examples.css') }}" rel="stylesheet">
</head>

<body>
	<div class="bg-light min-vh-100 d-flex flex-row align-items-center">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-8">
					<div class="card-group d-block d-md-flex row">
						<div class="card col-md-7 p-4 mb-0">
							<div class="card-body">
								<form method="POST" action="{{ route('login') }}">
									@csrf
									<h1>Login</h1>
									<p class="text-medium-emphasis">Sign In to your account</p>
									<div class="input-group mb-3">
										<span class="input-group-text">
											<svg class="icon">
												<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
											</svg>
										</span>
										<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
											value="{{ old('email') }}" required autocomplete="email" autofocus>

										@error('email')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="input-group mb-4">
										<span class="input-group-text">
											<svg class="icon">
												<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
											</svg>
										</span>
										<input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
											name="password" required autocomplete="current-password">

										@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
										@enderror
									</div>
									<div class="row">
										<div class="col-6">
											<button class="btn btn-primary px-4" type="submit">Login</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						@if (Route::has('register'))
							<div class="card col-md-5 text-white bg-primary py-5">
								<div class="card-body text-center">
									<div>
										<h2>Sign up</h2>
										<a class="btn btn-lg btn-outline-light mt-3" href="{{ route('register') }}">Register</a>
									</div>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="{{ url('js/coreui.bundle.min.js') }}"></script>
	<script src="{{ url('js/simplebar.min.js') }}"></script>
	<script></script>
</body>

</html>
