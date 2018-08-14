@if ($documents->count()>1)
  <div class="col-md-2">
    <div class="buttons-group pull-right">
      {{-- <a href="#" class="btn btn-default">
      <i class="fa fa-print" style="font-size:1.3em !important;color:black;line-height:1.2;"></i>
    </a> --}}
    <form action="{{route('export_report')}}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="data" value="{{ $documents->toJson() }}">
      {{-- <input type="submit" name="" value="Submit"> --}}

      <button type="submit" name="type" value="excel" class="btn btn-default">
        <i class="fa fa-file-excel-o" style="font-size:1.3em !important;color:green;line-height:1.2;"></i>
      </button>

      <button type="submit" name="type" value="pdf" class="btn btn-default">
        <i class="fa fa-file-pdf-o" style="font-size:1.3em !important;color:red;line-height:1.2;"></i>
      </button>
    </form>

  </div>

</div>
@endif
@if (isset($documents['alert']))
<div class=" col-md-12" style="background:#02851896;margin-bottom:10px;">
  <p class="center" style="text-align:center;color:#fff;margin-top:10px;">
    {{$documents['alert']}}
  </p>
</div>
@endif

@if ($documents->count()!=0)
<table id="department-datatable" class="table table-bordered">
  <thead>

    <tr>
      <th rowspan="4">شماره سند</th>
      <th rowspan="4">تاریخ</th>
      <th rowspan="4">موضوع</th>
      <th rowspan="4">تعداد صفحات</th>
      <th rowspan="4">نوع سند</th>
      <th rowspan="4">مرسل</th>
      <th rowspan="4">لسان سند</th>
      <th colspan="4" style="text-align:center">حالت</th>
    </tr>
    <tr>
      <th>ثبت شده</th>
      <th>تایید شده</th>
      <th>رد شده</th>
      <th>جابجاشده</th>
    </tr>
  </thead>
  <tbody>
    @if ($documents->count() == 1)
      <tr>
        <td colspan="11" style="text-align:center;">موردی وجود ندارد</td>
      </tr>
    @endif

    @foreach ($documents as $document)
      @if(gettype($document)!='string')
        <tr>
          <td>{{$document->number}}</td>
          <td>{{afghaniDateFormat($document->date)}}</td>
          <td>{{$document->subject}}</td>
          <td>{{$document->total_pages}}</td>
          <td>{{$document->category->name}}</td>
          <td>{{$document->department->name}}</td>
          <td>{{$document->document_language->language_name}}</td>
          <td>{{afghaniDateFormat($document->created_at)}}</td>
          <td>{{afghaniDateFormat($document->approved_at)}}</td>
          <td>{{afghaniDateFormat($document->rejected_at)}}</td>
          <td>{{afghaniDateFormat($document->stocked_date)}}</td>
        </tr>
      @endif
    @endforeach
  </tbody>
</table>


<h5>مجموعه اسناد:<span style="color:#45B6AF"> {{$documents->count()-1}}</span</h5>


@endif
