<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Search;
// use Log;
use Session;
use Auth;
use Carbon\Carbon;
use App\Log;

class videoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $video = Video::orderBy('id','desc')->get();
        return view('admin.videos')->with('videos',$video);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_video');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // multiple language variables
          $lang=\Session::get('lang');
          $title = 'title_'.$lang;
          $date = 'date_'.$lang;
          $video_val = 'video_'.$lang;
          $url = 'url_'.$lang;

          // validation
          $this->validate($request,[
            $title=>'required|unique:videos|max:255',
            $date=>'required',
            $video_val=>'required',
          ]);

          // data storage to db
          $video = new video();
          $video->$title = $request->input($title);
          $video->$date = $request->input($date);
          $video->$url = $request->input($video_val);

          if($video->save()){
              $search = new Search();
                $search->$title = $request->input($title);
                $search->$date = $request->input($date);
                $search->image_thumb = $request->input($video_val);
                $search->table_name = 'videos';
                $search->type = 'video';
                $search->table_id = $video->id;
                $search->save();
          }

          $log = new Log();

          $log->table_name = 'videos';
          $log->table_item_id = $video->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

          Session::put('lang','');
          // Log::info($video->id." Video created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
          return Redirect()->route('videos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = video::findOrFail($id);
        return view('admin.edit_video')->with('video',$video);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // multilanguage variables
          $lang=\Session::get('lang');
          $title = 'title_'.$lang;
          $date = 'date_'.$lang;
          $video = 'video_'.$lang;
          $url = 'url_'.$lang;

          // validation
          $this->validate($request,[
            $title=>'max:255'
          ]);

          // data storage to db
            $video_obj =video::findOrFail($id);      
            $video_obj->$title = $request->input($title);
            if($request->$date!='') {
               $video_obj->$date = $request->$date;
             }
            $video_obj->$url = $request->input($video);
        
            if($video_obj->save()){
                    $search = Search::where('table_name','=','videos')->where('table_id','=',$id)->first();
                    $search->$title = $request->input($title);
                    if($request->$date!='') {
                       $search->$date = $request->$date;
                     }
                    $search->table_name = 'videos';
                    $search->type = 'video';
                    $search->table_id = $video_obj->id;
                    $search->save();
            }
            
            $log = new Log();

            $log->table_name = 'videos';
            $log->table_item_id = $id;
            $log->activity = 'update';
            $log->user_id = Auth::user()->id;
            $log->save();

            Session::put('lang','');
            // Log::info($id." Video updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
            return Redirect()->route('videos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $video = video::findOrFail($id);
        if($video->delete()){
            $search = Search::where('table_name','=','videos')->where('table_id','=',$id)->first();
            $search->delete();
        }
          
          $log = new Log();

          $log->table_name = 'videos';
          $log->table_item_id = $id;
          $log->activity = 'delete';
          $log->user_id = Auth::user()->id;
          $log->save();

        // Log::info($id." Video deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return redirect()->route('videos.index');
    }
}
