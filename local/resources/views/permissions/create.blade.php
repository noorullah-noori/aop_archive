{{-- \resources\views\permissions\create.blade.php --}}
@extends('layouts.master')

@section('title', 'ایجاد صلاحیت جدید')

@section('content')

{{-- <div class='col-lg-4 col-lg-offset-4'>

    <h1><i class='fa fa-key'></i> Add Permission</h1>
    <br>

    {{ Form::open(array('url' => 'permissions')) }}

    <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', '', array('class' => 'form-control')) }}
    </div><br>
    @if(!$roles->isEmpty()) //If no roles exist yet
        <h4>Assign Permission to Roles</h4>

        @foreach ($roles as $role)
            {{ Form::checkbox('roles[]',  $role->id ) }}
            {{ Form::label($role->name, ucfirst($role->name)) }}<br>

        @endforeach
    @endif
    <br>
    {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div> --}}
<div class="portlet light">
  <div class="portlet-title">
    <div class="caption">
        <i class="icon-key font-green-sharp"></i>
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

      {{ Form::open(array('url' => 'permissions', 'class' => 'form-horizontal')) }}

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('name', 'صلاحیت', array('class'=>'col-md-2') ) }}
                {{-- {{ Form::label('name', 'Name') }} --}}

                <div class="col-md-9">
                  {{ Form::text('name', '', array('class' => 'form-control')) }}
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
                      {{ Form::label($role->name, $role->translation) }}
                      <br>
                    @endforeach
                  </div>
              </div>
            </div>
          </div>
          {{ Form::submit('ایجاد', array('class' => 'btn btn-primary')) }}
          <a href="{{url()->previous()}}" class="btn default">برگشت</a>

        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>

@endsection
