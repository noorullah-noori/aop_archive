<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Archive - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <style>

      @font-face {
        font-family: 'persian_font';
        src:url("{{asset('assets/fonts/iransans_bold.ttf')}}");
      }
      body {
        direction: rtl;
        text-align: right;
        font-family: persian_font;
        background-image: url("{{asset('assets/images/login_background.jpg')}}");
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh;
      }
      p.teaser {
        text-indent: 30px;
      }
    </style>
    @stack('custom-css')
</head>
<body>
<div id="app">
    @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('custom-js')
</body>
</html>
