<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Event Bersama</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
		integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">


	<link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css') }}">
	<link rel="stylesheet" href="{{ url('css') }}/custom-admin.css">
</head>

<body>

	<div class="container">
		<div class="row mb-4 header">
			<div class="col-lg-6 col-sm-12 mb-3">
				<h1>Report</h1>
				<span>Laporan dashboard data pengunjung</span>
			</div>
			<div class="col-lg-6 col-sm-12 d-flex justify-content-end">
				<a href="javascript:history.back()" class="back">Back</a>
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
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="align-items-center col-lg-3 col-sm-12 d-flex justify-content-center wrapper-chart">
						<div id="chart">
						</div>
					</div>
					<div class="col-lg-9 col-sm-12">
						<div class="row">
							<div class="col-lg-4 col-sm-12">
								<div class="small-box bg-info justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-clipboard-list"></i>
									</div>
									<div class="inner text-center">
										<p>Pending</p>
										<h3>{{ $jumlah_pending }}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12">
								<div class="small-box bg-success justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-sign-in-alt"></i>
									</div>
									<div class="inner text-center">
										<p>Checkin</p>
										<h3>{{ $jumlah_checkin }}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-sm-12">
								<div class="small-box bg-warning justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-sign-out-alt"></i>
									</div>
									<div class="inner text-center">
										<p>Checkout</p>
										<h3>{{ $jumlah_checkout }}</h3>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-sm-12">
								<div class="box bg-danger ticket-not-valid">
									<div class="align-items-center d-flex inner justify-content-center text-center">
										<p class="m-0">Ticket Not Valid</p>
										<h3>{{ $ticket_not_valid }}</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mt-4 row">
					<div class="col-sm-12">
						<table id="example" class="display" style="width:100%">
							<thead>
								<tr>
									<th>Kategory</th>
									<th>Pending</th>
									<th>Checkin</th>
									<th>Checkout</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($kategory_aset as $key => $value)
									<tr>
										<th>{{ $key }}</th>
										<th>{{ isset($value['pending']) ? $value['pending'] : 0 }}</th>
										<th>{{ isset($value['checkin']) ? $value['checkin'] : 0 }}</th>
										<th>{{ isset($value['checkout']) ? $value['checkout'] : 0 }}</th>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-12 text-center">
						<a href="" class="btn btn-success">Export Excel</a>

					</div>
				</div>
			</div>
		</section>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
		integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
	</script>



	<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ url('js/apexcharts.js') }}"></script>

	<script>
		var options = {
			series: [{{ $jumlah_pending }}, {{ $jumlah_checkin }}, {{ $jumlah_checkout }}],
			chart: {
				type: 'pie',
			},
			dataLabels: {
				enabled: false
			},
			labels: ['Pending', 'Checkin', 'Checkout'],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}]
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();
	</script>
	<script>
		$(document).ready(function() {

			$('#example').DataTable({
				order: [
					[0, 'desc']
				],
				dom: 'Bfrtip',
				buttons: [
					'excel'
				]
			});
		});
	</script>
</body>

</html>
