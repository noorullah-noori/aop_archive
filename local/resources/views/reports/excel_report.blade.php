<style media="screen">
  th {
    background: #ddd;
  }
  th,td {
    border: 1px solid #000;
  }
</style>
<table id="department-datatable"class="table table-bordered" style="direction:rtl;">
  <thead>
    <tr>
      <th colspan="11" style="text-align:center;font-size:20px;font-weight:bold">{{isset($documents->alert) ? $documents->alert : 'نمایش تمامی اسناد' }}</th>
    </tr>
      @if(isset($documents[0]['enquiry_number']))
        <tr>
          <th style="margin-left:auto;" colspan=5>
            عمومی
          </th>
          <th style=" margin-left:auto;" colspan=3>
            اصلی
          </th>
        </tr>
        <tr>
          <th>شماره سند درخواستی</th>
          <th>مرجع تایید کننده</th>
          <th>مرجع</th>
          <th>تاریخ درخواستی</th>
          <th>تاریخ بازگشت اسناد</th>
          <th>ضرب الاجل</th>
          <th>نوعیت</th>
          <th>چگونگی بازگشت</th>
        </tr>
      @else
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
      @endif
  </thead>
  <tbody>
    {{count($documents) == 1 ? '<tr><td colspan="4" style="text-align:center;">موردی دریافت نگردید</td></tr>' : ''}}
    @foreach ($documents as $document)
      @if(gettype($document)!='string')
        <tr>
          @if(isset($document['enquiry_number']))
            <td>{{$document['enquiry_number']}}</td>
            <td>{{$document['approval_authority']}}</td>
            <td>{{$document['department']['name']}}</td>
            <td>{{afghaniDateFormat($document['request_date'])}}</td>
            <td>{{afghaniDateFormat($document['expected_return_date'])}}</td>
            @if (($remaining_days = documentDeadlineDaysRemanining($document['expected_return_date'],2,'days')) < 3)
              <td style="direction:ltr;text-align:right;">
                <div style='padding:5px;' class='badge badge-danger'>{!! $remaining_days !!}</div>
              </td>
            @else
              <td style="direction:ltr;text-align:right;">
                <div style='padding:5px;' class='badge badge-success'>{!! $remaining_days !!}</div>
              </td>

            @endif
            <td>{{$document['original'] == 0 ? 'کاپی' : 'اصلی'}}</td>
            <td>{!!$document['returned'] == 1 ? '<i style="font-size:1.3em;color:green;" class="icon-check">' : '' !!}</td>
          @else
            <td>{{$document['number']}}</td>
            <td>{{afghaniDateFormat($document['date'])}}</td>
            <td>{{$document['subject']}}</td>
            <td>{{$document['total_pages']}}</td>
            <td>{{$document['department']['name']}}</td>
            <td>{{$document['category']['name']}}</td>
            <td>{{$document['document_language']['language_name']}}</td>
            <td>{{afghaniDateFormat($document['created_at'])}}</td>
            <td>{{afghaniDateFormat($document['approved_at'])}}</td>
            <td>{{afghaniDateFormat($document['rejected_at'])}}</td>
            <td>{{afghaniDateFormat($document['stocked_date'])}}</td>
          @endif
        </tr>
      @endif
    @endforeach

  </tbody>
</table>
