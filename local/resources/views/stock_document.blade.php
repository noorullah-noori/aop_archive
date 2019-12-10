@extends('layouts.master')
@section('title','جابجایی سند')
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
      <form role="form" class="form-horizontal" action="{{route('stock_document',$document->id)}}" enctype="multipart/form-data" method="post">
          {{csrf_field()}}
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
                  <label class="control-label col-md-3">تعداد اوراق</label>
                  <div class="col-md-9">
                    <input type="number" name="document_page_count" disabled="disabled" value="{{$document->total_pages}}" placeholder="تعداد صفحات" class="form-control">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
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
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">مرسل الیه </label>
                  <div class="col-md-9">
                    <input type="text" name="receiver" disabled="disabled"   value="{{$document->receiver}}" placeholder="مرسل الیه " class="form-control ">

                  </div>
                </div>
              </div>
             </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">موضوع</label>
                  <div class="col-md-9">
                    <textarea name="document_subject" value="" disabled="disabled" lang="fa" placeholder="موضوع" rows="2" class="form-control">{{$document->subject}}</textarea>
                  </div>
                </div>
              </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">ضمایم</label>
                  <div class="col-md-9">

                    <textarea name="description" value=""  lang="fa" disabled="disabled" placeholder="ضمایم" rows="2" class="form-control">{{$document->description}}</textarea>

                  </div>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label col-md-3">لسان سند</label>
                  <div class="col-md-9">
                      <select class="form-control select2" disabled="disabled" name="document_department" id="department_id">
                          <option value="{{$document->document_language_id}}">{{$document->document_language->language_name}}</option>
                      </select>
                  </div>
                </div>
              </div>
            </div>
              <h3 class="form-section">موقعیت فزیکی سند</h3>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">سال</label>
                    <div class="col-md-9">
                      <div class="col-md-4">
                        <select name="cabinet_year" id="cabinet_year" class="form-control select2">
                          <option value="">سال</option>
                          <?php
                             for ($year = 1380; $year <= 1410; $year++){
                               echo"<option value='".$year."'>$year</option>";
                             };

                             ?>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <select name="cabinet_number" id="cabinet_number" class="form-control select2">
                        <option value=""> شماره الماری</option>
                        <?php
                        for ($i = 1; $i <= 20; $i++){
                          echo"<option value='".$i."'>$i</option>";
                        };
                        ?>
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
                      <select name="row" id="row" class="form-control select2">
                        <option value="">روک</option>
                        <?php
                          for ($i = 1; $i <= 15; $i++){
                            echo"<option value='".$i."'>$i</option>";
                          };

                          ?>
                      </select>
                      {{-- <input type="number" name="sequence" value="{{old('sequence')}}" placeholder="قطار" class="form-control"> --}}
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3">فولدر</label>
                    <div class="col-md-9">
                      <select name="folder" id="folder" class="form-control select2">
                        <option value="">فولدر</option>
                        <?php
                          for ($i = 1; $i <= 15; $i++){
                            echo"<option value='".$i."'>$i</option>";
                          };

                          ?>
                      </select>
                      {{-- <input type="number" name="sequence" value="{{old('sequence')}}" placeholder="قطار" class="form-control"> --}}
                    </div>
                  </div>
                </div>

              </div>

                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label col-md-3"> شماره فایل</label>
                     <div class="col-md-9">
                       <select name="file" id="file"  class="form-control select2">
                         @for ($i =1 ; $i <= 500; $i++)
                          <option value="{{$i}}">{{$i}}</option>
                         @endfor
                       </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
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
                    <button type="submit" class="btn blue">ثبت</button>
                    <button type="reset" href="#" id="reset_form" class="btn red">حذف اطلاعات</button>
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


    // $("#folder").change(function(){

    //   var data = {};

    //   data['year'] = $("#cabinet_year").val();
    //   data['number'] = $("#cabinet_number").val();
    //   data['row'] = $("#row").val();
    //   data['folder'] = $("#folder").val();
    //   data['category_id'] = $("#categories_id").val();

    //   $.ajax({
    //     type: "GET",
    //     data:data,
    //     url: "{{url('get_folder_count/')}}",
    //     success: function(result) {
    //         result = Number(result);
    //         $("#file").val(result+1);
    //     },
    //     error: function(result) {
    //         alert('error');
    //     }
    // });
    // });

//     $("#row").change(function(){

//     var data = {};

//     data['year'] = $("#cabinet_year").val();
//     data['number'] = $("#cabinet_number").val();
//     data['row'] = $("#row").val();
//     data['category_id'] = $("#categories_id").val();

//     $.ajax({
//       type: "GET",
//       data:data,
//       url: "{{url('get_available_folders/')}}",
//       success: function(result) {
//         $("#folder").empty();
//         $.each(result, function(index ,val){
//           $("#folder").append(
//             $('<option></option>').val(val.folder).html("<i class='icon-folder-alt'> فولدر  "+val.folder+"</i>   ---- "+val.folder_count+"فایل ")
//           );
//         })
//       },
//       error: function(result) {
//           alert('error');
//       }
//     });
// });

  </script>

@endpush
