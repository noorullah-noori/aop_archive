<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\President;
use DB;
use App\Search;
use Config;

class SearchController extends Controller
{
    
    public function search_result(Request $request){
        $lang = Config::get('app.locale');

        $text = $request->input('search');
        
        $type  = ['decree','order','statement','mesasage','word','domestic','news','articles','infographic','album','video'];
        
        $data_dr = Search::where('title_dr','LIKE','%'.$text.'%')
                            ->orWhere('short_desc_dr','LIKE','%'.$text.'%')
                            ->orWhere('description_dr','LIKE','%'.$text.'%')
                            ->whereIn('type',$type)
                            ->select('title_dr','short_desc_dr','table_id','date_dr','type')
                            ->get();

        $data_pa = Search::where('title_pa','LIKE','%'.$text.'%')
                            ->orWhere('short_desc_pa','LIKE','%'.$text.'%')
                            ->orWhere('description_pa','LIKE','%'.$text.'%')
                            ->whereIn('type',$type)
                            ->get();

        $data_en = Search::where('title_en','LIKE','%'.$text.'%')
                            ->orWhere('short_desc_en','LIKE','%'.$text.'%')
                            ->orWhere('description_en','LIKE','%'.$text.'%')
                            ->whereIn('type',$type)
                            ->get();
                            
        $words = DB::table('president')->where('type','word')->orderBy('id','desc')->first();
        $news = Search::take('5')->whereNotNull('title_'.$lang)->where('type','!=','word')->orderBy('date_'.$lang,'desc')->get();
        return view('search_result')->with(['data_dr'=>$data_dr,'data_pa'=>$data_pa,'data_en'=>$data_en,'word'=>$words,'news'=>$news]);
    }

    public function get_search(Request $request){
        $lang = Config::get('app.locale');
        $search = $request->input('search');
        $type = $request->input('type');
        $to = $request->input('to');
        $from = $request->input('from');
        $search_in = $request->input('search_in');
        $data = '';
        if(in_array('domestic', $search_in)){
            array_push($search_in, 'international');
        }
        if($type =='all'){
                    // $data = Search::where('title_en','LIKE','%'.$search.'%')
                    //     ->orWhere('title_dr','LIKE','%'.$search.'%')
                    //     ->orWhere('title_pa','LIKE','%'.$search.'%')
                    //     ->orWhere('short_desc_en','LIKE','%'.$search.'%')
                    //     ->orWhere('short_desc_dr','LIKE','%'.$search.'%')
                    //     ->orWhere('short_desc_pa','LIKE','%'.$search.'%')
                    //     ->orWhere('description_en','LIKE','%'.$search.'%')
                    //     ->orWhere('description_dr','LIKE','%'.$search.'%')
                    //     ->orWhere('description_pa','LIKE','%'.$search.'%')
                    //     ->whereBetween('date_en',[$from,$to])
                    //     ->whereIn('type',$search_in)
                    //     ->get();
                        $data_en = Search::where('title_en','LIKE','%'.$search.'%')
                        ->orWhere('short_desc_en','LIKE','%'.$search.'%')
                        ->orWhere('description_en','LIKE','%'.$search.'%')
                        ->whereBetween('date_en',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
                        $data_dr = Search::where('title_dr','LIKE','%'.$search.'%')
                        ->orWhere('short_desc_dr','LIKE','%'.$search.'%')
                        ->orWhere('description_dr','LIKE','%'.$search.'%')
                        ->whereBetween('date_dr',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
                        $data_pa = Search::where('title_pa','LIKE','%'.$search.'%')
                        ->orWhere('short_desc_pa','LIKE','%'.$search.'%')
                        ->orWhere('description_pa','LIKE','%'.$search.'%')
                        ->whereBetween('date_pa',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
        }
        else{
                    // $data = Search::where('title_en','=','%'.$search.'%')
                    //     ->orWhere('title_dr','=','%'.$search.'%')
                    //     ->orWhere('title_pa','=','%'.$search.'%')
                    //     ->orWhere('short_desc_en','=','%'.$search.'%')
                    //     ->orWhere('short_desc_dr','=','%'.$search.'%')
                    //     ->orWhere('short_desc_pa','=','%'.$search.'%')
                    //     ->orWhere('description_en','=','%'.$search.'%')
                    //     ->orWhere('description_dr','=','%'.$search.'%')
                    //     ->orWhere('description_pa','=','%'.$search.'%')
                    //     ->whereBetween('date_en',[$from,$to])
                    //     ->whereIn('type',$search_in)
                    //     ->get();
                        $data_en = Search::where('title_en','=','%'.$search.'%')
                        ->orWhere('short_desc_en','=','%'.$search.'%')
                        ->orWhere('description_en','=','%'.$search.'%')
                        ->whereBetween('date_en',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
                        $data_dr = Search::where('title_dr','=','%'.$search.'%')
                        ->orWhere('short_desc_dr','=','%'.$search.'%')
                        ->orWhere('description_dr','=','%'.$search.'%')
                        ->whereBetween('date_dr',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
                        $data_pa = Search::where('title_pa','=','%'.$search.'%')
                        ->orWhere('short_desc_pa','=','%'.$search.'%')
                        ->orWhere('description_pa','=','%'.$search.'%')
                        ->whereBetween('date_pa',[$from,$to])
                        ->whereIn('type',$search_in)
                        ->get();
        }
        $words = DB::table('president')->where('type','word')->orderBy('id','desc')->first();
        $news = Search::take('5')->whereNotNull('title_'.$lang)->where('type','!=','word')->orderBy('date_'.$lang,'desc')->get();
       
        return view('search_result')->with(['data_en'=>$data_en,'data_dr'=>$data_dr,'data_pa'=>$data_pa,'word'=>$words,'news'=>$news]);
    }
}
