@extends('layouts.master')

@section('title', 'نقش جدید')

@section('content')

<div class="portlet light">
  <div class="portlet-title">
    <div class="caption">
        <i class="icon-plus font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="">
      @component('components.alert')
        @slot('alert_type')
          success
        @endslot
      @endcomponent
      {{ Form::open(array('url' => 'roles', 'class' => 'form-horizontal')) }}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{-- {{ Form::label('email', 'نقش', array('class'=>'col-md-2') ) }} --}}
                <label class="control-label col-md-2">نقش</label>


                <div class="col-md-9">
                  <input type="text" class="form-control " onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"  name="role_name" value="{{old('role_name')}}" >

                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <legend>صلاحیت ها</legend>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">

                <div class="col-md-3">
                  <h4>عملیات</h4>
                  @foreach ($permissions as $permission)
                      @if($permission->menu == 0)
                        {{ Form::checkbox('permissions[]',  $permission->id ) }}
                        {{ Form::label($permission->name, ucfirst($permission->translation)) }}<br>
                      @endif
                  @endforeach
                </div>
                <div class="col-md-3">
                  <h4>نمایش</h4>
                  @foreach ($permissions as $permission)
                      @if($permission->menu == 1)
                        {{ Form::checkbox('permissions[]',  $permission->id ) }}
                        {{ Form::label($permission->name, ucfirst($permission->translation)) }}<br>
                      @endif
                  @endforeach
                </div>
                <div class="col-md-3">
                  <h4>درخواستی</h4>
                  @foreach ($permissions as $permission)
                      @if($permission->menu == 2)
                        {{ Form::checkbox('permissions[]',  $permission->id ) }}
                        {{ Form::label($permission->name, ucfirst($permission->translation)) }}<br>
                      @endif
                  @endforeach
                </div>


              </div>
            </div>
          </div>

      {{ Form::submit('ایجاد نقش', array('class' => 'btn btn-primary')) }}
      <a href="{{url()->previous()}}" class="btn default">برگشت</a>

      {{ Form::close() }}

    </div>

  </div>
</div>

@endsection
