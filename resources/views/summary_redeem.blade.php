<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
		integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<title>Redeem Voucher Summary</title>
	<style>
		.background-belum {
			background-color: #e55353;
		}

		.background-sudah {
			background-color: #3399ff;
		}

		.summary-font-h1 {
			font-size: 126px;
		}
	</style>
</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col-sm-12 mb-3 mt-3">
				<h1 class="bd-title text-center">Summary Redeem Voucher</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="card background-sudah" style="width: 30rem;">
					<div class="card-body">
						<h1 class="card-text text-center summary-font-h1">{{ $jumlah_sudah }}</h1>
						<h3 class="card-title text-center">Sudah Redeem Voucher</h3>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card background-belum" style="width: 30rem;">
					<div class="card-body">
						<h1 class="card-title text-center summary-font-h1">{{ $jumlah_belum }}</h1>
						<h3 class="card-text text-center">Belum Redeem Voucher</h3>
						{{-- <p class="card-text"></p> --}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 mb-3 mt-3">
				<h1 class="bd-title text-center">List Kategory</h1>
			</div>
		</div>
		<div class="row">
			@foreach ($kategory_aset as $key => $value)
				<div class="col-sm-6">
					<div class="card mb-3" style="width: 30rem; ">
						<div class="card-body">
							<h2 class="card-title text-center">{{ $key }}</h2>
							<div class="card-body row text-center">
								<div class="col">
									<h3 class="fs-5 fw-semibold">{{ isset($value['sudah']) ? $value['sudah'] : 0 }}</h3>
									<div class="text-uppercase text-medium-emphasis small">Sudah Redeem</div>
								</div>
								<div class="vr"></div>
								<div class="col">
									<h3 class="fs-5 fw-semibold">{{ isset($value['belum']) ? $value['belum'] : 0 }}</h3>
									<div class="text-uppercase text-medium-emphasis small">Belum Redeem</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

	{{-- - count total yg udah redeem
- count yg udah redeem per kategori
- count total yang belum redeem
 --}}
	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
	</script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
				<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
					integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
				</script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
					integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
				</script>
				<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
					integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
				</script>
				-->
</body>

</html>
