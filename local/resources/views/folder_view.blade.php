@extends('layouts.master')
@section('title','نمایش فولدرها')
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
                    <select name="cabinet_year" id="cabinet_year" class="form-control">
                        <option value="">سال</option>
                        <option value="1380">1380</option>
                        <option value="1381">1381</option>
                        <option value="1382">1382</option>
                    </select>
                </label>

                <label class="radio-inline">
                  <select name="cabinet_number" id="cabinet_number" class="form-control">
                        <option value="">شماره</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                      </select>
                </label>
                
                <label class="radio-inline">
                  <select name="row" id="cabinet_number" class="form-control">
                        <option value="">روک</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                      </select>
                </label>

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

        $(document).ready(function() {
          $('#search_form_submit').click(function(){
            var dataString = $('#search_form').serialize();
             $.ajax({
                  type:'POST',
                  url:'{!!URL::route("get_folders")!!}',
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
