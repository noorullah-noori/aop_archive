@extends('layouts.master')
@section('title','اضافه نمودن سند')
@section('content')
  <div class="portlet light">
    <div class="portlet-title">

      <div class="caption">
          <i class="fa fa-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="row">
        <div class="col-md-6">
            <div class="form-group">
              <select class="form-control input-medium" name="convert" id="convert">
                <option value=" ">نوع تبدیل</option>
                <option value="1">میلادی به هجری شمسی</option>
                <option value="2">هجری قمری به هجری شمسی</option>
              </select>
            </div>

          <form class="form-inline margin-top-10" name="persian" role="form">
            <div class="form-group">
                <input type="number" class="form-control input-xsmall" name="day" placeholder="روز">
            </div>
            <div class="form-group">
              <select class="form-control input-xsmall" name="month">
                  <option>حمل</option>
                  <option>ثور</option>
                  <option>جوزا</option>
                  <option>سرطان</option>
                  <option>اسد</option>
                  <option>سنبله</option>
                  <option>میزان</option>
                  <option>عقرب</option>
                  <option>قوس</option>
                  <option>جدی</option>
                  <option>دلو</option>
                  <option>حوت</option>
              </select>
            </div>
            <div class="form-group">
                <input type="year" name="year" class="form-control input-xsmall" placeholder="سال">
            </div>
            <input type="button" onclick="calcPersian()" class="btn btn-default" value="تبدیل">

            <input type="hidden" name="hour" value="00">
            <input type="hidden" name="min" value="00">
            <input type="hidden" name="sec" value="00">
            <input type="hidden" name="wday">
            <input type="hidden" name="leap">

          </form>

          <form class="form-inline margin-top-10" name="islamic"  role="form">
            <div class="form-group">
                <input type="number" class="form-control input-xsmall" name="day" placeholder="روز">
            </div>
            <div class="form-group">
              <select class="form-control input-xsmall" name="month">
                <option value="1">محرم</option>
                <option value="2">صفر</option>
                <option value="3">ربیع الاول</option>
                <option value="4">ربیع الثانی</option>
                <option value="5">جمادی الاول</option>
                <option value="6">جمادی الثانی</option>
                <option value="7">رجب</option>
                <option value="8">شعبان</option>
                <option value="9">رمضان</option>
                <option value="10">شوال</option>
                <option value="11">ذی القعده</option>
                <option value="12">ذی الحجه</option>
              </select>
            </div>
            <div class="form-group">
                <input type="year" class="form-control input-xsmall" name="year" placeholder="سال">
            </div>
            <input type="button" onclick="calcIslamic()" class="btn btn-default convert" value="تبدیل">

            <input type="hidden" name="hour" value="00">
            <input type="hidden" name="min" value="00">
            <input type="hidden" name="sec" value="00">
            <input type="hidden" name="wday">
            <input type="hidden" name="leap">

          </form>

          <form class="form-inline margin-top-10" name="gregorian" role="form">
            <div class="form-group">
                <input type="number" class="form-control input-xsmall" name="day" placeholder="روز">
            </div>
            <div class="form-group">
              <select class="form-control input-xsmall" name="month">
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
              </select>
            </div>
            <div class="form-group">
                <input type="year" class="form-control input-xsmall" name="year" placeholder="سال">
            </div>
            <input type="button" onclick="calcGregorian()" class="btn btn-default convert" value="تبدیل">

            <input type="hidden" name="hour" value="00">
            <input type="hidden" name="min" value="00">
            <input type="hidden" name="sec" value="00">
            <input type="hidden" name="wday">
            <input type="hidden" name="leap">

          </form>

          <form name="julianday">
            <input type="hidden" name="day">
          </form>
        </div>
      </div>
      <div class="row margin-top-10 result">
        <div class="col-md-2">
          <div class="alert alert-info">
            <p>

              <span id="day"></span> -
              <span id="month"></span> -
              <span id="year"></span>
            </p>
          </div>

        </div>

      </div>
    </div>
  </div>


@endsection
@push('custom-css')
<style>
form[name='gregorian'], form[name='persian'], form[name='islamic'], .result {
  display: none;
}

</style>
@endpush
@push('custom-js')
  <script>
    //  display appropriate date conversion form
    $('#convert').change(function() {
      if($('#convert').val()==' ') {
        $("form[name='gregorian'], form[name='islamic'], .result ").hide();
      }
      else if($('#convert').val()==1) {
        $("form[name='gregorian']").show();
        $("form[name='islamic']").hide();

      }
      else if($('#convert').val()==2) {
        $("form[name='gregorian']").hide();
        $("form[name='islamic']").show();

      }
    });

    //display appropriate result i.e. converted date to shamsi
    $('.convert').click(function() {
      $('.result').show();
    });
  </script>


  <script language="JavaScript" src="{{asset('assets/js/test/astro.js')}}"></script>
  <script language="JavaScript" src="{{asset('assets/js/test/convert.js')}}"></script>

@endpush
