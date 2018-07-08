@extends('layouts.master')
@section('title','تصحیح درخواستی')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">
          <i class="fa fa-plus font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body form">
      {{-- print <alerts></alerts> if present --}}
      {{-- <h1>{{$already_exists}}</h1> --}}
      @if (session('already_exists'))
        <ul class="alert alert-danger">
          <li>{{session('already_exists')}}</li>
        </ul>
      @elseif(session('success'))
        <ul class="alert alert-success">
          <li>{{session('success')}}</li>
        </ul>
      @endif
      {{-- <form role="form" class="form-horizontal" action="{{route('enquiries.store',$document->id)}}" enctype="multipart/form-data" method="post"> --}}
          {{csrf_field()}}
              <legend>معلومات اسناد انتخاب شده</legend>
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
                            <th style="padding-right:15px">مرسل</th>
                            <th>نوعیت سند</th>
                            <th>شماره سند</th>
                            <th>تاریخ سند</th>
                            <th>لسان سند</th>
                            <th>عملیات</th>
                          </tr>
                        </thead>
                        <tbody id="items-for-checkout">
                          <?php $enquired = '';$document_original=false;?>
                          @foreach ($documents = $enquiry->documents as $document)

                            {{-- code for original documents --}}

                            @foreach($document->enquiries as $enquiry)
                              @php
                              if($enquiry->original==1 && $enquiry->returned==0){
                                $document_original = true;
                              }
                              @endphp
                            @endforeach


                            <tr>
                              <td style="padding-right:15px">{{$document->department->name}}</td>
                              <td>{{$document->category->name}}</td>
                              <td>{{$document->number}}</td>
                              <td>{{$document->date}}</td>
                              <td>{{$document->document_language->language_name}}</td>
                              <td>
                                <a href="{{route('browse_images',$document->id)}}" target="_blank"><i style="font-size:1.3em;" class="icon-eye"></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="{{url('remove_enquiry_document/'.$enquiry->id.'/'.$document->id)}}" onclick="confirm('آیا مطمئن هستید این فایل را حذف نمایید؟؟')"><i style="font-size:1.3em;color:#cc0000;" class="icon-trash"></i></a>
                                <span class="badge badge-info" style="margin-top:-6px;">{{$document_original==true?'اصل سند قبلا درخواست گردیده*':''}}</span>
                              </td>
                            </tr>

                            @php
                              // fetch document ids for hidden field
                              $enquired.=$document->id;

                              // concatenate comma if not last item
                              if($document != $documents->last()) {
                                $enquired.=',';
                              }
                            @endphp

                          @endforeach

                        </tbody>
                      </table>
                    </ul>
                    <div class="panel-footer">
                      <a href="#" id="get_documents_datatable" class="btn btn-success">
                        <i style="font-size:1.3em;line-height: 1.6;" class="icon-plus"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div id="documents_datatable">
                <legend>انتخاب اسناد برای درخواستی</legend>
                <table id="documents_datatable_table" class="table table-bordered">
                  <thead>

                    <tr>
                      <th>شماره سند</th>
                      <th>تاریخ</th>
                      <th>موضوع</th>
                      <th>تعداد صفحات</th>
                      <th>نوع سند</th>
                      <th>مرسل</th>
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
        	        		<td class="non_searchable"></td>
        	        	</tr>
        	        </tfoot>
                </table>
              </div>
              <form class="form-horizontal" id="store_enquiry" action="{{route('enquiries.update',$enquiry->id)}}" method="post" enctype="multipart/form-data">
                {{method_field('PATCH')}}
              {{ csrf_field() }}
              {{-- hidden field to store selected documents ids for enquiry --}}
              <input type="hidden" name="document_ids" value="">
              <legend>معلومات درخواستی</legend>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="" class="control-labl col-md-3">شماره مکتوب درخواستی</label>
                    <div class="col-md-9">
                      {{-- <div class="form-group"> --}}
                        <input class="form-control" type="text" value="{{$enquiry->enquiry_number}}" name="enquiry_number">
                      {{-- </div> --}}
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">تاریخ درخواستی</label>
                    <div class="col-md-9">
                      <input type="text" name="request_date" value="{{$enquiry->request_date}}" class="form-control persian_date">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرسل درخواست کننده</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="department_id" id="department_id">
                        <option value="">مرسل درخواست کننده</option>
                        @foreach ($departments as $item)
                          <option {{$item->id == $enquiry->department_id ?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">تایید کننده</label>
                    <div class="col-md-9">
                      <input type="text" name="approval_authority" value="{{$enquiry->approval_authority}}" class="form-control">
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">نوعیت درخواست</label>
                    {{-- <input type="checkbox" id="original" checked="{{ $enquiry->original == 1 ? 'checked' : ''}}" name="original" value="1"> --}}
                    <select name="original" class="form-control" id="original" style="width:150px;">
                      <option value="">نوعیت درخواست</option>
                      <option value="0" {{ $enquiry->original == 0 ? 'selected' : ''}}>کاپی</option>
                      <option value="1" {{ $enquiry->original == 1 ? 'selected' : ''}}>اصلی</option>
                      <option value="2" {{ $enquiry->original == 2 ? 'selected' : ''}}>معلومات</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-5 choose-request-file">
                  <div class="form-group">
                    <label class="control-label col-md-3">فایل درخواستی</label>
                    <a class="btn btn-success" id="choose_file">
                      انتخاب فایل
                    </a>
                    <input id="browse" type="file" name="approved_enquiry_file" value="">
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-5" id="return_date">
                    <div class="form-group">
                      <label class="control-label col-md-3">بازگشت متوقعه</label>
                      <div class="col-md-9">
                        <input type="text" id="expected_return_date" name="expected_return_date" class="form-control persian_date" value="{{$enquiry->expected_return_date}}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-5" id="information">
                    <div class="form-group">
                      <label class="control-label col-md-3">معلومات</label>
                      <div class="col-md-9">
                        {{-- <input type="text" name="expected_return_date" class="form-control persian_date" value="{{old('expected_return_date')}}"> --}}
                        <textarea name="information" rows="4" cols="80" class="form-control">{{old('information')}}</textarea>
                      </div>
                    </div>
                  </div>
              </div>
            </div>


            <div class="form-actions">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-9">
                      <button type="submit" class="btn blue">ثبت</button>
                      <button type="reset" href="#" id="reset_form" class="btn red">حذف اطلاعات</button>
                      <a href="{{route('edit_enquiries')}}" class="btn default">بازگشت</a>
                    </div>
                  </div>
                </div>
              </div>
            </form>
@endsection
@push('custom-css')
  <style media="screen">
    .col-md-9 {
      padding-right: 0;
    }
    .step:not(.active) {
      color: #999;
    }
    .file-location {
      display: none;
    }
    .checker {
      display: none !important;
    }
    #browse {
      display: none;
    }
    .list-group table {
      margin-bottom: 0;
    }

    #documents_datatable {
      display: none;
    }

  </style>

