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
	body {
		background: url('{{ asset('bg-pos.jpg') }}');
		background-repeat: round;
		height: 100%;
	}
</style>

<body>

	<div class="container">
		<div class="row mb-4 header">
			<div class="col-lg-6 col-sm-12">
				<h1>POS</h1>
				<span>Masukan data pengunjung</span>
			</div>
			<div class="col-lg-6 col-sm-12 d-flex justify-content-end">
				@include('partials.user_dropdown')
			</div>
		</div>
		<div class="pb-4 d-flex align-items-center justify-content-center dashboard">
			<section class="">
				<div class="row dashboard">
					<form id="form-pos">
						@csrf
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="name" id="name" placeholder="Masukan Nama" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-6 col-6 position-relative">
								<select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
									<option value="">Pilih Jenis Kelamin</option>
									<option value="Pria">Pria</option>
									<option value="Wanita">Wanita</option>
								</select>
								<i class="fa fa-chevron-down"></i>
							</div>
							<div class="col-lg-6 col-6 position-relative">
								<select name="golongan_darah" id="golongan_darah" class="form-control">
									<option value="">Pilih Golongan Darah</option>
									<option value="O">O</option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="AB">AB</option>
								</select>
								<i class="fa fa-chevron-down"></i>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="email" name="email" id="email" placeholder="Masukan Email" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="no_hp" id="no_hp" placeholder="Masukan No HP" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan Alamat"></textarea>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="club" id="club" placeholder="Masukan Asal Club" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="type_motor" id="type_motor" placeholder="Masukan Type Motor" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="no_start" id="no_start" placeholder="Masukan No Start" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<select name="event" id="event" class="form-control">
									<option value="">Pilih Event</option>
									@foreach ($event as $key => $value)
										<option value="{{ $value->event }}">
											{{ $value->event }}
										</option>
									@endforeach
								</select>
								<i class="fa fa-chevron-down"></i>
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<select name="category" id="category" class="form-control">
									<option value="">Pilih Category</option>
									@foreach ($event as $key => $value)
										<option value="{{ $value->event }}">
											{{ $value->event }}
										</option>
									@endforeach
								</select>
								<i class="fa fa-chevron-down"></i>
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
	$('#event').on('change', function(e) {
		var data = getJSON("{{ route('scanner.section_select') }}", {
			_token: '{{ csrf_token() }}',
			event: $(this).val()
		});
		$('#category').find('option').not(':first').remove();
		$.each(data.data['event_gate'], function(key, value) {
			$('#category').append(`
                <option value="${value['category']}">${value['category']}</option>
            `);
		});
	});

	function resetForm() {
		$('input').removeClass('invalid');
		$('select').removeClass('invalid');
		$('.invalid-feedback div').html('');
		$('textarea').val('');
		$('select').val('');
		$('input').val('');

	}

	$('#form-pos').on('submit', function(e) {

		e.preventDefault();
		var formData = $(this).serialize();
		$.ajax({
			url: "{{ route('pos.store') }}",
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
				$('#name').focus();

				Swal.fire({
					title: meta.message,
					icon: 'success',
					showDenyButton: true,
					confirmButtonText: 'OK',
					denyButtonText: `Cetak Ticket`,
					denyButtonColor: '#3085d6',
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {

					} else if (result.isDenied) {
						// Swal.fire('Changes are not saved', '', 'info')
						var url = "{{ route('pos.cetak', [':id']) }}";
						url = url.replace(':id', response.data.id);
						return window.location.href = url;
					}
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
