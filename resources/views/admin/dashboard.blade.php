<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Event Bersama</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
		integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="{{ url('css') }}/custom-admin.css">
</head>

<body>

	<div class="container">
		<div class="row mb-4 header">
			<div class="col-lg-6 col-sm-12">
				<h1>Report</h1>
				<span>Laporan dashboard data pengunjung</span>
			</div>
			<div class="col-lg-6 col-sm-12 d-flex justify-content-end">
				<a class="profile align-content-center align-items-center d-flex justify-content-center nav-link position-relative"
					href="#">
					<div class="flex-shrink-0 me-3">
						<div class="avatar avatar-online">
							<img src="{{ asset('images/default-user.webp') }}" alt=""
								class="rounded-circle img-size-50 mr-3 img-circle">
						</div>
					</div>
					<div class="flex-grow-1">
						<span class="fw-semibold d-block lh-1">{{ Auth::user()->name }}</span>
						<small></small>
					</div>
					<i class="fa fa-chevron-down"></i>
				</a>
			</div>
		</div>
		<div class="content d-flex align-items-center justify-content-center dashboard">
			<section class="">
				<div class="row dashboard">
					<form action="">
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<select name="report" id="report" class="form-control" required>
									<option value="">Pilih Report</option>
									<option value="ticket">Ticket</option>
									{{-- <option value="redeem">Redeem</option> --}}
								</select>
								<i class="fa fa-chevron-down"></i>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<select name="event" id="event" class="form-control">
									<option value="">Pilih Event</option>
									@foreach ($event as $key => $value)
										<option value="{{ $value->event }}">
											{{ $value->event }}
										</option>
									@endforeach
								</select>
								<i class="fa fa-chevron-down"></i>
							</div>
						</div>
						<div class="col-12 text-center">
							<button type="submit" class="button-search">Search</button>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
	</script>
</body>

</html>
