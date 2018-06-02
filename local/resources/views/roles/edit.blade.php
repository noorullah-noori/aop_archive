@extends('layouts.master')

@section('title', 'تحصیح نقش')

@section('content')

<div class="portlet light">
  <div class="portlet-title">
    <div class="caption">
        <i class="icon-plus font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title') - {{$role->translation}}</span>
    </div>
  </div>
  <div class="portlet-body">
    <div class="">
      @component('components.alert')
        @slot('alert_type')
          success
        @endslot
      @endcomponent
      {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT', 'class' => 'form-horizontal')) }}

      {{-- {{ Form::open(array('url' => 'roles', 'class' => 'form-horizontal')) }} --}}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('name', 'نقش', array('class'=>'col-md-2') ) }}

                <div class="col-md-9">
                  <input type="text" class="form-control" name="role_name" value="{{$role->name}}" >
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

      {{ Form::submit('تصحیح نقش', array('class' => 'btn btn-primary')) }}
      <a href="{{url()->previous()}}" class="btn default">برگشت</a>

      {{ Form::close() }}

    </div>

  </div>
</div>

@endsection
