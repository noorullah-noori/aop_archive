@extends('layouts.master')
@section('title','لسان سند')
@section('content')
@section('content')
<div class="portlet light">
	<div class="portlet-title">

    <div class="caption">
        <i class="fa fa-file-text-o font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
    </div>
    <a href="{{route('show_language_form')}}" class="btn btn-success pull-right">
      <i class="fa fa-plus"></i>
      اضافه
    </a>
	</div>
 	<div class="portlet-body">
    {{-- print <alerts></alerts> if present --}}
    @component('components.alert')
      @slot('alert_type')
         success
      @endslot
    @endcomponent
    {{-- <div class="alert alert-danger">Hey</div> --}}
		<div class="table-container" style="">
      <table id="language-datatable" class="table table-bordered">
        <thead>
          <tr>
            <th>شماره</th>
            <th>لسان سند</th>
            <th>عملیات</th>
          </tr>
        </thead>
      </table>



          <div id="language" class="modal fade" tabindex="-1" data-width="400">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <div class="caption">
                          <i class="fa fa-edit font-green-sharp"></i>
                          <span class="caption-subject font-green-sharp bold uppercase">تغییر نمودن لسان</span>
                       </div>
                     </div>
                    <div class="modal-body">
                      <div class="row">
                         <form role="form" class="form-horizontal" action="PATCH" >
                                 {{method_field('PATCH')}}
                                 {{csrf_field()}}
                          <div class="form-body col-md-10 col-md-offset-1">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">لسان</label>
                                  <div class="col-md-10">
                                    <input type="text" class="form-control" id="language_name" name="language_name" value="">
                                  </div>
                              </div>


                          </div>
                          <div class="form-actions">
                              <div class="row">
                                  <div class="col-md-offset-2 col-md-8" style="padding-right:10px;  margin-right: 23%;">
                                    <button type="submit" class="btn blue">تصحیح</button>


                                  </div>
                              </div>
                          </div>

                  </form>
                  </div>
                </div>
              </div>

			</div>
		</div>
	</div>
 </div>
</div>
@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#language-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_document_language')}}',
      columns: [
          {data: 'id', name: 'id'},
          {data: 'language_name', name: 'language_name'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    function openmodel(id){

       $.ajax({
        type: "GET",
        url: "{{url('select_language')}}"+'/'+id,
        success: function(result) {
          $('form').attr('action',"{{url('update_language')}}"+"/"+result['id']);
          $('#language_name').val(result['language_name']);
          $('#language').modal('show');

        },
        error: function(result) {
            alert('error');
        }
    });
    }


  </script>

@endpush
@push('custom-css')
  <style media="screen">

  </style>

@endpush
