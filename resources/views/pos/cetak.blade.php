<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Cetak Halaman A6</title>
	<style>
		@media print {
			@page {
				size: A6;
				margin: 0;
			}

			html,
			body {
				width: 105mm;
				height: 148mm;
				margin: 0;
				padding: 0;
			}
		}
	</style>
</head>

<body>
	<h1>Ini adalah contoh halaman A6</h1>
	<p>Isi dari halaman ini.</p>

	<button onclick="print()">Cetak Halaman</button>

	<script>
		function print() {
			window.print();
		}
	</script>
</body>

</html>
