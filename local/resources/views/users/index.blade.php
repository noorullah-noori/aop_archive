{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.master')

@section('title', 'کاربران')

@section('content')

  <div class="portlet light">
  	<div class="portlet-title">
      <div class="caption">
          <i class="icon-user font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
      <a href="{{ route('users.create') }}" class="btn btn-success pull-right">
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
                        <th>اسم</th>
                        <th>ایمیل</th>
                        {{-- <th>تاریخ</th> --}}
                        <th style="width:60%;">نقش ها</th>
                        <th>حالت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                    <tr>
                      @php 
                       if($user['type']==1){
                            $checked ='checked';
                          }else{
                          $checked='';
                        }
                        @endphp

                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td>{{ $user->created_at->format('F d, Y h:ia') }}</td> --}}
                        <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                        <td><input type='checkbox' name='type' {{$checked}} value="{{$user['id']}}"></td>
                        <td>
                          {{-- Edit user personal Details --}}
                          <a href="{{ route('users.edit', $user->id) }}" title="تحصیح کاربر" class="" style="margin-right: 3px;padding:10px;">
                            <i class="icon-note" style="font-size:1.3em"></i>
                          </a>
                          {{-- Edit user roles --}}
                          <a href="{{ route('users.edit_role', $user->id) }}" title="تصحیح نقش ها" class="" style="margin-right: 3px;">
                            <i class="icon-key" style="font-size:1.3em"></i>
                          </a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('custom-js')
  <script>
    $("input[name='type']").change(function(){
      var type = '';
      var user = '';
      if(this.checked){
          type=1;
          user = $(this).val();
      }
      else{
        type=0;
        user = $(this).val();
      }
      $.ajax({
      type : "get",
      url : "{{url('update_user_status')}}/"+user+"/"+type,
      success : function(data)
      {

      }
    });
    });
  </script>
@endpush