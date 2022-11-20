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
		<section class="content">
			<div class="container-fluid">

				<div class="row">

					<div class="col-lg-4 col-4">
						<div class="small-box bg-info">
							<div class="inner">
								<h3>{{ $jumlah_pending }}</h3>
								<p>Pending</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-4">
						<div class="small-box bg-success">
							<div class="inner">
								<h3>{{ $jumlah_checkin }}</h3>
								<p>Checkin</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-4">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3>{{ $jumlah_checkout }}</h3>
								<p>Checkout</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
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
		<!-- /.content -->
	@endsection

	@section('script')
		<script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ url('js/jquery-3.5.1.js') }}"></script>
		<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
		<script>
			$(document).ready(function() {
				$('#example').DataTable({
					order: [
						[0, 'desc']
					],
				});
			});
		</script>
	@endsection
