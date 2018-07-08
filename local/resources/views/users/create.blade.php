{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.master')

@section('title', 'کاربر جدید')

@section('content')
  <div class="portlet light">
    <div class="portlet-title">
      <div class="caption">
          <i class="icon-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
    </div>
    <div class="portlet-body">
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
      <div class="">

        {{ Form::open(array('url' => 'users', 'class' => 'form-horizontal')) }}

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('email', 'اسم', array('class'=>'col-md-2') ) }}

                  <div class="col-md-9">
                    {{ Form::text('name', '', array('class' => 'form-control')) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('email', 'ایمیل', array('class'=>'col-md-2') ) }}
                  <div class="col-md-9">
                  {{ Form::email('email', '', array('class' => 'form-control')) }}
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">

                  {{ Form::label('email', 'پاسورد', array('class'=>'col-md-2') ) }}
                  <div class="col-md-9">
                  {{ Form::password('password', array('class' => 'form-control')) }}
                  </div>


                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('password', 'تکرار پاسورد', array('class' => 'col-md-2')) }}
                  <div class="col-md-9">
                  {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                  </div>

                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class='form-group'>
                    {{ Form::label('password', 'نقش', array('class' => 'col-md-2')) }}
                    <div class="col-md-10">
                      @foreach ($roles as $role)
                        {{ Form::checkbox('roles[]',  $role->id ) }}
                        {{ Form::label($role->name, $role->translation) }}<br>
                      @endforeach
                    </div>
              </div>
            </div>
          </div>

        {{ Form::submit('ایجاد کاربر', array('class' => 'btn btn-primary')) }}
        <a href="{{url()->previous()}}" class="btn default">برگشت</a>
        {{-- {{ Form::link_to('برگشت', array('class' => 'btn btn-primary')) }} --}}

        {{ Form::close() }}

      </div>

    </div>
  </div>

@endsection