@endpush

@push('custom-js')
  <script>

    // $('.original').click(function() {
    //   $('.file-location').toggle();
    // });
    //
    // $("[name='original']").bootstrapSwitch({
    //   onText: "اصلی",
    //   offText: "کاپی"
    // });
    //
    // $('[name="original"').on('switchChange.bootstrapSwitch', function(event, state) {
    //     $('.file-location').toggle();
    //     if(this.checked){
    //       $("#return_date").css('display','block');
    //       $("#return_date").attr("required", true);
    //     }
    //     else{
    //       $("#return_date").css('display','none');
    //       $("#expected_return_date").val('')
    //     }
    // });


$(document).ready(function(){
    var original = {{$enquiry->original}};
    if(original==0){
      $('#return_date').css('display','none');
      $('#information').css('display','none');
    }
    else if(original==1){
      $('#return_date').css('display','block');
      $('#information').css('display','none');
    }
    else if(original==2){
      $('#information').css('display','block');
      $('#return_date').css('display','none');
    }
});

    $("#original").change(function(){
      if($("#original").val()=='0'){
        $('#return_date').css('display','none');
        $('#information').css('display','none');
      }
      else if($("#original").val()=='1') {
        $('#return_date').css('display','block');
        $('#information').css('display','none');
      }
      else if($("#original").val()=='2'){
        $('#information').css('display','block');
        $('#return_date').css('display','none');
      }
    });

    // choose approved request files by clicking button
    $('#choose_file').click(function() {
      $('#browse').click();
    });

    //store selected documents ids in hidden fields
    $('#store_enquiry').submit(function(e) {
      var document_ids = "{{$enquired}}";
      $('[name="document_ids"]').attr('value',document_ids);
    });

    // display documents datatable to choose another document for current enquiry
    $('#get_documents_datatable').click(function() {
      $('#documents_datatable').toggle();
      if ($('#documents_datatable').css('display') == 'block') {
        showDatatable();
      }
    });

    //fetch documents with all details from Controller
    function showDatatable() {
      $('#documents_datatable_table').DataTable({
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
    }

    //function to attach selected document to current enquiry
    function addToEnquiries(document_id) {
      console.log(document_id);
      window.location.href = "{{url('attach_document_to_enquiry').'/'.$enquiry->id.'/'}}"+document_id;
    }


  </script>

@endpush
