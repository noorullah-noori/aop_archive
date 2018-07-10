@extends('layouts.master')
@section('title','صفحه اصلی')
@section('content')
  <div class="row margin-top-10">
    @if (isset($chart))
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="dashboard-stat2">
          <h4 style="text-align:center;">چارت اسناد</h4>
          {!! $chart->render() !!}
        </div>
      </div>
    @endif

    @if (isset($documents_chart))
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="dashboard-stat2">
          <h4 style="text-align:center;">اسناد</h4>
          {!! $documents_chart->render() !!}
        </div>
      </div>
    @endif

    @if (isset($enquiries_chart))
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="dashboard-stat2">
          <h4 style="text-align:center;">درخواستی ها</h4>
          {!! $enquiries_chart->render() !!}
        </div>
      </div>
    @endif

    @if (isset($document_type_chart))
      <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="dashboard-stat2">
          <h4 style="text-align:center;">انواع اسناد</h4>
          {!! $document_type_chart->render() !!}
        </div>
      </div>
    @endif

    {{-- @if (isset($user_chart))
      <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="dashboard-stat2">
          <h4 style="text-align:center;">کاربران</h4>
          {!! $user_chart->render() !!}
        </div>
      </div>
    @endif --}}


  </div>

  @if($notice->count() >0)

<div class="row">
  <div class="col-md-12">
					<!-- BEGIN ALERTS PORTLET-->
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa  icon-bubble font-red-sunglo"></i>
					<span class="caption-subject font-red-sunglo bold uppercase">اطلاعیه ها</span>
				</div>
      </div>
      <div class="portlet-body">
        <div class="note note-info" id="notice">
          @foreach($notice as $note)
          <h4 class="block" style="color:#0d2f44">{{$note->title}}</h4>
          <p>
            {!! ($note->description)!!}
          </p>
          <hr style="border-top:1px solid #ad9999">
          @endforeach

        </div>
      </div>
    </div>
    <!-- END ALERTS PORTLET-->
  </div>
</div>
  @endif
@endsection
@push('custom-css')
  <style>

  hr:last-child{display:none;}

  .note p {
      font-size: 15px;
      line-height: 2;
  </style>
@endpush
@push('custom-js')
  <script>
  $(function() {
    var width = $(window).width();
    if(width>1351) {
        $('.col-lg-12').addClass('col-lg-6').removeClass('col-lg-12');
    }
  });

  </script>
@endpush
