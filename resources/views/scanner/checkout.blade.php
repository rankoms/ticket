@extends('layouts.app_mobile')

@section('content')
	<main>
		<div class="header">
			<a href="javascript:history.back()">
				<img src="{{ url('images/mobile/caret-back.svg') }}" width="4.5px" height="9px" alt="Back">
				Back
			</a>

			<span>Checkout Ticket</span>
		</div>
		<div class="content">

			<div class="wrapping-content">
				<div class="wrapping-input form-floating">
					<select class="form-control" name="events" id="events">
						<option value="{{ $event->event }}">{{ $event->event }}</option>
					</select>
					<label for="events">Event</label>
				</div>
				<div class="wrapping-input form-floating">
					<select class="form-control" name="section" id="section">
						<option value="{{ $event->category }}">{{ $event->category }}</option>
					</select>
					<label for="events">Kategory</label>
				</div>
				<div class="row mb-10">
					<div class="col-6">
						<div class="wrapper-radio " id="wrapper-checkin">
							<label for="checkin">
								<input type="radio" name="gate" value="checkin" id="checkin" disabled>
								<i class="fa fa-sign-in me-10"></i>
								<span>checkin</span>
							</label>
						</div>
					</div>
					<div class="col-6">
						<div class="wrapper-radio active" id="wrapper-checkout">
							<label for="checkout">
								<input type="radio" name="gate" value="checkout" id="checkout">
								<i class="fa fa-sign-out me-10"></i>
								<span>checkout</span>
							</label>
						</div>
					</div>
				</div>

				<div id="reader" width="100%" max-width="480px"></div>
				<div class="wrapper-keterangan" style="display: none">
					<div class="wrapper-box">
						Total Checkin
						<div id="jumlah_checkin">
							{{ $total_checkin }}
						</div>
					</div>
					<div class="wrapper-box">
						Total Checkout
						<div id="jumlah_checkout">
							{{ $total_checkout }}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-btn-manual" style="display: none">
			<button class="btn-manual">Input Manual</button>
		</div>
		<div class="popupMedium">
			<div class="footer-container">
				<div id="PopupDetail" class="container-popup ">
					<div class="wrapper-title">
						<div class="labelPopup">
							Checkout Ticket
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
	<script src="{{ url('js/sweetalert2@11.js') }}"></script>
	<script src="{{ url('js/html5-qrcode.min.js') }}"></script>
	<script>
		var scan = 0;


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
				var data = getJSON("{{ route('ticket.checkin') }}", {
					'barcode_no': decodedText,
					'category': $('#section').val(),
					'gate': $('#gate').val(),
					'_token': '{{ csrf_token() }}'
				});
				if (data.meta.code != 200) {
					html5QrcodeScanner.clear();
					Swal.fire({
						timer: 3000,
						icon: 'error',
						title: data.meta.message,
						showConfirmButton: false
					}).then((result) => {

						html5QrcodeScanner.render(onScanSuccess, onScanFailure);
					})
				} else {
					html5QrcodeScanner.clear();
					Swal.fire({
						timer: 3000,
						icon: 'success',
						title: data.meta.message,
						showConfirmButton: false
					}).then((result) => {

						html5QrcodeScanner.render(onScanSuccess, onScanFailure);
					})
					$('#jumlah_checkin').html(data.data['checkin'])
					$('#jumlah_checkout').html(data.data['pending'])
				}
			}
		}

		function onScanFailure(error) {
			// handle scan failure, usually better to ignore and keep scanning.
			// for example:
			// console.warn(`Code scan error = ${error}`);
		}

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
	</script>
@endsection
