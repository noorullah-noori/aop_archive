<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MediaDirectorate;
// use Log;
use Session;
use Auth;
use Carbon\Carbon;
use App\Log;

class MediaDirectorateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $media = MediaDirectorate::all();
      return view('admin.media_directorate')->with('media',$media);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_media_directorate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
      $lang = Session::get('lang');
      $description = 'description_'.$lang;
      $this->validate($request,[
          $description=>'required'
        ]);
      
      $media = new MediaDirectorate();
      $media->$description = $request->input($description);
      $media->save();

      $log = new Log();

      $log->table_name = 'media_directorate';
      $log->table_item_id = $media->id;
      $log->activity = 'create';
      $log->user_id = Auth::user()->id;
      $log->save();

      Session::put('lang','');
      // Log::info($media->id." Media Directorate created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('media_directorate.index');
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
        $media = MediaDirectorate::findOrFail($id);
        return view('admin.edit_media_directorate')->with('media',$media);
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
      
      $lang = Session::get('lang');
      $description = 'description_'.$lang;
      
      $this->validate($request,[
            $description=>'required'
          ]);
      
      $media =MediaDirectorate::findOrFail($id);
      $media->$description = $request->input($description);
      $media->save();
      
      $log = new Log();

      $log->table_name = 'media_directorate';
      $log->table_item_id = $id;
      $log->activity = 'update';
      $log->user_id = Auth::user()->id;
      $log->save();

      Session::put('lang','');
      // Log::info($id." Media Directorate updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('media_directorate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
      $media = MediaDirectorate::findOrFail($id);
      $media->delete();
      
      $log = new Log();

      $log->table_name = 'media_directorate';
      $log->table_item_id = $id;
      $log->activity = 'delete';
      $log->user_id = Auth::user()->id;
      $log->save();

      // Log::info($id." Media Directorate deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('media_directorate.index');
    }
}
