@extends('layouts.master')
@section('title','نمایش سند')
@section('content')
  <div class="portlet light">
    <div class="portlet-title">

      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="form-horizontal">
        <div class="form-body">
            <h3 class="form-section">معلومات عمومی سند</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">شماره سند:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->number}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">تاریخ:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->date}}
                            </p>
                        </div>
                    </div>
                </div>

                <!--/span-->
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">موضوع:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->subject}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">تعداد صفحات:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->total_pages}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">نوع سند:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->category->name}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">مرسل:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->department->name}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label col-md-3">لسان سند:</label>
                      <div class="col-md-9">
                          <p class="form-control-static">
                               {{$document->document_language->language_name}}
                          </p>
                      </div>
                  </div>
              </div>
                <!--/span-->
            </div>
            <!--/row-->
            @if($document->status==3)
            <hr>
            <h3 class="form-section">موقعیت فزیکی سند</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">بلاک:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                            {{$document->block}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">بخش:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->section}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">الماری:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->row}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">طرف الماری:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->cabinet_side}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!--/row-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">روک:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->cabinet_row}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">شماره دوسیه:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->cabinet_column}}
                            </p>
                        </div>
                    </div>
                </div>
                <!--/span-->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">تعداد جلد:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->edition}}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">لیبل:</label>
                        <div class="col-md-9">
                            <p class="form-control-static">
                                 {{$document->label}}
                            </p>
                        </div>
                    </div>
                </div>

                <!--/span-->
            </div>
          @endif
        </div>
      </div>
      <h4>فایل های مربوط اسناد</h4>
     <hr>
        {{-- file images starts --}}
        <div class="row mix-grid">
          {{-- document images count from db --}}
          <?php $db_files_count = 0;?>

          @foreach ($document->uploads as $file)
            <?php $db_files_count++; ?>
            <div class="col-md-3 col-sm-4 mix category_1 mix_all fancybox" style="display: block;  opacity: 1;">
              <div class="mix-inner">
                <img class="img-responsive" src="{{asset($file->file_path)}}" alt="">
                <div class="mix-details">
                  <div class="links">
                    <a class="mix-preview fancybox-button" href="{{asset($file->file_path)}}" data-rel="fancybox-button">
                      <i class="icon-size-fullscreen"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        {{-- file images ends --}}
        <hr>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <a href="{{URL::previous()}}" class="btn btn-default">برگشت</a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('custom-js')
  <script type="text/javascript">

  </script>
@endpush
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
    .mix-grid .mix .mix-details {
      background: #0da3e273;
    }
    .links {
      margin-top: 4em;
    }
    .mix-grid .mix a.mix-preview{
      right: 40% !important;
    }
  </style>

@endpush
