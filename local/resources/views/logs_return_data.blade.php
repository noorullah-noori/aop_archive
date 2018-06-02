<table id="logs-datatable" class="table table-bordered">
  <thead>

    <tr>
      <th>کاربر</th>
      <th>بخش</th>
      <th>شماره مورد</th>
      <th>فعالیت</th>
      <th>تاریخ</th>
      <th>زمان</th>
    </tr>
  </thead>
  <tbody>
    @if ($logs->count() < 1)
      <tr>
        <td colspan="7" style="text-align:center;">موردی وجود ندارد</td>
      </tr>
    @endif
    @foreach ($logs as $log)

        <tr>
          <td>{{$log->user->name}}</td>
          <td>{{$log->table_name}}</td>
          <td>{{\Verta::persianNumbers($log->table_id)}}</td>
          <td>{{$log->activity}}</td>
          <td>{{afghaniDateFormat($log->date)}}</td>
          <td>{{date("g:i A", strtotime($log->time))}}</td>
        </tr>
    @endforeach

  </tbody>
</table>
