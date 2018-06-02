@extends('layouts.master')
@section('title','اضافه نمودن مرسل')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">
          <i class="fa fa-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body form">
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
      <form role="form" class="form-horizontal" action="{{route('departments.store')}}" method="post">
          {{csrf_field()}}
          <div class="form-body col-md-6 col-md-offset-3">
              <div class="form-group">
                  <label class="col-md-2 control-label">مرسل</label>
                  <div class="col-md-10">
                    <input type="text" class="form-control" name="department_name" value="{{old('name')}}">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-md-2 control-label">توضیحات</label>
                  <div class="col-md-10">
                    <textarea name="department_description" class="form-control" rows="8" cols="80">{{old('description')}}</textarea>
                  </div>
              </div>
          </div>

          <div class="form-actions">
              <div class="row">
                  <div class="col-md-offset-4 col-md-8" style="padding-right:10px;">
                      <button type="submit" class="btn blue">ثبت</button>
                      <a href="{{route('departments.index')}}" class="btn default">بازگشت</a>
                  </div>
              </div>
          </div>
      </form>
  	</div>
  </div>
@endsection
