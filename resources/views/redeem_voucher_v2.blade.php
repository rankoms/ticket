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
	<style>
		.swal2-popup {
			font-size: 1.4rem !important;
			font-family: cursive !important;
		}

		.swal2-popup .btn,
		.swal2-popup .swal2-confirm {
			width: 100%;
		}

		.swal2-popup .swal2-success-circular-line-left,
		.swal2-popup .swal2-success-circular-line-right,
		.swal2-popup .swal2-success-fix {
			background-color: transparent !important;
		}

		body {
			width: 100%;
			height: 100%;
			background: url('../images/bg.png');
			center top no-repeat;
			background-size: cover;
			position: relative;
		}
	</style>
</head>

<!-- <body style="background-image:url('images/bg.png');"> -->

<form action="" id="form-voucher">
	<div class="min-vh-100 d-flex flex-row align-items-center">
		<div class="container">
			<div class="row justify-content-center opacity-100">
				<div class="col-md-6">
					<div class="card p-4">
						<div class="row">

						</div>
						<div class="clearfix">
							<!-- <img src="images/logosabang.png" class="img-fluid" alt=""> -->
							<h1 class="text-center">Scan E-Ticket</h1>
							<br>
						</div>
						<input class="form-control mb-3" id="voucher" name="voucher" size="16" type="text" placeholder=""
							autofocus autocomplete="off">
						<button class="btn btn-info" style="width:100%" type="submit" autofocus="false">Search</button>
					</div>
				</div>
			</div>
		</div>

		<a href="{{ route('user.logout') }}" class="btn btn-danger position-absolute"
			style="bottom: 10px; right:10px">Logout</a>
		<a href="{{ route('redeem_voucher.dashboard') }}" class="btn btn-info position-absolute"
			style="bottom: 10px; left:10px">Report</a>
	</div>
</form>
<!-- CoreUI and necessary plugins-->
<script src="{{ url('js/coreui.bundle.min.js') }}"></script>
<script src="{{ url('js/simplebar.min.js') }}"></script>
<script src="{{ url('js/sweetalert2@11.js') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/webcam.min.js') }}"></script>

<script>
	setInterval(() => {
		document.getElementById("voucher").focus();
	}, 500);

	$('#form-voucher').on('submit', function(e) {
		e.preventDefault();
		var data = getJSON("{{ route('redeem_voucher.cek_redeem_voucher') }}", {
			_token: '{{ csrf_token() }}',
			voucher: $('#voucher').val()
		});

		if (data.meta.code != 200) {
			Swal.fire(
				'Gagal',
				data.meta.message,
				'error'
			)
			Swal.fire({
				title: 'E-Ticket Tidak Terdaftar',
				text: data.meta.message,
				icon: 'error',
				showConfirmButton: false,
				showCloseButton: true,
				allowEscapeKey: true,
				background: 'rgba(255,255,255,0.4)',
				backdrop: `
					rgba(0,0,123,0.4)
					url("/images/bg3.png")
				`,
				color: '#000',
				showCloseButton: true,
			})

		} else {
			if (data.data.status == 1) {

				Swal.fire({
					title: data.data.name,
					icon: 'error',
					html: `<p>${data.data.email}</p>
								<p>${data.data.kategory}</p>
								<p>E-Ticket Sudah di Redeem Pada ${data.data.redeem_date}</p>
								<img src="{{ asset('storage/uploads') }}/${data.data.foto_ktp}">
								<button disabled class="btn btn-danger">E-Ticket Sudah Di Redeem</button>
						`,
					showCancelButton: false,
					showConfirmButton: false,
					allowEscapeKey: false,
					cancelButtonColor: '#d33',
					cancelButtonText: 'Ticket Sudah Di gunakan',
					showCloseButton: true,
					allowOutsideClick: true,
					background: 'rgba(255,255,255,0.4)',
					backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
					color: '#000'
				}).then((result) => {
					$('#voucher').val('');
					$('#voucher').focus();
					/* Read more about isConfirmed, isDenied below */
					// window.location = "{{ route('redeem_voucher.index') }}/" + $('#voucher').val()
				});
			} else {
				id = data.data.id;
				Swal.fire({
					title: data.data.name,
					showCloseButton: true,
					allowEscapeKey: true,
					icon: 'success',
					background: 'rgba(255,255,255,0.4)',
					backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg2.png")
					`,
					color: '#000',
					html: `<p>${data.data.email}</p>
								<p>${data.data.kategory}</p>
				<div class="d-flex">

				<button class="btn btn-primary m-sm-5" id="ambil-gambar">Ambil Gambar KTP</button>
				<button class="btn btn-danger m-sm-5" id="reset-gambar">Reset Gambar KTP</button>
				</div>
				<div id="my_camera" class="m-sm-auto"></div>
					<input type="hidden" name="image" class="image-tag" id="image-tag">
				<div class="pt-3">
					<label for="results">Hasil Gambar</label>
					<div id="results" class="mt-4">
				</div>
				</div>
					
					`,
					confirmButtonText: 'Tukarkan E-Ticket',
					preConfirm: () => {
						if ($('#image-tag').val() == '') {

							// alert('oke')
							return Swal.showValidationMessage(
								`Ambil Foto KTP Terlebih dahulu`
							)
						}
					},
				}).then((result) => {
					if (result.isConfirmed) {


						var data = getJSON("{{ route('redeem_voucher.redeem_voucher_update_v2') }}", {
							_token: '{{ csrf_token() }}',
							id: id,
							image: $('#image-tag').val()
						});

						Swal.fire({
							timer: 2000,
							icon: 'success',
							title: data.meta.message,
							showConfirmButton: false,
							background: 'rgba(255,255,255,0.4)',
							backdrop: `
							rgba(0,0,123,0.4)
							url("/images/bg2.png")
						`,
							color: '#000'
						})
					}
					$('#voucher').val('');
					$('#voucher').focus();
					$('#image-tag').val('');
				});
				Webcam.set({
					width: 490,
					height: 350,
					image_format: 'jpeg',
					jpeg_quality: 90
				});

				$('#ambil-gambar').on('click', function() {
					Webcam.snap(function(data_uri) {
						$("#image-tag").val(data_uri);
						document.getElementById('results').innerHTML = '<img src="' +
							data_uri + '"/>';
					});
				})

				$('#reset-gambar').on('click', function() {
					$('#image-tag').val('');
					$('#results').html('');
				})

				Webcam.attach('#my_camera');
			}
		}
		$('#voucher').focus();
		$('#voucher').val('');
		document.getElementById("voucher").focus();
	});
	document.getElementById("voucher").focus();

	$(".swal2-modal").css('background-color', '#000'); //Optional changes the color of the sweetalert 
	$(".swal2-container.in").css('background-color', 'rgba(43, 165, 137, 0.45)'); //changes the color of the overlay
	function getJSON(url, data, type = 'POST') {
		return JSON.parse($.ajax({
			type: type,
			url: url,
			data: data,
			dataType: 'json',
			global: false,
			async: false,
			success: function(msg) {

			}
		}).responseText);
	}
</script>

</body>

</html>
