@extends('layouts.master')
@section('title','بازگشت اسناد')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">

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
      <form role="form" class="form-horizontal" action="{{route('return_documents',$enquiry->id)}}" enctype="multipart/form-data" method="post">
          {{csrf_field()}}
          <div class="form-wizard">
            <div class="row">
                <div class="col-md-6">
                  <div class="panel panel-warning">
                      <!-- Default panel contents -->
                      <div class="panel-heading">
                          <h3 class="panel-title">اسناد مربوطه درخواستی</h3>
                      </div>
                      <!-- List group -->
                      <table class="table table-stripped">
                        <tr>
                          <th>#</th>
                          <th>شماره مکتوب</th>
                          <th>موضوع</th>
                          <th>مرسل</th>
                          <th>نوعیت سند</th>
                          <th>لسان سند</th>
                          <th>فایلها</th>
                        </tr>
                        <?php $i=1; ?>
                          @foreach($enquiry->documents as $document)
                              <tr>
                               <td>{{$i}}</td>
                               <td>{{$document->number}}</td>
                               <td>{{$document->subject}}</td>
                               <td>{{$document->department->name}}</td>
                               <td>{{$document->category->name}}</td>
                               <td>{{$document->document_language->language_name}}</td>

                               <td><a href="{{route('browse_images',$document->id)}}" target="_blank" class="icon-eye"></a></td>
                              </tr>
                              <?php $i++; ?>
                          @endforeach
                      </table>
                  </div>
                </div>
            </div>
            <div class="form-body">
              <legend>معلومات بازگشتی</legend>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label col-md-3">تاریخ بازگشت</label>
                    <div class="col-md-9">
                      <input type="text" name="return_date" value="{{old('return_date')}}" required class="form-control persian_date">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label col-md-3">ملاحظات</label>
                    <div class="col-md-9">
                      <textarea name="remarks" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-actions">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label col-md-3"></label>
                    <div class="col-md-9">
                      <button type="submit" class="btn blue">ثبت</button>
                      <a href="{{route('show_enquiries')}}" class="btn default">بازگشت</a>
                    </div>
                  </div>
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

  </style>

@endpush
@push('custom-js')
  <script>
    // choose approved request files by clicking button
    $('#choose_file').click(function() {
      $('#browse').click();
    });


  </script>

@endpush
