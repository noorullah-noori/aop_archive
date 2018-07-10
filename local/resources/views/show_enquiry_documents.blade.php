@extends('layouts.master')
@section('title','تصحیح سند ثبت شده')
@section('content')
  <div class="portlet light">
  	<div class="portlet-title">

      <div class="caption">
          <i class="fa fa-edit font-green-sharp"></i>
          <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
      </div>
  	</div>
  	<div class="portlet-body form">

        <div class="row">
                <div class="row mix-grid">
                  {{-- document images count from db --}}
                  <?php $db_files_count = 0;?>

                  @foreach ($uploads as $file)
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
                <a href="{{URL::previous()}}" class="btn btn-default">Back</a>
        </div>


        {{-- file images ends --}}
        <hr>
  </div>
@endsection
@push('custom-css')
  <style media="screen">
    .mix-grid .mix .mix-details {
      background: #0da3e287;
    }
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

  </style>

@endpush
@push('custom-js')
  <script>
  </script>

@endpush
