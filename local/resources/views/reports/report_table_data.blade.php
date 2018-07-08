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
@if (isset($documents['alert']))
<div class="alert alert-success col-md-5">
  <ul>
    <li>{{$documents['alert']}}</li>
  </ul>
</div>
@endif

@if ($documents->count()!=0)
<table id="department-datatable" class="table table-bordered">
  <thead>
    <tr>
      <th>شماره سند</th>
      <th>تاریخ</th>
      <th>موضوع</th>
      <th>تعداد صفحات</th>
      <th>نوع سند</th>
      <th>مرسل</th>
      <th>لسان سند</th>
    </tr>
  </thead>
  <tbody>
    @if ($documents->count() == 1)
      <tr>
        <td colspan="7" style="text-align:center;">موردی وجود ندارد</td>
      </tr>
    @endif
    @foreach ($documents as $document)
      @if(gettype($document)!='string')
        <tr>
          <td>{{$document->number}}</td>
          <td>{{$document->date}}</td>
          <td>{{$document->subject}}</td>
          <td>{{$document->total_pages}}</td>
          <td>{{$document->department->name}}</td>
          <td>{{$document->category->name}}</td>
          <td>{{$document->document_language->language_name}}</td>
        </tr>
      @endif
    @endforeach

  </tbody>
</table>

@endif
