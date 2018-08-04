{{-- @if (isset($folders['alert']))
<div class=" col-md-12" style="background:#02851896;margin-bottom:10px;">
  <p class="center" style="text-align:center;color:#fff;margin-top:10px;">
    {{$folders['alert']}}
  </p>
</div>
@endif --}}

{{-- <div class="row"> --}}
@if (!empty($folders))
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>فولدر</th>
        <th>نوع</th>
      </tr>
    </thead>
    <tbody>
        <?php 
          // $tag = $folder->category->name.'('.$folder->folder_from.'-'.$folder->folder_to.')';
          $count = 0;
        ?>
        @foreach ($folders as $folder)
          @if(gettype($folder)!='string')
            
            
            {{-- <tr>
              <td>{{$folder->id}}</td>
              <td>
                {{$folder->category->name}} ({{++$count}})
              </td>
              <td>{{$folders->min('file')}}</td>
              <td>{{$folders->max('file')}}</td>
            </tr> --}}

            <tr>
              <td></td>
              <td>
              <a href="{{route('print_folder',['year'=>$folder->cabinet_year,'cabinet'=>$folder->cabinet_number,'row'=>$folder->row,'document'=>$folder->category->name,'folder'=>$folder->folder])}}">{{$folder->folder}} </a>
              </td>
              <td>
                {{$folder->category->name}}
              </td>
            </tr>
    
          {{-- <div class="col-md-3">
            <i class="icon-folder" style="width: 20px"></i><span>{{$folder->folder}}</span>
            <a href="{{route('print_folder',$tag)}}"><p><span>{{$folder->category->name}}</span><span>({{$folder->folder_from}}</span>-<span>{{$folder->folder_to}})</span></p></a>
          </div> --}}
          @endif
        @endforeach
    </tbody>

  </table>
    

@endif
{{-- </div> --}}



