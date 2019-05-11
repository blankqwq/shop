
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Shop') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app" class="{{ route_class() }}-page">
    @include('layouts.header')
    <main class="container">
        @yield('content')
    </main>
    @include('layouts.footer')
</div>
<!-- JS 脚本 -->
<script src="{{ mix('js/app.js') }}"></script>
@yield('scriptsAfterJs')
</body>
</html>