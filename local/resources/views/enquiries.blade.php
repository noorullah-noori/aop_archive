@extends('layouts.master')
@section('title','درخواستی ها')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">
      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body">
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
  		<div class="table-container" style="">
        <table id="department-datatable" class="table table-bordered">
          <thead>
            <tr>
              <th>شماره سند درخواستی</th>
              <th>هدایت دهنده</th>
              <th>تاریخ درخواستی</th>
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
	        		<td class="non_searchable"></td>
	        	</tr>
	        </tfoot>
        </table>
  </div>

  <!-- Modal for request Document(maktoob) -->
<div class="modal fade" id="requestDocumentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label">مکتوب درخواستی</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
      </div>
    </div>
  </div>
</div>
{{-- Modal Ends --}}

@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#department-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_enquiries_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'enquiry_number', name: 'enquiry_number'},
          {data: 'approval_authority', name: 'approval_authority'},
          {data: 'request_date', name: 'request_date'},
          {data: 'expected_return_date', name: 'expected_return_date'},
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

    function showModal(id){
         $.ajax({
          type: "GET",
          url: "{{url('show_enquiry_document/')}}"+'/'+id,
          success: function(result) {
            $("#body").html("<img src='"+result['file_path']+"'>");
            console.log(result['file_path']);
            $("#requestDocumentModal").modal('show');
          },
          error: function(result) {
              alert('error');
          }
       });
    }
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
  .modal-body img {
    width:100%;
  }
  </style>
@endpush
