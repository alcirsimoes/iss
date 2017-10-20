<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if(isset($survey)){{ $survey->name }}@endif</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style media="screen">
        .img-m {padding-top: 22px}
    </style>
</head>
<body>
    <div id="app">
        <div class="row">
            <img class="col-sm-2 col-sm-offset-1" src="{{ asset('assets/imgs/H2M.png') }}" alt="H2M">
            <img class="col-sm-2 col-sm-offset-6 img-m" src="{{ asset('assets/imgs/Krones.png') }}" alt="H2M">
        </div>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
