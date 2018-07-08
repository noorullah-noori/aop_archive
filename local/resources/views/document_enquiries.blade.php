@extends('layouts.master')
@section('title','درخواستی های اسناد')
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
      {{-- print <alerts></alerts> if present --}}
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
      {{-- <div class="alert alert-danger">Hey</div> --}}
  		<div class="table-container" style="">
        <table id="department-datatable" class="table table-bordered">
          <thead>

            <tr>
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
          <tfoot>
	        	<tr>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td></td>
	        		<td class="non_searchable"></td>
	        	</tr>
	        </tfoot>
        </table>
        <div class="row checkout-section">
          <div class="col-md-6">
            <div class="panel panel-info">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <h3 class="panel-title">اسناد انتخاب شده</h3>
                </div>
                <!-- List group -->
                <ul class="list-group" >
                  <table class="table">
                    <thead>
                      <tr>
                        <th>مرسل</th>
                        <th>نوعیت سند</th>
                        <th>شماره سند</th>
                        <th>تاریخ سند</th>
                        <th>حذف</th>
                      </tr>
                    </thead>
                    <tbody id="items-for-checkout">


                    </tbody>
                  </table>
                </ul>
                <div class="panel-footer">
                  <a onclick="submitEnquiriesItems()" class="btn btn-success">
                    درج درخواستی
                  </a>
                </div>
            </div>
          </div>
        </div>



  </div>
@endsection
@push('custom-js')
  {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script> --}}
  <script>

    // array to store final enquired documents ids
    var enquired =[];
    // function for adding document to enquired documents
    function addToEnquiries(id) {
      // disable the add button for current document
      $('#btn_'+id).attr('disabled','disabled');

      // display the checkout section
      if($('.checkout-section').css('display')=='none') {
        $('.checkout-section').css('display','block');
      }

      // get the current document information from controller and append it to checkout section
      $.ajax({
        method: 'GET',
        url:"get_document_for_enquiry_checkout/"+id,
        success: function(data){
          if($('#doc_'+id).length==0) {
            console.log(enquired);
            $('#items-for-checkout').append("<tr id='doc_"+id+"'><td>"+data.department.name+"</td><td>"+data.category.name+"</td><td>"+data.number+"</td><td>"+data.date+"</td><td><a onclick='removeFromEnquiries("+data.id+")' class='badge badge-danger' style='line-height:1.5'>×</a></td></tr>");

          }
        },
      });
      enquired.push(id);

    }

    //function for removing selected document from enquired documents
    function removeFromEnquiries(id) {
      $('#btn_'+id).removeAttr('disabled')
      $('#doc_'+id).remove();
      enquired.pop(id);
      console.log(enquired);
      if(enquired.length==0) {
        $('.checkout-section').css('display','none');
      }
    }

    //function to submit enquired documents to Controller
    function submitEnquiriesItems() {
      window.location.href = "submit_documents_for_enquiry_checkout/"+enquired;
    }

    $('#department-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_enquirable_documents_datatable')}}',
      columns: [
          // {data: 'id', name: 'id'},
          {data: 'number', name: 'number'},
          {data: 'date', name: 'date'},
          {data: 'subject', name: 'subject'},
          {data: 'total_pages', name: 'total_pages'},
          {data: 'category.name', name: 'category.name'},
          {data: 'department.name', name: 'department.name'},
          {data: 'document_language.language_name', name: 'document_language.language_name'},
          // {data: 'files', name: 'files', orderable: false, searchable: false},
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
  .checkout-section {
    display: none;
  }
  .checkout-section table {
    width: 95% !important;
    margin-right: 10px;
  }
  .checkout-items li{
    display: inline;
    padding-right: 10px;
  }
  .list-group thead>tr {
    background: #fff !important;
  }
  .list-group table {
    margin-bottom: 0;
  }

  </style>

@endpush
