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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Favicons -->
    <link rel="icon" href="{{url('favicon.ico')}}">
    <meta name="theme-color" content="#7952b3">
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{url('css/mobile.css')}}">
    <link rel="stylesheet" href="{{url('css/modal-popup.css')}}">
    <link rel="stylesheet" href="{{url('css/custom.css')}}">
    <link rel="stylesheet" href="{{url('css/color.css')}}">
</head>

<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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