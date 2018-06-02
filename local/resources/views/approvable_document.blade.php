@extends('layouts.master')
@section('title','تاییدی سند')
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
        <div class="form-horizontal">
          <div class="form-body">
              <h3 class="form-section">معلومات عمومی سند</h3>
              <hr>
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
              <!--/row-->
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
      </div>
      <h4>فایل های مربوط اسناد</h4>
      {{-- <div class="row">
          @foreach($uploads as $upload)
            <div class="col-md-3">
              <img src="{{asset($upload->file_path)}}" class="img-thumbnail">
            </div>
          @endforeach
      </div> --}}
      <hr>
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

      <div class="row">
        <a href="{{route('approve_document',$document->id)}}" class="btn btn-primary">تایید</a>
         <button type="button" data-toggle="modal" data-target="#rejectModal" class="btn btn-danger">رد</button>
         <a href="{{URL::previous()}}" class="btn btn-default">بازگشت</a>
      </div>
    </div>
  </div>
@endsection

<!-- Modal  for Rejecting document-->
<div id="rejectModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-title">رد&nbsp;&nbsp;"{{$document->subject}}"</h4>
      </div>
      <div class="modal-body">
          <form role="form" class="form-horizontal" action="{{route('reject_document',$document->id)}}" method="post">
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
        <button type="submit" class="btn btn-danger" style="float: right !important;">رد</button>
        <button type="button" class="btn btn-default" style="float:right !important;" data-dismiss="modal">بازگشت</button>
      </div>
      </form>
    </div>

  </div>
</div>

{{-- Modal Ends --}}



@push('custom-js')
  <script type="text/javascript">

  </script>
@endpush
@push('custom-css')
  <style media="screen">
    td {
      font-size: .8em;
    }
    .mix-grid .mix .mix-details {
      background: #0da3e273;
    }
    /*.links {
      margin-top: 4em;
    }*/
    .row {
      margin: 0;
    }
    .col-md-3.col-sm-4.mix.category_1.mix_all.fancybox {
      padding-right: 0 !important;
    }
  </style>

@endpush
