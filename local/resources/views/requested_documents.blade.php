@extends('layouts.master')
@section('title','اسناد تسلیم شده')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">
      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
      {{-- <a href="{{route('departments.create')}}" class="btn btn-success pull-right">
        <i class="fa fa-plus"></i>
        اضافه
      </a> --}}
  	</div>
  	<div class="portlet-body">
  		<div class="table-container" style="">
        <table id="department-datatable" class="table table-bordered">
          <thead>
            <tr>
              {{-- <th>#</th> --}}
              <th>مرسل</th>
              <th>subject</th>
              <th>Total Pages</th>
              <th>Return date</th>
            </tr>
          </thead>
          <tfoot>
	        	<tr>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        	</tr>
	        </tfoot>
        </table>


  </div>
@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#department-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_requested_documents_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'department.name', name: 'department.name'},
          {data: 'subject', name: 'subject'},
          {data: 'total_pages', name: 'total_pages'},
          {data: 'date', name: 'date'},

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
