<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
  <title>@yield('title')</title>
  @include('layouts.partials.css_links')
  <meta name="token" content="{{csrf_field()}}">


  <style media="screen">
    @font-face {
      font-family: 'persian_font';
      src:url("{{asset('assets/fonts/iransans_bold.ttf')}}");
      {{-- src:url("{{asset('assets/fonts/IRANSans.woff')}}");--}}

    }
    body * {
      direction: rtl;
      font-family: persian_font;
    }
    .rtl {
      left: 0 !important;
      right: auto !important;
    }
    .persian_font {
      font-family: persian_font;
    }
    .page-container{
      padding: 0px !important;
    }

    @media only screen and (min-width: 992px){
      .page-content-wrapper .page-content {
        min-height: 539px;
      }
      .page-footer {
        position: initial;
        bottom: 0;
        height:30px;
        width:100%;
      }
    }
    /* .page-footer {
      position: absolute;
      bottom: 0;
      height:30px;
      width:100%;
    } */
    .page-logo a{
      width: 195px;
    }
    .logo-default {
      width: 100%;
    }
    .page-header.navbar .menu-toggler.sidebar-toggler {
      margin: 37px 0 0 0;
    }
    .page-header.navbar .page-logo .logo-default {
      margin: 10px 0 0 0;
    }
    .page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-menu:after {
      left: 10px;
      right: auto;
    }
    .page-header.navbar .top-menu .navbar-nav > li.dropdown .dropdown-menu:before {
      left: 0;
      right: auto;
    }
    .portlet > .portlet-title > .caption {
      float: right;
    }
    .portlet-title .caption i {
      float: right !important;
      font-size: 20px !important;
      margin-left: 5px !important;
    }
    /*datatable sepcific style*/
    thead>tr {
      background: #f3f3f3 !important;
    }
    thead>tr th {
      text-align: right;
    }
    table.dataTable {
      border: 1px solid #ddd !important;
    }
    .form-horizontal .control-label {
      text-align: right;
    }
    .form-actions {
      border-top: 0 !important;
    }
    .dataTables_wrapper .col-xs-6 {
      float: left;
    }
    /*alert notification style*/
    .alert.alert-danger {
      padding-right: 30px;
    }

    /* sidebar icons style */
    .page-sidebar-menu  .sub-menu i {
      color: #1fb89e !important;
    }

    table {
      width: 100% !important;
    }
    td input {
      width: 100px;
    }
    table.dataTable tfoot th, table.dataTable tfoot td {
      border-top: none;
    }

    /*notifications font size*/
    span.details {
      font-size: .9em;
    }
    span.time {
      font-size: .8em !important;
    }
    table.dataTable tbody th, table.dataTable tbody td {
      /*font-size: .85em;*/

    }
    table td {
      font-size: 13px;
    }
    .row {
      margin-left:0;
    }
    /*notification icon style*/
    .label.label-icon {
      padding: 4px;
    }
    .page-header.navbar .top-menu .navbar-nav > li.dropdown-notification .dropdown-menu .dropdown-menu-list > li a .details .label-icon i {
      margin: 0;

    }


  </style>

  {{-- page specific styles go here --}}
  @stack('custom-css')

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-sidebar-closed-hide-logo">

@include('layouts.partials.header')

<!-- BEGIN CONTAINER -->
<div class="page-container">

  <!-- SIDEBAR -->
  @include('layouts.partials.sidebar')

	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
      <!-- BEGIN PAGE HEAD -->
			<div class="page-head">

				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1 class="persian_font">@yield('title')</h1>
				</div>
				<!-- END PAGE TITLE -->

        <!-- END PAGE HEAD-->

  			<!-- BEGIN PAGE CONTENT-->
  			<div class="row">
  				<div class="col-md-12">

            @yield('content')
  				</div>
  			</div>
  			<!-- END PAGE CONTENT-->

			</div>
		</div>
	</div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

@include('layouts.partials.footer')

@include('layouts.partials.script_links')

{{-- page specific javascript goes here --}}
@stack('custom-js')

</body>
<!-- END BODY -->
</html>
