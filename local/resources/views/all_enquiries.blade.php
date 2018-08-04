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
              <th style="text-align:center;background:#fff;color:black;" colspan=6>
                عمومی
              </th>
              <th style="text-align:center;background:#fff;color:black;" colspan=3>
                اصلی
              </th>
            </tr>
            <tr>
              <th>شماره سند درخواستی</th>
              <th>هدایت دهنده</th>
              <th>تاریخ درخواستی</th>
              <th>مرجع</th>
              <th>نوعیت</th>
              <th>چاپ کاپی</th>
              <th>تاریخ بازگشت اسناد</th>
              <th>ضرب الاجل</th>
              <th>چگونگی بازگشت</th>
            </tr>
          </thead>
          <tfoot>
	        	<tr>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td class="non_searchable"></td>
	        		<td class="non_searchable"></td>
	        		<td class="non_searchable"></td>
	        		<td class="non_searchable"></td>
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
      ajax: '{{route('get_all_enquiries_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'enquiry_number', name: 'enquiry_number'},
          {data: 'approval_authority', name: 'approval_authority'},
          {data: 'request_date', name: 'request_date'},
          {data: 'department.name', name: 'department.name'},
          {data: 'original', name: 'original'},
          {data: 'print_copy', name: 'print_copy', orderable: false, searchable: false},
          {data: 'expected_return_date', name: 'expected_return_date'},
          {data: 'remaining_days', name: 'remaining_days'},
          {data: 'action', name: 'action', orderable: false, searchable: false}

      ],
      initComplete: function () {
          this.api().columns().every(function () {
              var column = this;
              var input = document.createElement("input");
              var test = $(input).appendTo($(column.footer()).empty())
              .on('change', function () {
                  column.search($(this).val(), false, false, true).draw();
              });
          });
      }
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
