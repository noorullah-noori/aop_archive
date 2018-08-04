@extends('layouts.master')
@section('title','اطلاعیه ها')
@section('content')
@section('content')
<div class="portlet light">
	<div class="portlet-title">

    <div class="caption">
        <i class="fa fa-file-text-o font-green-sharp"></i>
        <span class="caption-subject font-green-sharp bold uppercase">@yield('title')</span>
    </div>
    <a href="{{route('notice.create')}}" class="btn btn-success pull-right">
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

      {{-- <input type="checkbox" name="original" value="1" id="status"> --}}

      <table id="notice-datatable" class="table table-bordered">
        <thead>
          <tr>
            <th>شماره</th>
            <th>عنوان</th>
            <th>توضیحات</th>
            <th>نمایش/پنهان</th>
            <th>عملیات</th>
          </tr>
        </thead>
      </table>




		</div>
	</div>
</div>
@endsection
@push('custom-js')
  <script type="text/javascript">
    $('#notice-datatable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{route('get_notice')}}',
      columns: [
          {data: 'id', name: 'id'},
          {data: 'title', name: 'title'},
          {data: 'description', name: 'description'},
          {data: 'status', name: 'status', orderable: false, searchable: false},
          {data: 'action', name: 'action', orderable: false, searchable: false}
      ],
          "fnDrawCallback": function() {
              //Initialize checkbos for enable/disable user
              $("[name='original']").bootstrapSwitch({size: "small", onColor:"danger", offColor:"success", onText: "پنهان",offText: "نمایش"});
							// $("[name='original']").bootstrapSwitch(function(){
								$("[name='original']").on('switchChange.bootstrapSwitch', function(event, status) {
								var id = this.id;

								if(status==true){
									status=1;
								}else{
									status=0;
								}
								
								$.ajax({
									type : "get",
									url : "{{url('update_status')}}/"+id+"/"+status,
									success : function(data)
									{

									}
								});
							})
          }
    });

  </script>
@endpush
@push('custom-css')
  <style media="screen">
  .checker {
    display: none !important;
  }
  </style>

@endpush
