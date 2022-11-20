@extends('layouts.app_mobile')

@section('content')
	{{-- <link rel="stylesheet" href="{{url('css/custom-select.css')}}"> --}}
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
				<select class="custom-select" name="events" id="events">
					<option value="">Pilih Event</option>
					@foreach ($events as $key => $value)
						<option value="{{ $value->event }}">{{ $value->event }}</option>
					@endforeach
				</select>
				<select class="custom-select" name="section" id="section" required>
					<option value="">Pilih Section</option>
				</select>

				<select class="custom-select" name="gate" id="gate">
					<option value="">Pilih Gate</option>
					<option value="checkin">Checkin</option>
					<option value="checkout">Checkout</option>
				</select>
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
