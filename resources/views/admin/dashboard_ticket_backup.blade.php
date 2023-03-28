@extends('admin.layouts.app')

<link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css') }}">
@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<nav class="main-header navbar navbar-expand navbar-white navbar-light p-0 m-0 border-0 mb-4"
			style="margin-left: 0px !important;">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto p-4">
				<!-- Navbar Search -->

				<!-- Messages Dropdown Menu -->
				<!-- Notifications Dropdown Menu -->
				<li class="nav-item dropdown nav-user" data-toggle="dropdown">
					<a class="align-content-center align-items-center d-flex justify-content-center nav-link p-0" href="#">
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
					</a>
					{{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
						<span class="dropdown-item dropdown-header">15 Notifications</span>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-envelope mr-2"></i> 4 new messages
							<span class="float-right text-muted text-sm">3 mins</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-users mr-2"></i> 8 friend requests
							<span class="float-right text-muted text-sm">12 hours</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<i class="fas fa-file mr-2"></i> 3 new reports
							<span class="float-right text-muted text-sm">2 days</span>
						</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
					</div> --}}
				</li>
			</ul>

		</nav>
		<!-- Main content -->
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
