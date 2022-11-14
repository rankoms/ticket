<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>E-Ticket</title>

	<!-- Google Font: Source Sans Pro -->
	{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ url('adminlte') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
	<div class="wrapper">

		@include('admin.layouts.navbar')

		@include('admin.layouts.sidebar')


		@yield('content')
	</div>
	<!-- /.content-wrapper -->
	<footer class="main-footer">
		<div class="float-right d-none d-sm-block">
			<b>Version</b> 3.1.0
		</div>
		<strong>Copyright &copy; E-ticket.</strong> All rights reserved.
	</footer>

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="{{ url('adminlte') }}/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="{{ url('adminlte') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- DataTables  & Plugins -->
	<script src="{{ url('adminlte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/jszip/jszip.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="{{ url('adminlte') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
	<!-- AdminLTE App -->
	<script src="{{ url('adminlte') }}/dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="{{ url('adminlte') }}/dist/js/demo.js"></script>
	<!-- Page specific script -->
	@yield('script')
	<script>
		$(function() {
			$("#example1").DataTable({
				"responsive": true,
				"lengthChange": false,
				"autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"responsive": true,
			});
		});
	</script>
</body>

</html>
