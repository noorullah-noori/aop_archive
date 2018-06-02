@extends('layouts.master')
@section('title','اسناد تحویل شده')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body">
      {{-- <div class="alert alert-danger">Hey</div> --}}
  		<div class="table-container" style="">
        <table id="department-datatable" class="table table-bordered">
          <thead>
            <tr>
              <th>مرسل</th>
              <th>Approval authority</th>
              <th>Request date</th>
              <th>Orignal</th>
              <th>Expected date</th>
              <th>عملیات</th>
            </tr>
          </thead>
        </table>

  		</div>
  	</div>
  </div>
@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#department-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_enquire_datatable')}}',
      columns: [
          {data: 'departments.name', name: 'departments.name'},
          {data: 'approval_authority', name: 'approval_authority'},
          {data: 'request_date', name: 'request_date'},
          {data: 'orignal', name: 'orignal'},
          {data: 'expected_date', name: 'expected_date'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  </script>
@endpush
@push('custom-css')
  <style media="screen">

  </style>

@endpush
