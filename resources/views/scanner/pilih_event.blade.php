@extends('layouts.app_mobile')

@section('content')
	{{-- <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"
		type='text/css'> --}}
	<style>
		body main .content {
			padding-bottom: 100px;
			padding-top: 116px;
			padding-right: 20%;
			padding-left: 20%;
		}

		.form-floating {
			position: relative;
			margin-bottom: 20px;
		}

		.form-floating select {

			height: 60px;
			padding-top: 20px;
		}

		.form-floating label {

			position: absolute;
			top: 7px;
			color: gray;
			left: 13px;
		}

		.wrapper-radio {
			padding-left: 0;
			border: 1px solid #d4d8dd;
			border-radius: 0.25rem;
			display: block;
			min-height: 1.378125rem;
			margin-bottom: 0.125rem;
		}

		.active {
			background-color: orange;
		}

		.wrapper-radio label {
			padding: 1em;
		}

		.me-10 {
			margin-right: 10px;
		}

		.wrapper-radio input[type=radio] {
			position: absolute;
			opacity: 0;
		}
	</style>
	<main>
		<div class="header">
			<a href="javascript:history.back()">
				<img src="{{ url('images/mobile/caret-back.svg') }}" width="4.5px" height="9px" alt="Back">
				Back
			</a>

			<span>Pilih Event dan Category</span>
		</div>
		<form action="{{ route('scanner.store_pilih_event') }}" method="GET">
			<div class="content">
				<div class="wrapping-input form-floating">
					<select class="form-control" name="events" id="events">
						<option value="">Pilih Event</option>
						@foreach ($events as $key => $value)
							<option value="{{ $value->event }}">{{ $value->event }}</option>
						@endforeach
					</select>
					<label for="events">Event</label>
				</div>
				<div class="wrapping-input form-floating">
					<select class="form-control" name="section" id="section" required>
						<option value="">Pilih Section</option>
					</select>
					<label for="events">Kategory</label>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="wrapper-radio" id="wrapper-checkin">
							<label for="checkin">
								<input type="radio" name="gate" value="checkin" id="checkin">
								<i class="fa fa-sign-in me-10"></i>
								<span>checkin</span>
							</label>
						</div>
					</div>
					<div class="col-6">
						<div class="wrapper-radio" id="wrapper-checkout">
							<label for="checkout">
								<input type="radio" name="gate" value="checkout" id="checkout">
								<i class="fa fa-sign-out me-10"></i>
								<span>checkout</span>
							</label>
						</div>
					</div>
				</div>

			</div>
			<div class="container-btn-manual">
				<button type="submit" class="btn-manual">Pilih Scanner</button>
			</div>
		</form>
	</main>
@endsection

@section('script')
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

		$('input[type=radio]').on('change', function() {
			// alert($(this).val());
			if ($(this).val() == 'checkin') {
				$('#wrapper-checkin').addClass('active');
				$('#wrapper-checkout').removeClass('active');
			} else {
				$('#wrapper-checkout').addClass('active');
				$('#wrapper-checkin').removeClass('active');
			}
		})
		$('#events').on('change', function(e) {
			var data = getJSON("{{ route('scanner.section_select') }}", {
				_token: '{{ csrf_token() }}',
				event: $(this).val()
			});
			$('#section').find('option').not(':first').remove();
			$.each(data.data['event_gate'], function(key, value) {
				$('#section').append(`
                <option value="${value['category']}">${value['category']}</option>
            `);
			});
		});

		$('#section').on('change', function(e) {
			var data = getJSON("{{ route('scanner.section_selected') }}", {
				_token: '{{ csrf_token() }}',
				type: $(this).val(),
				id: $('#events').val()
			})
		});


		function pop_up_detail() {
			$('#ticket').focus();
			setTimeout(function() {
				bgModalAdd()
			}, 400);
			$('#PopupDetail').animate({
				bottom: 0
			});
			$('#PopupDetail').css('max-height', maxModalHeight(40))
			$("body").css("overflow", "hidden");
		}

		function gagal_pilih_event(scan = false) {
			let text = 'Pilih Event terlebih dahulu';
			if (scan) {
				return alert(text)
			}
			return Swal.fire(
				'Gagal',
				text,
				'error'
			)
		}

		function gagal_pilih_section(scan = false) {
			let text = 'Pilih Section terlebih dahulu';
			if (scan) {
				return alert(text)
			}
			return Swal.fire(
				'Gagal',
				text,
				'error'
			)
		}

		function gagal_pilih_gate(scan = false) {
			let text = 'Pilih Gate terlebih dahulu';
			if (scan) {
				return alert(text)
			}
			return Swal.fire(
				'Gagal',
				text,
				'error'
			)
		}

		function close_detail() {
			$('#PopupDetail').animate({
				bottom: -$('#PopupDetail').height()
			}, 350, function() {
				$('#PopupDetail').css('bottom', 'unset')
			});
			bgModalRemove()
			$("body").css("overflow", "inherit");
		}
	</script>
@endsection
