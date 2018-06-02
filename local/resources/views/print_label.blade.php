



@if(!isset($status))

{{ $label }}

    <script type="text/javascript">

    window.print();

    window.onafterprint = function(){
          {{--window.location.href="{{route('stockable_documents','success')}}"; --}}
          window.location.href="{{route('print_cover',$id)}}";
          // window.close();
        }


    </script>
@else
  {{ $label->label }}
  
  <script type="text/javascript">

    window.print();
    window.close();



  </script>
@endif
