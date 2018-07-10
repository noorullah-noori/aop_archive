@extends('layouts.master')
@section('title','نوعیت اسناد')
@section('content')
@section('content')
<div class="portlet light">
	<div class="portlet-title">

    <div class="caption">
        <i class="fa fa-file-text-o font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
    </div>
    <a href="{{route('categories.create')}}" class="btn btn-success pull-right">
      <i class="fa fa-plus"></i>
      اضافه
    </a>
	</div>
 	<div class="portlet-body ">
    {{-- print <alerts></alerts> if present --}}
    @component('components.alert')
      @slot('alert_type')
         success
      @endslot
    @endcomponent
    {{-- <div class="alert alert-danger">Hey</div> --}}
		<div class="table-container" style="">
      <table id="categories-datatable" class="table table-bordered">
        <thead>
          <tr>
            <th>شماره</th>
            <th>نوعیت اسناد</th>
            <th>توضیحات</th>
            <th>عملیات</th>
          </tr>
        </thead>
      </table>



          <div id="stack1" class="modal fade" tabindex="-1" data-width="400">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <div class="caption">
                          <i class="fa fa-edit font-green-sharp"></i>
                          <span class="caption-subject font-green-sharp bold uppercase">تغییر نمودن نوعیت اسناد</span>
                       </div>
                     </div>
                    <div class="modal-body">
                      <div class="row">
                         <form role="form" class="form-horizontal" action="" method="post">
                                 {{method_field('PATCH')}}
                                 {{csrf_field()}}
                          <div class="form-body col-md-10 col-md-offset-1">

                              <div class="form-group">
                                  <label class="col-md-2 control-label">نوعیت سند</label>
                                  <div class="col-md-10">
                                    <input type="text" class="form-control" id="category_name" name="category_name" value="">
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label class="col-md-2 control-label">توضیحات</label>
                                  <div class="col-md-10">
                                    <textarea name="category_description" id="description" class="form-control" rows="8" cols="80"></textarea>
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
    $('#categories-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_categories_datatable')}}',
      columns: [
          {data: 'id', name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'description', name: 'description'},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    function openmodel(id){

       $.ajax({
        type: "GET",
        url: "{{url('categories/')}}"+'/'+id+'/edit',
        success: function(result) {
          $('form').attr('action',"{{url('categories')}}"+"/"+result['id']);
          $('#category_name').val(result['name']);
          $('#description').val(result['description']);
          $('#stack1').modal('show');

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
