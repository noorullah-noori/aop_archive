@extends('layouts.master')
@section('title','درخواست سند')
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
      @component('components.alert')
        @slot('alert_type')
           success
        @endslot
      @endcomponent
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
                              <th>مرسل</th>
                              <th>نوعیت سند</th>
                              <th>شماره سند</th>
                              <th>تاریخ سند</th>
                              <th>نمایش</th>
                            </tr>
                          </thead>
                          <tbody id="items-for-checkout">
                            <?php $enquired = ''; $document_original = false;?>
                            @foreach ($documents as $document)

                              {{-- code for original documents --}}

                              @foreach($document->enquiries as $enquiry)
                                @php
                                if($enquiry->original==1 && $enquiry->returned==0){
                                  $document_original = true;
                                }
                                else {
                                  $document_original = false;
                                }
                                @endphp
                              @endforeach


                              <tr>
                                <td>{{$document->department->name}}</td>
                                <td>{{$document->category->name}}</td>
                                <td>{{$document->number}}</td>
                                <td>{{$document->date}}</td>
                                <td>
                                  <a href="{{route('browse_images',$document->id)}}" target="_blank"><i style="font-size:1.3em;" class="icon-eye"></i></a>
                                  @if ($document_original==true)
                                    <span class='badge badge-warning' style='line-height:1.3;margin-bottom:5px;'>* اصل سند قبلا درخواست گردیده</span>
                                  @endif

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
                  </div>
                </div>
              </div>
              <form class="form-horizontal" id="store_enquiry" action="{{route('enquiries.store')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              {{-- hidden field to store selected documents ids for enquiry --}}
              <input type="hidden" name="document_ids" value="">
              <legend>معلومات درخواستی</legend>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="" class="control-labl col-md-3">شماره سند </label>
                    <div class="col-md-9">
                      {{-- <div class="form-group"> --}}
                        <input class="form-control" value="{{old('enquiry_number')}}" type="text" name="enquiry_number">
                      {{-- </div> --}}
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">تاریخ </label>
                    <div class="col-md-9">
                      <input type="text" name="request_date" value="{{old('request_date')}}" class="form-control persian_date">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرجع</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="department_id" id="department_id">
                        <option value="">مرجع درخواست کننده</option>
                        @foreach ($departments as $item)
                          <option {{$item->id==old('department_id')?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">هدایت دهنده</label>
                    <div class="col-md-9">
                      <input type="text" name="approval_authority" lang="fa" value="{{old('approval_authority')}}" class="form-control">
                    </div>
                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="control-label col-md-3">نوعیت درخواست</label>
                    {{-- <input type="checkbox" name="original" value="1" {{old('original')!=null ? 'checked' : ''}} {{$document_original==true?'disabled':''}}> --}}
                    <select name="original" class="form-control" id="original" style="width:150px;">
                      <option value="">نوعیت درخواست</option>
                      <option value="0">کاپی</option>
                      <option value="1" {{$document_original==true?'disabled':''}}>اصلی</option>
                      <option value="2">معلومات</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-5 choose-request-file">
                  <div class="form-group">
                    <label class="control-label col-md-3">فایل</label>
                    <a class="btn btn-success" id="choose_file">
                      انتخاب فایل
                    </a>
                    <input id="browse" type="file" name="approved_enquiry_file" value="">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-5" id="return_date" style="display:none">
                  <div class="form-group">
                    <label class="control-label col-md-3">بازگشت متوقعه</label>
                    <div class="col-md-9">
                      <input type="text" name="expected_return_date" class="form-control persian_date" value="{{old('expected_return_date')}}">
                    </div>
                  </div>
                </div>


                <div class="col-md-5" id="information" style="display:none">
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
                      <a href="{{route('enquiries.index')}}" class="btn default">بازگشت</a>
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
    // $(window).load(function() {
    //   if($('[name="original"').attr('checked')) {
    //     $('#return_date').toggle();
    //   }
    // })
    //
    // $('[name="original"').on('switchChange.bootstrapSwitch', function(event, state) {
    //     $('#return_date').toggle();
    // });
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
    })


  </script>

@endpush
