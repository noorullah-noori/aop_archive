@extends('layouts.master')
@section('title','اضافه نمودن سند')
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
      <form role="form" id="entry_form" class="form-horizontal" action="{{route('documents.store')}}" enctype="multipart/form-data" method="post">
          {{csrf_field()}}
          <div class="form-wizard">
            <div class="form-body">
              <ul class="nav nav-pills nav-justified steps">
                <li class="active">
                  <a href="#" class="step active">
                    <span class="number">
                    1 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> ثبت اسناد </span>
                  </a>
                </li>
                <li>
                  <a href="#" class="step">
                    <span class="number">
                    2 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> تاییدی اسناد </span>
                  </a>
                </li>
                <li>
                  <a  href="#" class="step">
                    <span class="number">
                    3 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> جابجایی اسناد </span>
                  </a>
                </li>

              </ul>
              <div id="bar" class="progress progress-striped" role="progressbar">
                <div class="progress-bar progress-bar-success" style="width:5%;">
                </div>
              </div>

          </div>
          <div class="form-body">
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">شماره</label>
                          <div class="col-md-9">
                              <input type="number" name="document_number" value="{{old('document_number')}}" placeholder="شماره" class="form-control">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">تاریخ</label>
                          <div class="col-md-9">
                              <input type="text" name="document_date" value="{{old('document_date')}}" placeholder="تاریخ" class="form-control persian_date">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">موضوع</label>
                    <div class="col-md-9">
                      <textarea name="document_subject" value="" placeholder="موضوع" rows="2" class="form-control">{{old('document_subject')}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">تعداد اوراق</label>
                    <div class="col-md-9">
                      <input type="number" name="document_page_count" value="{{old('document_page_count')}}" placeholder="تعداد صفحات" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">نوع سند</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="document_categories" id="categories_id">
                        <option value="">نوع سند</option>
                        @foreach ($categories as $item)
                          <option {{$item->id==old('document_categories')?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرسل</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="document_department" id="department_id">
                        <option value="">مرسل</option>
                        @foreach ($departments as $item)
                          <option {{$item->id==old('document_department')?'selected':''}} value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">اسکن</label>
                    <div class="col-md-9 upload">
                      <a href="#" id="choose_file" class="btn green-jungle scan_or_upload">
                        <i class="icon-picture"></i>
                        انتخاب فایل ها
                      </a>
                      <input id="browse" type="file" multiple name="selected_files[]" value="">
                      <span>- و یا -</span>
                      <button type="button" onclick="scanToJpg();" class="btn grey-gallery scan_or_upload">
                        <i class="icon-printer"></i>
                        اسکن
                      </button>
                    </div>
                    <div id="images"></div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-9" id="count_selected_files">
                      {{-- <a href="#" id="" class="btn green">

                      </a> --}}
                    </div>
                  </div>
                </div>
              </div>
          </div>

          <div class="form-actions">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3"></label>
                  <div class="col-md-9">
                    <button type="submit" class="btn blue">ثبت</button>
                    <button type="reset" href="#" id="reset_form" class="btn red">حذف اطلاعات</button>
                    <a href="{{route('documents.index')}}" class="btn default">بازگشت</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
  </div>
@endsection
@push('custom-css')
  <style media="screen">
    .col-md-9 {
      padding-right: 0;
    }
    .step:not(.active) {
      color: #999;
    }
    .upload span {
      padding: 10px;
    }
    .upload input {
      display: none;
    }

     img.scanned {
            height: 200px; /** Sets the display size */
            margin-right: 12px;
        }
        div#images {
            margin-top: 20px;
        }
  </style>

@endpush
@push('custom-js')
  <script>
    // persian date picker
    $(function() {
      $(".persian_date").persianDatepicker();
    });

    // scan or upload buttons alternating
    $('.scan_or_upload').click(function() {
      $(this).siblings().not($(this)).addClass('disabled');
    });

    // reset whole form
    $('#reset_form').click(function() {
      // enable upload keys if previously disabled
      $('.scan_or_upload').removeClass('disabled');
      // remove uploaded files count notification
      $('#count_selected_files').hide();

      $('select').find('option:selected').remove()
    });

    // choose multiple files by clicking button
    $('#choose_file').click(function() {
      $('#browse').click();
    });

    // selected file notification & validation
    $(document).ready(function() {
      $('input[type="file"]').change(function () {

        var total_pages = $("input[name='document_page_count']").val()*2;
        var total_selected_files = $(this)[0].files.length;
        // if files more than total pages selected disable submit and show error else show notification
        if(total_selected_files>total_pages) {
          $('#count_selected_files').html("<div class='alert alert-danger'>تعداد فایل ها بیشتر از تعداد اوراق میباشد </div>");
          $('button[type=submit]').addClass('disabled');
        }
        else {
          $('#count_selected_files').html("<div class='alert alert-info'>"+total_selected_files+" فایل انتخاب گردید!!!</div>");
          $('button[type=submit]').removeClass('disabled');
        }
      });
    });





  </script>

@endpush
