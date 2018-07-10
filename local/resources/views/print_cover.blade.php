<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

      span.comma:first-child {
          display: none;
      }
    </style>

</head>

<body dir="rtl">
    <img src="{{asset('assets/images/print_logo.png')}}" alt="logo" height="300px" width="800px" class="logo-default">

    <table style=" width:800px;">

        <tr style="width:100%;">
            <br>
            <th style="text-align: right;">تاریخ:</th>
            <td>{{$documents->date}}</td>

            <td style="text-align: left;">{{$documents->label}}</td>
            <th style="text-align: left;width: 100px;">:Tag Number</th>
        </tr>
        <tr style="text-align:center;">
            <th colspan="8">
                <br>
                <br>مشخصات سند </th>
                <br>
        </tr>
        <tr style="text-align:center;">
            {{-- <th colspan="8">(فرامین,مکاتب,پشنهادات,احکام,عرایض و نامه ها) --}}
                <br>
                <br>
            </th>
        </tr>

        <tr>
            <td style="width:90px;">نوع سند: </td>
            <td>{{$documents->category->name}}</td>
        </tr>
        <tr>
            <td>شماره سند: </td>
            <td>{{$documents->number}}</td>
        </tr>
        <tr>
            <td>مرسل:</td>
            <td>{{$documents->department->name}}</td>
        </tr>
        <tr >
          @if($documents->category_id =='10' or $documents->category_id =='15' or$documents->category_id =='16' )
            <td colspan="2">  {{$documents->category->name}} بین کشورهای
              @if(isset($documents->countries))
                @foreach($documents->countries as $country)
             <span class="comma">,</span>{{$country}}
                @endforeach
              @endif
              .
            </td>
          @endif
        </tr>
        <tr>
            <td>مرسل الیه :</td>
            <td>{{$documents->receiver}}</td>
        </tr>
        <tr>
            <td>تاریخ:</td>
            <td>{{$documents->date}}</td>
        </tr>
        <tr>
            <td>تعداد اوراق:</td>
            <td>{{$documents->total_pages}}</td>
        </tr>
        <tr>
            <td>ضمایم:</td>
            <td>{{$documents->description}}</td>
        </tr>
        <tr>
            <td>موضوع سند:</td>
            <td>{{$documents->subject}}</td>
        </tr>

    </table>
    <h3 style="position:absolute; bottom:0;">نام و امضاء تایید کننده:</h3>
</body>

</html>
<script type="text/javascript">
//onload print
    window.print();
    @if(!$reprint == 'reprint')

    window.onafterprint = function() {
        window.location.href = "{{route('stockable_documents','success')}}";
        // window/.close();
    }
    @else
    window.onafterprint = function() {

        window.close();
    }
    @endif
</script>
