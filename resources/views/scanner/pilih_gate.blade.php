@extends('layouts.app_mobile')

@section('content')
	{{-- <link rel="stylesheet" href="{{url('css/custom-select.css')}}"> --}}
	<main>
		<div class="header">
			<a href="javascript:history.back()">
				<img src="{{ url('images/mobile/caret-back.svg') }}" width="4.5px" height="9px" alt="Back">
				Back
			</a>

			<span>Checkin Ticket</span>
		</div>
		<div class="content">
			<select class="custom-select" name="events" id="events">
				<option value="{{ $events->id }}">{{ $events->name }}</option>
			</select>
			<select class="custom-select" name="section" id="section">
				<option value="">Pilih Section</option>
				@foreach ($gate as $key => $value)
					<option value="{{ $value->id }}">{{ $value->name }}</option>
				@endforeach
			</select>

			<select class="custom-select" name="gate" id="gate">
				<option value="">Pilih Gate</option>
				<option value="checkin">Checkin</option>
				<option value="checkout">Checkout</option>
			</select>
		</div>
		<div class="container-btn-manual" style="display: none">
			<button class="btn-manual">Input Manual</button>
		</div>
		<div class="popupMedium">
			<div class="footer-container">
				<div id="PopupDetail" class="container-popup ">
					<div class="wrapper-title">
						<div class="labelPopup">
							Checkin Ticket
						</div>
						<div class="boxClose">
							<img src="{{ url('images/mobile/icons/close.svg') }}" alt="close" width="24px" height="24px"
								class="close-detail">
						</div>
					</div>
					<div class="wrapper-popup" style="padding-bottom: 60px;">
						<div class="content-detail">
							<div class="container-detail">
								<form role="form" method="POST" id="form-submit" action="">
									@csrf
									<div class="content-auth penerimaan-barang pt-0">
										@if ($message = Session::get('success'))
											<div class="alert alert-success alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>{{ $message }}</strong>
											</div>
										@endif
										@if ($message = Session::get('error'))
											<div class="alert alert-danger alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>{{ $message }}</strong>
											</div>
										@endif
										<div class="row-control-auth">
											<label for="ticket">No Ticket <span>*</span></label>
											<input type="text" name="ticket" id="ticket" value="{{ old('ticket') ? old('ticket') : '' }}"
												class="ticket {{ $errors->has('ticket') ? ' is-invalid' : '' }}">
										</div>
										<div class="row-control-auth">
											<button type="submit" class="btn-submit">
												Cari
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection

@section('script')
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://unpkg.com/html5-qrcode"></script>
	<script>
		var scan = 0;


		function onScanSuccess(decodedText, decodedResult) {
			if (scan == 0) {
				if (!$('#events').val()) {
					return gagal_pilih_event('scan');
				}
				if (!$('#section').val()) {
					return gagal_pilih_section('scan');
				}
				if (!$('#gate').val()) {
					return gagal_pilih_gate('scan');
				}
				var data = getJSON("{{ \config('scanner.base_url') . \config('scanner.checkin') }}", {
					'barcode_no': decodedText,
					'ticket_type': $('#section').val(),
					'gate': $('#gate').val()
				});
				if (data.meta.code != 200) {
					alert(data.meta.message);
				} else {
					$('#jumlah_checkin').html(data.data['checkin'])
					$('#jumlah_pending').html(data.data['pending'])
				}
			}
		}

		function onScanFailure(error) {
			// handle scan failure, usually better to ignore and keep scanning.
			// for example:
			// console.warn(`Code scan error = ${error}`);
		}

		let html5QrcodeScanner = new Html5QrcodeScanner(
			"reader", {
				fps: 10,
				qrbox: {
					width: 250,
					height: 250
				}
			},
			/* verbose= */
			false);
		html5QrcodeScanner.render(onScanSuccess, onScanFailure);

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
				id: $(this).val()
			});
			$('#jumlah_checkin').html(data.data['checkin'])
			$('#jumlah_pending').html(data.data['pending'])
			$('#section').find('option').not(':first').remove();
			$.each(data.data['event_gate'], function(key, value) {
				$('#section').append(`
                <option value="${value['type']}">${value['name']}</option>
            `);
			});
		});

		$('#section').on('change', function(e) {
			var data = getJSON("{{ route('scanner.section_selected') }}", {
				_token: '{{ csrf_token() }}',
				type: $(this).val(),
				id: $('#events').val()
			})
			$('#jumlah_checkin').html(data.data['checkin'])
			$('#jumlah_pending').html(data.data['pending'])
		});


		$('.btn-submit').on('click', function(e) {
			e.preventDefault();
			if (!$('#events').val()) {
				return gagal_pilih_event();
			}
			if (!$('#section').val()) {
				return gagal_pilih_section();
			}
			if (!$('#gate').val()) {
				return gagal_pilih_gate();
			}

			var data = getJSON("{{ \config('scanner.base_url') . \config('scanner.checkin') }}", {
				'barcode_no': $('#ticket').val(),
				'ticket_type': $('#section').val(),
				'gate': $('#gate').val()
			});
			if (data.meta.code != 200) {
				Swal.fire(
					'Gagal',
					data.meta.message,
					'error'
				)
			} else {
				$('#spinner-loading').show();
				scan = scan + 1;
				Swal.fire(
					'Berhasil',
					data.meta.message,
					'success'
				)
				$('#ticket').val('');

				$('#jumlah_checkin').html(data.data['checkin'])
				$('#jumlah_pending').html(data.data['pending'])
			}
		})
		$('.btn-manual').on('click', function(e) {
			e.preventDefault();
			pop_up_detail();
		})
		$('.close-detail').on('click', function(e) {
			close_detail();
		})
		// pop_up_detail();

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
