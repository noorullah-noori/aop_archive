@extends('layouts.master')
@section('title','اسناد ثبت شده')
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
        <table id="document-datatable" class="table table-bordered">
          <thead>
            <tr>
              {{-- <th>#</th> --}}
              <th>شماره سند</th>
              <th>تاریخ</th>
              <th>موضوع</th>
              <th>تعداد صفحات</th>
              <th>نوع سند</th>
              <th>مرسل</th>
              <th>لسان سند</th>
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
    $('#document-datatable').DataTable({
      processing: false,
      serverSide: true,
      ajax: '{{route('get_saved_documents_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'number', name: 'number'},
          {data: 'date', name: 'date'},
          {data: 'subject', name: 'subject'},
          {data: 'total_pages', name: 'total_pages'},
          {data: 'category.name', name: 'category.name'},
          {data: 'department.name', name: 'department.name'},
          {data: 'document_language.language_name', name: 'document_language.language_name'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  </script>
@endpush
@push('custom-css')
  <style media="screen">

  </style>

@endpush
