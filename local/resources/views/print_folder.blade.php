<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <title>Folder Print</title>
</head>
<style>
#contener {
    text-align: center;
    width: 200px;
    display: block;
    height: 366px;margin: auto;
    border-top: 3px groove #b12121;
    border-bottom: 3px groove #b12121;
}
p{
  text-align:center;
}
</style>
<body>
  <div id="contener">
<div style="padding:10px;">
      <img src="{{asset('assets/images/afghanistan_logo.png')}}" style="height:100px; width:100px;">
      <p> کارتن ({{$folder}})</p>
      <p style="direction: rtl;">{{$document}} سال {{$year}}</p>
      <p style="direction: rtl;">از{{$min}} الی{{$max}}</p>
</div>
</div>
  <script type="text/javascript">

    window.print();

    window.onafterprint = function(){
          window.location.href="{{route('stockable_documents','success')}}";
          window.location.href="{{route('folder_view')}}";
          // window.close();
        }

    </script>

</body>
</html>
