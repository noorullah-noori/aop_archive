@extends('layouts.master')

@section('title', 'تصحیح نقش ')

@section('content')

    <div class="portlet light">
      <div class="portlet-title">
        <div class="caption">
            <i class="icon-note font-green-sharp"></i>
            <span class="caption-subject font-green-sharp bold uppercase">@yield('title') - {{$permission->translation}}</span>
        </div>
      </div>
      <div class="portlet-body">
        <div class="">
          @component('components.alert')
            @slot('alert_type')
              success
            @endslot
          @endcomponent
          {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}{{-- Form model binding to automatically populate our fields with permission data --}}

          {{ Form::open(array('url' => 'roles', 'class' => 'form-horizontal')) }}

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    {{ Form::label('name', 'نقش', array('class'=>'col-md-1') ) }}

                    <div class="col-md-9">
                      {{ Form::text('name', null, array('class' => 'form-control')) }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-top:10px;">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="col-md-1">
                    </div>

                    <div class="col-md-9">
                      {{ Form::submit('تصحیح', array('class' => 'btn btn-primary')) }}
                      <a href="{{url()->previous()}}" class="btn default">برگشت</a>
                    </div>

                  </div>
                </div>

              {{ Form::close() }}
            </div>
          </div>
         </div>
       </div>


@endsection
