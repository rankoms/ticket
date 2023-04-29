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
		<div class="content d-flex align-items-center justify-content-center dashboard">
			<section class="">
				<div class="row dashboard">
					<form action="">
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
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="text" name="name" id="name" placeholder="Masukan Nama" class="form-control">
							</div>
						</div>
						<div class="row mb-4">
							<div class="col-lg-12 col-12 position-relative">
								<input type="email" name="email" id="email" placeholder="Masukan Email" class="form-control">
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
</script>

</html>
