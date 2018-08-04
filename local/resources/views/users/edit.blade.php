{{-- \resources\views\users\edit.blade.php --}}

@extends('layouts.master')

@section('title', 'تصحیح کاربر')

@section('content')
  <div class="portlet light">
    <div class="portlet-title">
      <div class="caption">
          <i class="icon-note font-green-sharp"></i>
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
        {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT','class' => 'form-horizontal')) }}{{-- Form model binding to automatically populate our fields with user data --}}

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('name', 'اسم', array('class'=>'col-md-2')) }}

                  <div class="col-md-9">
                    {{ Form::text('name', null, array('class' => 'form-control')) }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('email', 'ایمیل', array('class'=>'col-md-2') ) }}
                  <div class="col-md-9">
                  {{ Form::email('email', null, array('class' => 'form-control')) }}
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
            {{-- <div class="row">
              <div class="col-md-6">
                <div class='form-group'>
                    {{ Form::label('password', 'نقش', array('class' => 'col-md-2')) }}
                    <div class="col-md-10">
                      @foreach ($roles as $role)
                          {{ Form::checkbox('roles[]',  $role->id, $user->roles ) }}
                          {{ Form::label($role->name, $role->translation) }}<br>
                      @endforeach
                    </div>
              </div>
            </div>
          </div> --}}

        {{ Form::submit('تصحیح', array('class' => 'btn btn-primary')) }}
        <a href="{{url()->previous()}}" class="btn default">برگشت</a>

        {{ Form::close() }}

      </div>

    </div>
  </div>

@endsection
