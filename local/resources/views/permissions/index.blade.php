{{-- \resources\views\permissions\index.blade.php --}}
@extends('layouts.master')

@section('title', ' صلاحیت ها')

@section('content')
<div class="portlet light">
  <div class="portlet-title">
    <div class="caption">
        <i class="fa fa-key font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
    </div>
    <a href="{{ URL::to('permissions/create') }}" class="btn btn-success pull-right">
      <i class="fa fa-plus"></i>
      اضافه
    </a>
  </div>
  <div class="portlet-body">
    {{-- <a href="" class="btn btn-default pull-right"></a>
    <a href="{{ route('permissions.index') }}" class="btn btn-default pull-right"></a></h1> --}}
    {{-- <hr> --}}
    @component('components.alert')
      @slot('alert_type')
        success
      @endslot
    @endcomponent
    <div class="table-responsive">
        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>صلاحیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($permissions as $permission)
              <tr>
                  <td>{{ $permission->translation }}</td>
                  <td>
                  {{-- <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a> --}}

                  {{-- {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!} --}}


                  <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}" class="" style="margin-right: 3px;">
                    <i class="icon-note" style="font-size:1.3em"></i>
                  </a>
                  {{-- {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id] ]) !!}
                  {!! Form::button('<i style="font-size:1.3em" class="icon-trash"></i>', ['type'=>'submit','style'=>'background:none;border:none;color:#5b9bd1;']) !!}
                  {!! Form::close() !!} --}}

                  </td>
              </tr>
              @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>

@endsection
