@extends('layouts.master')
@section('title','گزارش اسناد')
@section('content')
  <div class="portlet light">
    <div class="portlet-title">

      <div class="caption">
          <i class="fa fa-file-text-o font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
    </div>
    <div class="portlet-body">
      <div class="row">
        <div class="col-md-10">
          <form id="search_form" action="" method="post" class="form-inline">
            {{ csrf_field() }}
            <div class="form-body">
              <div class="form-group">

                <label class="radio-inline">
                  <input type="radio" name="date_type" class="toggle_dates" id="date"  > تاریخ
                </label>

                <label class="radio-inline">
                  <input type="radio" name="date_type" class="toggle_dates" id="two_dates" checked> بین دو تاریخ
                </label>

              </div>

              <div class="form-group single_date_picker">
                <input type="text" id="single_date" name="single_date" value="" placeholder="تاریخ" class="form-control persian_date ">
              </div>

              <div class="form-group between_dates_picker">
                <input type="text" id="from_date" name="from_date" value="" placeholder="از تاریخ" class="form-control persian_date ">
              </div>

              <div class="form-group between_dates_picker">
                <input type="text" id="to_date" name="to_date" value="" placeholder="الی تاریخ" class="form-control persian_date ">
              </div>

              <div class="form-group">
                <select class="form-control" name="document_status" id="">
                  {{-- <option value="">نوع سند</option> --}}
                  <option  value="">حالت</option>
                  <option  value="0">اسناد ثبت شده</option>
                  <option  value="1">اسناد تایید شده</option>
                  <option  value="2">اسناد رد شده</option>
                  <option  value="3">اسناد جابجا شده</option>
                </select>
              </div>
              <div class="form-group">
                <button id="search_form_submit" class="btn btn-success">
                  <i class="icon-magnifier" style="font-size:1.3em !important;"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div id="searchData">
      {{-- load ajax table --}}
    </div>
  </div>

      {{-- {{$documents->links()}} --}}
    </div>
  </div>
@endsection

@push('custom-js')
  <script type="text/javascript">
  $(function() {

    $('.toggle_dates').click(function() {
      console.log($(this));
      $("#search_form").trigger("reset");
      if(this.id == 'date') {
        $('.form-group.between_dates_picker').hide();
        $('.form-group.single_date_picker').css('display','inline-block');


      }
      else {
        $('.form-group.between_dates_picker').css('display','inline-block');
        $('.form-group.single_date_picker').hide();

      }
    });
  })

  </script>

      <script type="text/javascript">

        $(document).ready(function() {
          $('#search_form_submit').click(function(){
            var dataString = $('#search_form').serialize();
             $.ajax({
                  type:'POST',
                  url:'{!!URL::route("get_documents_reports")!!}',
                  data: dataString,
                  success:function(response){

                     $('#searchData').html(response);
                  }
                 })

                return false;
               });
        });


    </script>

@endpush
@push('custom-css')
  <style media="screen">
    .radio-inline {
      padding-right: 0;
    }
    .form-group {
        padding-left: 10px;
    }
    form.form-inline {
      margin-bottom: 20px;
    }
    .form-group .btn.btn-success {
      padding-bottom: 0px;
      padding-right: 7px;
      padding-left: 7px;
    }
    .alert.alert-success {
      padding: 10px;
    }
    .form-group.single_date_picker {
      display: none;
    }
  </style>

@endpush
