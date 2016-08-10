<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML template for Your company">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap-responsive.min.css') }}" rel="stylesheet">

    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap-notify.min.js') }}"></script>
</head>

<body>
@include('elements/notify')
<div class="container">
    <div style="margin-top:50px;" class=" col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        @yield('content')
    </div>
</div>

</body>
</html>
