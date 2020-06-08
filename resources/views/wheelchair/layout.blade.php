<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <title>Wheelchairs</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="config-first-param" content="{{ json_encode($config_first_param) }}">

</head>
<body>
<div class="container-fluid" id="common">
    <div class="row">
        <div class="col-md-3" id="filter">
            @yield('filterBar')
        </div>
        <div class="col-md-9" id="content">
            @yield('content')
        </div>
    </div>
</div>
</body>

<script src="{{ asset('js/filter.js') }}"></script>
</html>
