<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Links;
use Session;
use File;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;
use Intervention\Image\ImageManager;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Links::orderBy('id','desc')->get();
        return view('admin.links')->with('links',$links);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_link');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //multi language variables
        $lang = Session::get('lang');
        $title = 'title_'.$lang;
        $description = 'description_'.$lang;

        // validation
        $this->validate($request,[
              $title=>'required|unique:links|max:255',
              $description=>'required',
              // 'url'=>'required'
            ]);

        //data storage
        $link = new Links();
        $link->$title = $request->$title;
        $link->$description = $request->$description;
        // $link->url = $request->input('url');
        
        //save the record to retreive id later
        $link->save();

          $log = new Log();

          $log->table_name = 'links';
          $log->table_item_id = $link->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

        //retreive id from previously stored record
        $id = $link->id;

        //retreive link object again
        $link = Links::findOrFail($id);

         //make image path
        $path = 'uploads/links/';

        //variable for thumb image if present or otherwise
        $image_thumb_name = '';

          //image uploading
        if($request->image!='') {
          //image names i.e. (image and image_thumb)
          $image_name = $id.'.'.$request->image->getClientOriginalExtension();
          
          //store image and thumbnail in storage
          $request->image->move($path,$image_name);

          //db image storage
          $link->image = $image_name;

        }
        else {
          //if no image received store the default
          $link->image = 'default.jpg';
        }

        $link->save();
        Session::put('lang','');
        // Log::info($id." Link created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('links.index');
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
        $link = Links::findOrFail($id);
        return view('admin.edit_link')->with('link',$link);
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

        //multi language variables
        $lang = Session::get('lang');
        $title = 'title_'.$lang;
        $description = 'description_'.$lang;
        // validation
        $this->validate($request,[
          $title=>'required',
          $description=>'required',
        ]);

        //construct image path
         $image_path = 'uploads/links/';
        // link data storage
         $link = Links::findOrFail($id);
         $link->$title = $request->$title;
         $link->$description = $request->$description;
         // $link->url = $request->url;

         if($request->image!=null) {
           //remove existing images
           File::delete($image_path.$link->image);
           //set new images name
           $image_name = $id.'.'.$request->image->getClientOriginalExtension();

           //resize image for thumbnail
           $driver = new imageManager(array('driver'=>'gd'));
           $image = $driver->make($request->image)->resize(200,150);

           //move i.e.(to storage) image
           $image->save($image_path.$image_name);
           
           //store in db
           $link->image = $image_name;
         }

          $link->save();
          $log = new Log();

          $log->table_name = 'links';
          $log->table_item_id = $id;
          $log->activity = 'update';
          $log->user_id = Auth::user()->id;
          $log->save();

          Session::put('lang','');
          // Log::info($id." Link updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
          return Redirect()->route('links.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $link = Links::findOrFail($id);
        File::delete('uploads/links/'.$link->image);
        $link->delete();
          
          $log = new Log();

          $log->table_name = 'links';
          $log->table_item_id = $id;
          $log->activity = 'delete';
          $log->user_id = Auth::user()->id;
          $log->save();

        // Log::info($id." Link deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('links.index');
    }
}
