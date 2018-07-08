<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
  <title>Folder Print</title>
</head>
<body>
  <span style="direction: rtl;text-align: right;">{{$tag }}</span>    

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