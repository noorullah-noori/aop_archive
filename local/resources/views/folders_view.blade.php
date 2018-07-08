{{-- @if (isset($folders['alert']))
<div class=" col-md-12" style="background:#02851896;margin-bottom:10px;">
  <p class="center" style="text-align:center;color:#fff;margin-top:10px;">
    {{$folders['alert']}}
  </p>
</div>
@endif --}}

<div class="row">
@if ($folders->count()!=0)
  
    @foreach ($folders as $folder)
      @if(gettype($folder)!='string')
        
        <?php 
          $tag = $folder->category->name.'('.$folder->folder_from.'-'.$folder->folder_to.')';
        ?>

      <div class="col-md-3">
         <i class="icon-folder" style="width: 20px"></i><span>{{$folder->folder}}</span>
         <a href="{{route('print_folder',$tag)}}"><p><span>{{$folder->category->name}}</span><span>({{$folder->folder_from}}</span>-<span>{{$folder->folder_to}})</span></p></a>
      </div>
      @endif
    @endforeach

@endif
</div>



