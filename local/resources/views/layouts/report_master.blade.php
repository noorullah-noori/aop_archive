
<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
  <title>@yield('title')</title>
  @include('layouts.partials.css_links')
  <style>
  @font-face {
    font-family: 'persian_font';
    src:url("{{asset('assets/fonts/iransans_bold.ttf')}}");
    {{-- src:url("{{asset('assets/fonts/IRANSans.woff')}}");--}}

  }
  body * {
    direction: rtl;
    font-family: persian_font;
  }
  html,body {
    background: #fff;

  }
  </style>

  {{-- page specific styles go here --}}
  @stack('custom-css')

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo">

<!-- BEGIN CONTAINER -->
<div class="page-container">

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">

  @yield('content')

  </div>
<!-- END CONTAINER -->

@include('layouts.partials.script_links')

{{-- page specific javascript goes here --}}
@stack('custom-js')

</body>
<!-- END BODY -->
</html>
