<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/scanfp/css/bootstrap-min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/scanfp/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    
    
    <script src="{{ asset('js/scanfp/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/lib/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('js/scanfp/scripts/es6-shim.js') }}"></script>
    <script src="{{ asset('js/scanfp/scripts/websdk.client.bundle.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/scripts/fingerprint.sdk.min.js') }}"></script>
    <script src="{{ asset('js/scanfp/id.js') }}"></script>
    
    
</body>
</html>
