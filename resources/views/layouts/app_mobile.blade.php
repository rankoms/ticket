<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Randy Komara">
	<meta name="generator" content="Hugo 0.88.1">
	<title>DASHBOARD GATE</title>

	<!-- Bootstrap core CSS -->

	<!-- Favicons -->
	<link rel="icon" href="{{ url('favicon.ico') }}">
	<meta name="theme-color" content="#7952b3">
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="{{ url('mobile/css/bootstrap.min.css') }}">
	<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"
		type='text/css'>
	{{-- <link rel="stylesheet" href="{{ url('mobile/css/fontawesome.css') }}"> --}}
	<link rel="stylesheet" href="{{ url('css/mobile.css') }}">
	<link rel="stylesheet" href="{{ url('css/modal-popup.css') }}">
	<link rel="stylesheet" href="{{ url('css/custom.css') }}">
	<link rel="stylesheet" href="{{ url('css/color.css') }}">
</head>

<body>
	@yield('content')
	<script src="{{ url('mobile/js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ url('mobile/js/jquery.slim.min.js') }}"></script>
	<script src="{{ url('mobile/js/popper.min.js') }}"></script>
	<script src="{{ url('mobile/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('mobile/js/jquery.min.js') }}"></script>

	@yield('script')
	<script>
		function bgModalAdd() {
			$("#bgOpacityModal").addClass("opacityModal")
		}

		function headerHeight() {
			return $('.header').height()
		}

		function bgModalRemove() {
			$("#bgOpacityModal").removeClass("opacityModal")
		}

		function maxModalHeight(vh = '90vh') {
			vh = vh
			space = '20px'
			header = headerHeight() + "px"
			ret = 'calc(' + vh + ' - ' + space + ' - ' + header + ')'
			return ret
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

</body>

</html>
