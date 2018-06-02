@extends('layouts.master')
@section('title','نمایش درخواستی ها')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">
      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body">
  		<div class="table-container" style="">
        <table id="department-datatable" class="table table-bordered">
          <thead>
            <tr>
              <th>شماره سند درخواستی</th>
              <th>هدایت دهنده</th>
              <th>تاریخ درخواستی</th>
              <th>مرجع</th>
              <th>نوعیت</th>
              <th>تاریخ بازگشت اسناد</th>
              <th>عملیات</th>
            </tr>
          </thead>
          <tfoot>
	        	<tr>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
              <td></td>
	        	</tr>
	        </tfoot>
        </table>
      </div>
    </div>
  </div>

@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#department-datatable').DataTable({
      // processing: true,
      // serverSide: true,
      ajax: '{{route('edit_enquiries_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'enquiry_number', name: 'enquiry_number'},
          {data: 'approval_authority', name: 'approval_authority'},
          {data: 'request_date', name: 'request_date'},
          {data: 'department.name', name: 'department.name'},
          {data: 'original', name: 'original'},
          {data: 'expected_return_date', name: 'expected_return_date'},
          {data: 'action', name: 'action',searchable:false,orderable:false}
      ],
    });
  </script>
@endpush
@push('custom-css')
  <style media="screen">
  .non_searchable input {
    display: none;
  }
  table.dataTable tfoot th, table.dataTable tfoot td {
    border-top: 0;
  }
  </style>
@endpush
