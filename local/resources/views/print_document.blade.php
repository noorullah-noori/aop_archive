@foreach($uploads as $item)
  <img src="{{asset($item)}}"></h1>
@endforeach
<script type="text/javascript">
window.print();

window.onafterprint = function(){

  window.close();
}


</script>
