<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
        {{ !empty($__env->yieldContent('title')) ? ' | ' : '' }}
        {{ config('app.name') }}
    </title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ mix('css/theme-light.css') }}" title="theme">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @include('_init')
</head>
<body>
    <div id="app"></div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
