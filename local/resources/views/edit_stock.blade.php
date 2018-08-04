@extends('layouts.master')
@section('title','تصحیح سند جابجا شده')
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
      <form role="form" class="form-horizontal" action="{{route('update_stock',$document->id)}}" enctype="multipart/form-data" method="post">
          {{csrf_field()}}
          {{method_field("PATCH")}}
          <div class="form-wizard">
            <div class="form-body">
              <ul class="nav nav-pills nav-justified steps">
                <li class="active">
                  <a href="#tab1" class="step active">
                    <span class="number">
                    1 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> ثبت اسناد </span>
                  </a>
                </li>
                <li>
                  <a href="#tab2" class="step">
                    <span class="number">
                    2 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> تاییدی اسناد </span>
                  </a>
                </li>
                <li>
                  <a  class="step">
                    <span class="number">
                    3 </span>
                    <span class="desc">
                    <i class="fa fa-check"></i> جابجایی اسناد </span>
                  </a>
                </li>

              </ul>
              <div id="bar" class="progress progress-striped" role="progressbar">
                <div class="progress-bar progress-bar-success" style="width:65%;">
                </div>
              </div>

          </div>
          <div class="form-body">
            <h3 class="form-section">معلومات عمومی سند</h3>
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">شماره</label>
                          <div class="col-md-9">
                              <input type="number" name="document_number" disabled="disabled" value="{{$document->number}}" placeholder="شماره" class="form-control">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="control-label col-md-3">تاریخ</label>
                          <div class="col-md-9">
                              <input type="text" name="document_date" disabled="disabled" value="{{$document->date}}" placeholder="تاریخ" class="form-control persian_date">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">موضوع</label>
                    <div class="col-md-9">
                      <textarea name="document_subject" value="" disabled="disabled" placeholder="موضوع" rows="2" class="form-control">{{$document->subject}}</textarea>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">تعداد صفحات</label>
                    <div class="col-md-9">
                      <input type="number" name="document_page_count" disabled="disabled" value="{{$document->total_pages}}" placeholder="تعداد صفحات" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">نوع سند</label>
                    <div class="col-md-9">
                      <select class="form-control select2" disabled="disabled" name="document_categories" id="categories_id">
                          <option value="{{$document->category_id}}">{{$document->category->name}}</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">مرسل</label>
                    <div class="col-md-9">
                      <select class="form-control select2" disabled="disabled" name="document_department" id="department_id">
                          <option value="{{$document->department_id}}">{{$document->department->name}}</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <h3 class="form-section">موقعیت فزیکی سند</h3>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">بلاک</label>
                    <div class="col-md-9">
                      <select name="block" class="form-control">
                        <option value="">بلاک</option>
                        <option {{$document->block == '01' ? 'selected' : ''}} value="01">01</option>
                        <option {{$document->block == '02' ? 'selected' : ''}} value="02">02</option>
                        <option {{$document->block == '03' ? 'selected' : ''}} value="03">03</option>
                        <option {{$document->block == '04' ? 'selected' : ''}} value="04">04</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">قطار</label>
                    <div class="col-md-9">
                      <select name="section" class="form-control">
                        <option value="">بخش</option>
                        <option {{$document->section == 'A' ? 'selected' : ''}} value="A">A</option>
                        <option {{$document->section == 'B' ? 'selected' : ''}} value="B">B</option>
                        <option {{$document->section == 'C' ? 'selected' : ''}} value="C">C</option>
                        <option {{$document->section == 'D' ? 'selected' : ''}} value="D">D</option>
                        <option {{$document->section == 'E' ? 'selected' : ''}} value="E">E</option>
                        <option {{$document->section == 'F' ? 'selected' : ''}} value="F">F</option>
                        <option {{$document->section == 'G' ? 'selected' : ''}} value="G">G</option>
                        <option {{$document->section == 'H' ? 'selected' : ''}} value="H">H</option>
                        <option {{$document->section == 'I' ? 'selected' : ''}} value="I">I</option>
                        <option {{$document->section == 'J' ? 'selected' : ''}} value="J">J</option>
                      </select>
                      {{-- <input type="number" name="sequence" value="{{$document->sequence}}" placeholder="قطار" class="form-control"> --}}
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">الماری</label>
                    <div class="col-md-9">
                      <input type="number" name="row" value="{{$document->row}}" placeholder="الماری" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">طرف الماری</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="cabinet_side" id="cabinet_side">
                        <option value="">طرف الماری</option>
                        <option {{$document->cabinet_side == 'A' ? 'selected' : ''}} value="A">A</option>
                        <option {{$document->cabinet_side == 'B' ? 'selected' : ''}} value="B">B</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">روک</label>
                    <div class="col-md-9">
                       <select name="cabinet_row" class="form-control">
                         <option value="">روک</option>
                         <option {{$document->cabinet_row == '01' ? 'selected' : ''}} value="01">01</option>
                         <option {{$document->cabinet_row == '02' ? 'selected' : ''}} value="02">02</option>
                         <option {{$document->cabinet_row == '03' ? 'selected' : ''}} value="03">03</option>
                         <option {{$document->cabinet_row == '04' ? 'selected' : ''}} value="04">04</option>
                         <option {{$document->cabinet_row == '05' ? 'selected' : ''}} value="05">05</option>
                         <option {{$document->cabinet_row == '06' ? 'selected' : ''}} value="06">06</option>
                       </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">شماره دوسیه</label>
                    <div class="col-md-9">
                      {{-- <input type="number" name="cabinet_column" value="{{$document->cabinet_column}}" placeholder="شماره دوسیه" class="form-control"> --}}
                      <select name="cabinet_column" class="form-control">
                        <option value="">شماره دوسیه</option>
                        <option {{$document->cabinet_column == '01' ? 'selected' : ''}} value="01">01</option>
                        <option {{$document->cabinet_column == '02' ? 'selected' : ''}} value="02">02</option>
                        <option {{$document->cabinet_column == '03' ? 'selected' : ''}} value="03">03</option>
                        <option {{$document->cabinet_column == '04' ? 'selected' : ''}} value="04">04</option>
                        <option {{$document->cabinet_column == '05' ? 'selected' : ''}} value="05">05</option>
                        <option {{$document->cabinet_column == '06' ? 'selected' : ''}} value="06">06</option>
                        <option {{$document->cabinet_column == '07' ? 'selected' : ''}} value="07">07</option>
                        <option {{$document->cabinet_column == '08' ? 'selected' : ''}} value="08">08</option>
                        <option {{$document->cabinet_column == '09' ? 'selected' : ''}} value="09">09</option>
                        <option {{$document->cabinet_column == '10' ? 'selected' : ''}} value="10">10</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">جلد</label>
                    <div class="col-md-9">
                      <select class="form-control select2" name="edition" id="edition">
                        <option value="">جلد</option>

                        <option value="1" selected="{{$document->cabinet_row =='1'?'selected':''}}">1</option>
                        <option value="2" selected="{{$document->cabinet_row =='2'?'selected':''}}">2</option>
                        <option value="3" selected="{{$document->cabinet_row =='3'?'selected':''}}">3</option>
                        <option value="4" selected="{{$document->cabinet_row =='4'?'selected':''}}">4</option>
                        <option value="5" selected="{{$document->cabinet_row =='5'?'selected':''}}">5</option>
                        <option value="6" selected="{{$document->cabinet_row =='6'?'selected':''}}">6</option>
                        <option value="7" selected="{{$document->cabinet_row =='7'?'selected':''}}">7</option>
                        <option value="8" selected="{{$document->cabinet_row =='8'?'selected':''}}">8</option>
                        <option value="9" selected="{{$document->cabinet_row =='9'?'selected':''}}">9</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-9">
                    <div class="md-checkbox has-default">
                      <input type="checkbox" name="checkbox" id="checkbox9" class="md-check" checked>
                      <label for="checkbox9">
                      <span class="inc"></span>
                      <span class="check"></span>
                      <span class="box"></span>
                      چاپ فهرست و لیبل
                     </label>
                    </div>
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
                    <button type="submit" class="btn blue">تصحیح</button>
                    <a href="{{route('stockable_documents')}}" class="btn default">بازگشت</a>
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

  </style>

@endpush
@push('custom-js')
  <script>

    // reset whole form
    $('#reset_form').click(function() {
      console.log($(this));
    });
  </script>

@endpush
