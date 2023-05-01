<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Event Bersama</title>
	<link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="{{ url('css') }}/custom-admin.css">
</head>

<style>
</style>

<body>

	<div class="container">
		<div class="row mb-4 header">
			<div class="col-lg-6 col-sm-12">
				<h1>User</h1>
				<span>Change Password</span>
			</div>
			<div class="col-lg-6 col-sm-12 d-flex justify-content-end">
				@include('partials.user_dropdown')
			</div>
		</div>
		<div class="pb-4 d-flex align-items-center justify-content-center dashboard">
			<section class="">
				<div class="row dashboard">
					<form id="form-change-password">
						@csrf
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="password" id="password" placeholder="Masukan Password Baru" class="form-control">
							</div>
						</div>
						<div class="col-12 text-center">
							<button type="submit" class="button-search">Submit</button>
						</div>
					</form>
				</div>
			</section>
		</div>
	</div>
	<script src="{{ asset('js/jquery.slim.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ url('mobile/js/jquery.min.js') }}"></script>
</body>

<script src="{{ url('js/sweetalert2@11.js') }}"></script>
<script>
	function getJSON(url, data, type = 'POST') {
		return JSON.parse($.ajax({
			type: type,
			url: url,
			data: data,
			dataType: 'json',
			global: false,
			async: false,
			success: function(msg) {

			}
		}).responseText);
	}

	function resetForm() {
		$('input').removeClass('invalid');
		$('select').removeClass('invalid');
		$('.invalid-feedback div').html('');
		$('textarea').val('');
		$('select').val('');
		$('input').val('');

	}

	$('#form-change-password').on('submit', function(e) {

		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: "{{ route('update_password') }}",
			method: 'POST',
			data: formData,
			global: false,
			async: false,
			dataType: 'json',
			beforeSend: function() {

			},
			success: function(response) {
				const meta = response.meta;
				resetForm();

				Swal.fire({
					title: meta.message,
					icon: 'success',
					showConfirmButton: true,
					confirmButtonText: 'OK',
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {

					} else if (result.isDenied) {}
				})
			},
			error: function(error) {

				const data = JSON.parse(error.responseText);

				if (data.errors) {
					var idx = 0;

					$.each(data.errors, function(key, value) {
						$('#' + key.split('.')[0]).addClass('invalid');
						$('#' + key.split('.')[0] + '_invalid-feedback').html(
							value
							.join(' '));

						if (idx == 0) {
							$('#' + key.split('.')[0]).focus();
						}

						idx++;
					});
				} else {
					Swal.fire(
						'Fail',
						error.responseJSON.message,
						'error'
					);
				}
			},
		});
	});
</script>

</html>
