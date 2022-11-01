@extends('admin.layouts.app')

@section('content')
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1>Event</h1>
					</div>
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Event</li>
						</ol>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Event</h3>
							</div>
							<!-- /.card-header -->
							<div class="card-body">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Rendering engine</th>
											<th>Browser</th>
											<th>CSS grade</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($events as $key => $value)
											<tr>
												<td>{{ $key + 1 + ($events->currentPage() - 1) * $events->perPage() }}</td>
												<td>{{ $value->name }}</td>
												<td>

													<div class="btn-group dropdown">
														<button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown"
															type="button">Action <i class="dropdown-caret"></i>
														</button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="">Edit</a></li>
														</ul>
													</div>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
							<!-- /.card-body -->
						</div>
						<!-- /.card -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	@endsection

	@section('script')
		<script></script>
	@endsection
