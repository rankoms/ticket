@extends('layouts.app_mobile')

@section('content')
	<main>
		<div id="spinner-loading">
			<div class="d-flex justify-content-center">
				<button class="btn btn-primary" type="button" disabled>
					<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
					<span>Loading...</span>
				</button>
			</div>
		</div>
		<div class="container-splash-screen">
			<div class="wrapper-logo">
				<img src="{{ url('images/mobile/illustrations/logo.png') }}" alt="Logo" width="160px" height="160px">
			</div>
			<div class="title">
				SISTEM MANAJEMEN ASET
			</div>
			<div class="sub-title">DIV TIK POLRI</div>
		</div>
		<div class="footer-splash-screen">
			<div class="wrapper-footer">
				<span>Powered By</span>
				<img src="{{ url('images/mobile/icons/globe17.png') }}" alt="Globe 17" width="79px" height="32px">
			</div>
		</div>
	</main>
@endsection
