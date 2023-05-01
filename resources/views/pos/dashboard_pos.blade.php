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
				<h1>Report POS</h1>
				<span>Laporan dashboard data pengunjung</span>
			</div>
			<div class="col-lg-6 col-sm-12 d-flex justify-content-end">
				<a href="javascript:history.back()" class="back">Back</a>
				@include('partials.user_dropdown')
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<div class="mt-4 row">
					<div class="col-sm-12">
						<table id="example" class="display" style="width:100%">
							<thead>
								<tr>
									<th>Undian</th>
									<th>Name</th>
									<th>Email</th>
									<th>Category</th>
									<th>Barcode No</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($pos as $key => $value)
									<tr>
										<th>{{ $value->undian }}</th>
										<th>{{ $value->name }}</th>
										<th>{{ $value->email }}</th>
										<th>{{ $value->category }}</th>
										<th>{{ $value->barcode_no }}</th>
										<th><a href="{{ route('pos.cetak', ['id' => $value->id]) }}" target="_blank" class="btn btn-success">Cetak</a>
										</th>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</section>
	</div>
	<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



	<script src="{{ url('js/jquery.dataTables.min.js') }}"></script>

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
