@extends('admin.layouts.app')

<link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css') }}">
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">

			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
		@if (!$request->event)
			<section class="content container h-100 d-flex align-items-center justify-content-center">
				<div class="row dashboard">
					<form action="">
						<div class="col-lg-12 col-12 mb-4">
							<select name="event" id="event" class="form-control" required>
								<option value="">Pilih Event</option>
								@foreach ($event as $key => $value)
									<option value="{{ $value->event }}" {{ $request->event == $value->event ? 'selected' : '' }}>{{ $value->event }}
									</option>
								@endforeach
							</select>
							<i class="fa fa-chevron-down"></i>
						</div>
						<div class="col-12 text-center">
							<button type="submit" class="button-search">Search</button>
						</div>
					</form>
				</div>
			</section>
		@else
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
				</div>
			</section>
		@endif
		<!-- /.content -->
	@endsection

	@section('script')
		<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ url('js/jquery-3.5.1.js') }}"></script>
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
				// $('#event').on('change', function(e) {
				// 	window.location = '{{ route('dashboard_ticket') }}?event=' + $(this).val()
				// })


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
	@endsection
