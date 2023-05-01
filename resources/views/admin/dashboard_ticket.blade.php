<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Event Bersama</title>
	<link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
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
				@include('partials.user_dropdown')
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="align-items-center col-lg-3 col-sm-12 d-flex justify-content-center wrapper-chart p-0">
						<div id="chart">
						</div>
					</div>
					<div class="col-lg-9 col-sm-12">
						<div class="row gx-1">
							<div class="col-lg-3 col-sm-12 pr-1">
								<div class="small-box bg-biru justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-clipboard-list"></i>
									</div>
									<div class="inner text-center">
										<p>Pending</p>
										<h3>{{ $jumlah_pending }}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-12 pl-2 pr-1">
								<div class="small-box bg-ijo text-center">
									<div class="inner text-center">
										<p>Ticket Scan</p>
										<h3>{{ $jumlah_checkin + $jumlah_checkout }}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-12 pl-2 pr-1">
								<div class="small-box bg-teal justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-sign-in-alt"></i>
									</div>
									<div class="inner text-center">
										<p>Check-in</p>
										<h3>{{ $jumlah_checkin }}</h3>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-sm-12 pl-2">
								<div class="small-box bg-kuning justify-content-between d-flex">
									<div class="icon">
										<i class="fa fa-sign-out-alt"></i>
									</div>
									<div class="inner text-center">
										<p>Check-out</p>
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
									<th>Check-in</th>
									<th>Check-out</th>
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
				<div class="row mt-4">
					<div class="col-12 text-center">
						<a href="{{ route('excel_ticket', ['event' => $request->event]) }}" class="btn btn-success">Export Excel</a>
					</div>
				</div>
			</div>
		</section>
	</div>
	<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



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
