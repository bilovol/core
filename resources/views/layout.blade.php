<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/3.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <meta name="theme-color" content="#0097B7">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Integration name</title>
</head>
<body>
@yield('content')
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
