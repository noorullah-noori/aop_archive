<?php
use \Hekmatinasser\Verta\Verta as Verta;
use App\Document;
use App\Enquiry;
use App\Category;
use App\Log;

if(! function_exists('documentDeadlineDaysRemanining')) {
  function documentDeadlineDaysRemanining($date, $days, $deadline='deadline') {
    if($date=='') {
      return $date;
    }
    //return the  remaining days for returning enquired document i.e. expected return date - now
    //OR
    //check if as many as $days remaining until deadline i.e. $days before deadline
    $parsed_date = Verta::parse($date);

    // returns difference in days + 1
    $difference = Verta::now()->diffDays($parsed_date)+1;

    if($deadline=='days') {
      return $difference;
    }
    else {
      // if $day or less remaining for deadline return true
      if($difference <= $days) {
        return true;
      }
      else {
        return false;
      }
    }
  }
}

// convert the string to Verta i.e. Carbon like object
if (! function_exists('afghaniDateFormat')) {
  function afghaniDateFormat($date) {
    if($date=='') {
      return $date;
    }
    // return $date;
    $verta_date = Verta::parse($date);

    // afghani months
    $months = ['حمل','ثور','جوزا','سرطان','اسد','سنبله','میزان','عقرب','قوش','جدی','دلو','حوت'];

    // get the year from object
    $year = $verta_date->year;

    // parse afghani month
    $month = $verta_date->month;

    // get the day from afghani months array
    $day = $verta_date->day;

    // concatenate day month and year
    $concat_date = $day." ".$months[$month-1]." ".$year;

    // change numbers to persian numbers and return
    return Verta::persianNumbers($concat_date);
  }
}

// function to generate a random hexadecimal number
if(! function_exists('randomColorPart')) {
  function randomColorPart() {
      return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
  }
}

// function to form a hexadecimal color code by calling randomColorPart function

if(! function_exists('randomColor')) {
  function randomColor() {
      return '#'.randomColorPart() . randomColorPart() . randomColorPart();
  }
}


// function to get count and generate as many (count) hexadecimal colors
if(! function_exists('generateNColors')) {
  function generateNColors($count) {
      $colors_array = array();
      for($i = 0 ; $i < $count ; $i++) {
        $colors_array[$i] = randomColor() ;
      }
      return $colors_array;
  }
}

// function to generate a chart by passing data, colors, and type i.e. bar, pie ,...
if(! function_exists('getChart')) {
  function getChart($data, $colors, $type, $name='test') {

    $chart = app()->chartjs
            ->name($name)
            ->type($type)
            ->size(['width' => 400, 'height' => 200])
            ->labels(array_keys($data))
            ->datasets([
                [
                    'label' => "چارت",
                    'backgroundColor' => array_values($colors),
                    'hoverBackgroundColor' => array_values($colors),
                    'data' => array_values($data),
                ]

            ])
            ->options([]);
    return $chart;
  }
}

if(! function_exists('getSimpleChart')) {
  function getSimpleChart($data, $type) {
    $chart = app()->chartjs
            ->name($type)
            ->type($type)
            ->size(['width' => 400, 'height' => 200])
            ->labels($data==null?[]:array_keys($data))
            ->datasets([
                [
                    'label' => "چارت",
                    'data' => $data==null?[]:array_values($data),
                ]

            ])
            ->options([]);
    return $chart;
  }
}

if(! function_exists('getChartDataArrayByRoleName')) {
  function getChartDataArrayByRoleName($user, $type=null) {
    // if the user is entry or approval
    //return array of data
    if($user->hasRole('entry') || $user->hasRole('approval')) {

      $entry_or_approval = $user->hasRole('entry') ? 'created_by' : 'approve_reject_auth';
      $entered = Document::where('status',0)->where( $entry_or_approval ,$user->id)->count();
      $approved = Document::where('status',1)->where( $entry_or_approval ,$user->id)->count();
      $rejected = Document::where('status',2)->where( $entry_or_approval ,$user->id)->count();

      $data = [
        'جدیدا درج شده' => $entered,
        'تایید شده' => $approved,
        'رد شده' => $rejected
      ];
      return $data;

    }
    // if the user is stock
    //return array of data
    else if($user->hasRole('stock')) {

      $approved = Document::where('status',2)->count();
      $stocked = Document::where('status',3)->count();
      $request_stock_edit = Document::where('status','3')->whereNotNull('stock_edit_request_by')->where('stock_edit_request_approve',0)->count();

      $data = [
        'اسناد قابل جابجایی' => $approved,
        'اسناد جابجا شده' => $stocked,
        'درخواست برای تغییر جابجایی اسناد' => $request_stock_edit
      ];
      return $data;

    }
    // if the user is stock
    //return array of data
    else if($user->hasRole('enquiry')) {
      $i=0;

      $completed = Document::where('status',3)->doesntHave('enquiries')->count();
      $enquired =  Enquiry::where('returned',0)->count();
      $returnable =  Enquiry::where('original',0)->count();
      $deadline_reached =  Enquiry::where('original',1)->pluck('expected_return_date');

      foreach ($deadline_reached as $item) {
        if(documentDeadlineDaysRemanining($item,3)) {
          $i++;
        }
      }

      $data = [
        'اسناد قابل درخواست' => $completed,
        'اسناد درخواست شده' => $enquired,
        'اسناد درخواست شده اصلی'=>$returnable,
        'ضرب الاجل فرارسیده'=>$i
      ];
      return $data;

    }
    else if($user->hasRole('admin')) {
      // pie chart entered, approved, rejected, completed, stocked
      // bar chart document type based documents
      // line chart users based chart
      $data =array();
      if($type=='documents') {
        $total_entered = Document::where('status',0)->count();
        $total_approved = Document::where('status',1)->count();
        $total_rejected = Document::where('status',2)->count();
        $total_completed = Document::where('status',3)->count();

        $data = [
          'مجموع اسناد ثبت شده' => $total_entered,
          'مجموع اسناد تایید شده' => $total_approved,
          'مجموع اسناد رد شده'=>$total_rejected,
          'مجموع اسناد تکمیل شده'=>$total_completed
        ];
      }
      else if($type=='enquiries') {
        $total_original_enquiries = Enquiry::where('original',1)->count();
        $total_copy_enquiries = Enquiry::where('original',0)->count();

        $data = [
          'مجموع درخواستی ها برای اسناد اصلی' => $total_original_enquiries,
          'مجموع درخواستی ها برای اسناد کاپی' => $total_copy_enquiries
        ];
      }
      else if($type=='document_type'){
        $documents_types = Category::withCount('documents')->pluck('documents_count', 'name')->toArray();

        $data = $documents_types;
      }

      return $data;


    }



  }

  function createLog($table_name, $table_id, $activity){
    $log = new Log();
    $log->table_name = $table_name;
    $log->table_id = $table_id;
    $log->activity = $activity;
    $log->user_id = Auth::user()->id;
    $verta = verta();
    $log->date = $verta->formatDate();
    $log->time = $verta->formatTime();
    $log->save();
  }
}
