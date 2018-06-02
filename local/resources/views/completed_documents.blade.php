@extends('layouts.master')
@section('title','اسناد تکمیل شده')
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
        @component('components.alert')
          @slot('alert_type')
             success
          @endslot
        @endcomponent
        {{-- <div class="alert alert-danger">Hey</div> --}}
    		<div class="table-container" style="">
          <table id="completed-documents-datatable" class="table table-bordered">
            <thead>
              <tr>
                <th>شماره سند</th>
                <th>تاریخ</th>
                <th>موضوع</th>
                <th>تعداد صفحات</th>
                <th>نوع سند</th>
                <th>مرسل</th>
                <th>لسان سند</th>
                <th>لیبل</th>
                <th style="width:90px;">فایل ها</th>

              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
    		</div>
    	</div>
    </div>
  @endsection

  <!-- Modal  for requesting for editing document stock details-->
  <div id="requestModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title"></h4>
        </div>
        <div class="modal-body">
            <form role="form" class="form-horizontal" id="form" action="" method="post">
            {{csrf_field()}}
            <div class="form-body">
                <div class="form-group" style="margin:auto;">

                    <div>
                      <textarea name="remarks" class="form-control" required="required"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" style="float: right !important;">درخواست تصحیح</button>
        </div>
        </form>
      </div>

    </div>
  </div>

  {{-- Modal Ends --}}


  @push('custom-js')
    <script type="text/javascript">
      $('#completed-documents-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{route('get_completed_documents_datatable')}}',
        columns: [
          {data: 'number', name: 'number'},
          {data: 'date', name: 'date'},
          {data: 'subject', name: 'subject'},
          {data: 'total_pages', name: 'total_pages'},
          {data: 'category.name', name: 'category.name'},
          {data: 'department.name', name: 'department.name'},
          {data: 'document_language.language_name', name: 'document_language.language_name'},
          {data: 'label', name: 'label'},
          // {data: 'stock_edit_request_status', name: 'stock_edit_request_status'},
          {data: 'files', name: 'files', orderable: false, searchable: false}
        ]
      });

    function openModal(id){
      $("#form").attr("action","{{url('submit_stock_edit_request')}}"+"/"+id);
      $("#requestModal").modal('show');
    }

    </script>
  @endpush
  @push('custom-css')
    <style media="screen">
    .dataTable td {
      font-size: 13px;
    }

    </style>

  @endpush
