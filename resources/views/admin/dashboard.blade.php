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

					<div class="col-lg-6 col-6">

						<div class="small-box bg-info">
							<div class="inner">
								<h3>{{ $jumlah_sudah }}</h3>
								<p>Redeem</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							{{-- 
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                --}}
						</div>
					</div>

					<div class="col-lg-6 col-6">
						<div class="small-box bg-danger">
							<div class="inner">
								<h3>{{ $jumlah_belum }}</h3>
								<p>Pending</p>
							</div>
							<div class="icon">
								<i class="ion ion-pie-graph"></i>
							</div>
							{{-- 
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                --}}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<table id="example" class="display" style="width:100%">
							<thead>
								<tr>
									<th>Category</th>
									<th>Redeem</th>
									<th>Pending</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($kategory_aset as $key => $value)
									<tr>
										<th>{{ $key }}</th>
										<th>{{ isset($value['sudah']) ? $value['sudah'] : 0 }}</th>
										<th>{{ isset($value['belum']) ? $value['belum'] : 0 }}</th>
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
