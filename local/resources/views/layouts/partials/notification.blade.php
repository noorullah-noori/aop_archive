<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
  @foreach ($notifications as $notification)
  <li>
    {{-- @if (auth()->user()->hasRole('entry'))
      <a onclick = "markAsRead('{{$notification->id}}', {{$notification->data['document_id']}}, 'rejected')" href="#">
    @elseif(auth()->user()->hasRole('enquiry|admin'))
      <a onclick = "markAsRead('{{$notification->id}}', {{$notification->data['enquiry_id']}}, 'deadline')" href="#">
    @elseif(auth()->user()->hasRole('stock'))
      <a onclick = "markAsRead('{{$notification->id}}, {{$notification->data['document_id']}}')" href="#">

    @endif --}}
      {{-- {{route('edit_rejected_document',$notification->data['document_id'])}} --}}
      @hasanyrole('entry|approval|enquiry|stock|admin')
      <a onclick = "markAsRead('{{$notification->id}}', {{isset($notification->data['document_id']) ? $notification->data['document_id'] : '""'}}, '{{$notification->data['notification_type']}}')">
        <span class="time">{{$notification->created_at->diffForHumans()}}</span>
        <span class="details">
          <span class="label label-sm label-icon label-{{$notification->data['alert_type']}}">
            @if ($notification->data['alert_type'] == 'success')

              <i class="fa fa-bell"></i>
            @else
              <i class="fa fa-bolt"></i>

            @endif
          </span>
          {{$notification->data['notification']}}
        </span>
      </a>
    @endhasanyrole
  </li>
  @endforeach
</ul>
