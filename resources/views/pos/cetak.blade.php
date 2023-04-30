<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Cetak Halaman A6</title>
	<style>
		.content {

			text-align: center;
		}

		@page {
			size: 4.13in 5.83in;
			margin: 0;
		}

		html,
		body {
			width: 4.13in;
			height: 5.83in;
			margin: 0;
			padding: 0;
		}

		@media print {
			@page {
				size: 4.13in 5.83in;
				margin: 0;
			}

			#non-printable {
				display: none;
			}

			html,
			body {
				width: 4.13in;
				height: 5.83in;
				margin: 0;
				padding: 0;
			}

			.content {

				text-align: center;
				padding: 100px 0;
				height: 100%;
			}
		}
	</style>
</head>

<body>
	<div class="content">
		<img src="{{ $logo }}" alt="" width="70px" height="70px" style="margin-bottom: 20px">
		<br>
		<h5>{{ $pos->category }}</h5>
		{!! QrCode::size(70)->generate($pos->barcode_no) !!}
		<p>{{ $pos->barcode_no }}</p>
		<div>
			RACER : {{ $pos->name }} <br>
			CLUB : {{ $pos->club }} <br>
			NO START : {{ $pos->id }}
		</div>
		<button onclick="window.print();" id="non-printable">Cetak Halaman</button>
	</div>


</body>

</html>
