{{-- parameter(s):
** flash session name $alert_type
 --}}
@if($errors->any())
    <ul class="alert alert-danger">
      @foreach($errors->all() as $error)
        <li>{{$error}}</li>
      @endforeach
    </ul>
@endif
@if(session()->has("$alert_type"))
   <div class="alert alert-success">
    {{ session()->get("$alert_type") }}
   </div>
@endif
