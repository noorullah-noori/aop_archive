@extends('layouts.master')
@section('title','اسناد تایید شده')
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
      {{-- <div class="alert alert-danger">Hey</div> --}}
  		<div class="table-container" style="">
        <table id="approved-documents-datatable" class="table table-bordered">
          <thead>
            <tr>
              <th>شماره سند</th>
              <th>تاریخ</th>
              <th>موضوع</th>
              <th>تعداد صفحات</th>
              <th>نوع سند</th>
              <th>مرسل</th>
              <th>لسان سند</th>
              <th>فایل ها</th>
            </tr>
          </thead>
        </table>

  		</div>
  	</div>
  </div>
@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#approved-documents-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_approved_documents_datatable')}}',
      columns: [
        {data: 'number', name: 'number'},
        {data: 'date', name: 'date'},
        {data: 'subject', name: 'subject'},
        {data: 'total_pages', name: 'total_pages'},
        {data: 'category.name', name: 'category.name'},
        {data: 'department.name', name: 'department.name'},
        {data: 'document_language.language_name', name: 'document_language.language_name'},
        {data: 'files', name: 'files', orderable: false, searchable: false}
      ]
    });
  </script>
@endpush
@push('custom-css')
  <style media="screen">

  </style>

@endpush
