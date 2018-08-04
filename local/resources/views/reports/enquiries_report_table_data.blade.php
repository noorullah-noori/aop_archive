
@if ($enquiries->count()>1)
  <div class="col-md-12" style="padding-left:0px; margin-bottom: 10px;">
    <div class="buttons-group pull-right">
      {{-- <a href="#" class="btn btn-default">
      <i class="fa fa-print" style="font-size:1.3em !important;color:black;line-height:1.2;"></i>
    </a> --}}
    <form action="{{route('export_report')}}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="data" value="{{ $enquiries->toJson() }}">
      {{-- <input type="submit" name="" value="Submit"> --}}

      <button type="submit" name="type" value="excel" class="btn btn-default">
        <i class="fa fa-file-excel-o" style="font-size:1.3em !important;color:green;line-height:1.2;"></i>
      </button>

      {{-- <button type="submit" name="type" value="pdf" class="btn btn-default"> --}}
      <button type="submit" name="type" value="pdf" class="btn btn-default" style="margin-left:0px;">
        <i class="fa fa-file-pdf-o" style="font-size:1.3em !important;color:red;line-height:1.2;"></i>
      </button>
    </form>

  </div>

</div>
@endif
@if (isset($enquiries['alert']))
<div class=" col-md-12" style="background:#02851896;margin-bottom:10px;">
  <p class="center" style="text-align:center;color:#fff;margin-top:10px;">
    {{$enquiries['alert']}}
  </p>
</div>
@endif

@if ($enquiries->count()!=0)
<table id="department-datatable" class="table table-bordered">
  <thead>

    <tr>
      <th>شماره مکتوب درخواستی</th>
      <th>مرجع تایید کننده</th>
      <th>مرجع</th>
      <th>تاریخ درخواستی</th>
      <th>تاریخ بازگشت اسناد</th>
      <th>ضرب الاجل</th>
      <th>نوعیت</th>
      <th>چگونگی بازگشت</th>
    </tr>
  </thead>
  <tbody>
    @if ($enquiries->count() == 1)
      <tr>
        <td colspan="7" style="text-align:center;">موردی وجود ندارد</td>
      </tr>
    @endif
    @foreach ($enquiries as $enquiry)
      @if(gettype($enquiry)!='string')
        <tr>
          <td>{{Verta::persianNumbers($enquiry->enquiry_number)}}</td>
          <td>{{$enquiry->approval_authority}}</td>
          <td>{{$enquiry->department->name}}</td>
          <td>{{afghaniDateFormat($enquiry->request_date)}}</td>
          <td>{{afghaniDateFormat($enquiry->expected_return_date)}}</td>
          @if($enquiry->returned==0)
          @if (($remaining_days = documentDeadlineDaysRemanining($enquiry->expected_return_date,2,'days')) < 3)
            <td style="direction:ltr;text-align:right;">
              <div style='padding:5px;' class='badge badge-danger'>{!! Verta::persianNumbers($remaining_days) !!}</div>
            </td>
          @else
            <td style="direction:ltr;text-align:right;">
              <div style='padding:5px;' class='badge badge-success'>{!! Verta::persianNumbers($remaining_days) !!}</div>
            </td>

          @endif
          @else
            <td></td> 
          @endif

          <td>{{$enquiry->original == 0 ? 'کاپی' : 'اصلی'}}</td>
          <td>{!!$enquiry->returned == 1 ? '<i style="font-size:1.3em;color:green;" class="icon-check">' : '' !!}</td>
        </tr>
      @endif
    @endforeach

  </tbody>
</table>

@endif
