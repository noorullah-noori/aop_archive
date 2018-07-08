@extends('layouts.master')
@section('title','اضافه نمودن اطلاعیه')
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
      <form role="form" class="form-horizontal" method="post" action="{{route('notice.store')}}" >
           {{csrf_field()}}
          <div class="form-body col-md-6 col-md-offset-3">
              <div class="form-group">
                  <label class="col-md-2 control-label">عنوان</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" value="{{old('notice_title')}}" name="notice_title">
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-md-2 control-label">توضیحات</label>
                  <div class="col-md-10">
                    <textarea class="form-control tinymce" name="notice_description"  rows="8" cols="80">{{old('notice_description')}}</textarea>
                  </div>
              </div>

          </div>
          <div class="form-actions">
              <div class="row">
                  <div class="col-md-offset-4 col-md-8" style="padding-right:10px;">
                      <button type="submit" class="btn blue ">ثبت</button>
                      <a href="{{route('notice.index')}}" class="btn default">بازگشت</a>
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
