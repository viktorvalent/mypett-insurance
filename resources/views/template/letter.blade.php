<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mypett Letter</title>
    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.css') }}">
    @stack('template_css')
</head>
<body>
    @yield('template_body')
    <script src="{{ asset('landing/js/bootstrap.js') }}"></script>
    @stack('template_js')
</body>
</html>
