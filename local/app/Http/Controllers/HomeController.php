<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use App\Document;
use App\Notice;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * generateNColors & getPieChart from helper
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $notice = Notice::select(['id', 'title','description'])->where('status',0)->orderby('id','decs')->get();
        $current_user = auth()->user();

        $colors = [
          'documents'=>[ "#27f88b","#254aa5", "#8a78bd", "#520a53" ],
          'enquiries'=>[ "#b049bd", "#621727", "#a67679", "#08cf56"],
          'document_type'=>
          [ "#27f88b","#254aa5", "#8a78bd", "#520a53",
            "#b049bd", "#621727", "#a67679", "#08cf56",
            "#457a97", "#3d27cc", "#44c1b7", "#56e066",
            "#277a13", "#53d83b", "#2b24e0", "#3ab031"
          ],
          'user'=>[ "#457a97", "#3d27cc", "#44c1b7", "#56e066" ]
        ];

        if($current_user->hasRole('admin')) {
          $documents = getChartDataArrayByRoleName($current_user, 'documents');

          $enquiries = getChartDataArrayByRoleName($current_user, 'enquiries');

          $document_type = getChartDataArrayByRoleName($current_user, 'document_type');

          // $user = getChartDataArrayByRoleName($current_user, 'user');


          $documents_chart = getChart($documents, array_slice($colors['documents'],0,count($documents)), 'line', 'documents');

          $enquiries_chart = getSimpleChart($enquiries, 'line', 'enquiries');

          $document_type_chart = getChart($document_type, array_slice($colors['document_type'],0,count($document_type)), 'pie', 'document_type');

          // $user_chart = getChart($user, array_slice($colors['user'],0,count($documents)), 'bar', 'user');

          return view('dashboard')->with(['documents_chart'=>$documents_chart,  'enquiries_chart'=>$enquiries_chart, 'document_type_chart'=>$document_type_chart ,'notice'=>$notice]);
        }
        else {
          $data = getChartDataArrayByRoleName($current_user);
          $chart = getSimpleChart($data, 'line');
          return view('dashboard')->with(['chart'=>$chart,'notice'=>$notice]);
        }



    }




}
