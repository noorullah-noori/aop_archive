@extends('layouts.master')
@section('title',' اضافه نمودن لسان')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">
          <i class="fa fa-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body form">
      {{-- print <alerts></alerts> if present --}}
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
      <form role="form" class="form-horizontal" method="post" action="{{route('insert_language')}}" >
           {{csrf_field()}}
          <div class="form-body col-md-6 col-md-offset-3">
              <div class="form-group">
                  <label class="col-md-2 control-label">لسان</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" value="{{old('language_name')}}" name="language_name">
                  </div>
              </div>


          </div>
          <div class="form-actions">
              <div class="row">
                  <div class="col-md-offset-4 col-md-8" style="padding-right:10px;">
                      <button type="submit" class="btn blue ">ثبت</button>
                      <a href="{{route('document_language')}}" class="btn default">بازگشت</a>
                  </div>
              </div>
          </div>
      </form>
  	</div>
  </div>
  <div class="first">

  </div>


@endsection

<style>

</style>
