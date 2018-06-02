<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use DB;
use App\Search;
use File;
use Session;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;
use Intervention\Image\ImageManager;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_trip');
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
        $date = 'date_'.$lang;
        $short_desc = 'short_desc_'.$lang;
        $description = 'description_'.$lang;

        // validation
        $this->validate($request,[
              $title=>'required|unique:trips|max:255',
              $date=>'required',
              'image'=>'required|mimes:jpg,jpeg,png,bmp',
              // $short_desc ='required',
              // $description ='required'
            ]);
        //data storage
        $trip = new Trip();
        $trip->$title = $request->$title;
        if($lang=='dr' || $lang=='pa'){
          $trip->date_dr = $request->$date;
          $trip->date_pa = $request->$date;
        }
        else{
          $trip->date_en = $request->$date;
        }
        $trip->$short_desc = $request->$short_desc;
        $trip->$description = $request->$description;
        $trip->type = $request->input('type');

        //save the record to retreive id later
        $trip->save();

        $log = new Log();

        $log->table_name = 'trips';
        $log->table_item_id = $trip->id;
        $log->activity = 'create';
        $log->user_id = Auth::user()->id;
        $log->save();

        //retreive id from previously stored record
        $id = $trip->id;

        //retreive trip object again
        $trip = Trip::findOrFail($id);

         //make image path
        $path = 'uploads/'.$request->type.'/';

        //variable for thumb image if present or otherwise
        $image_thumb_name = '';

        if($request->image!='') {
          //image names i.e. (image and image_thumb)
          $image_name = $id.'.'.$request->image->getClientOriginalExtension();
          $image_thumb_name = $id.'_t.'.$request->image->getClientOriginalExtension();

          //resize image for thumbnail
          $driver = new imageManager(array('driver'=>'gd'));
          $image_thumb = $driver->make($request->image)->resize(200,150);

          //store image and thumbnail in storage
          $request->image->move($path,$image_name);
          $image_thumb->save($path.$image_thumb_name);

          //db image storage
          $trip->image = $image_name;
          $trip->image_thumb = $image_thumb_name;

        }
        else {
          //if image not present for search table
          $image_thumb_name = 'default.jpg';

          //if no image received store the default
          $trip->image = 'default.jpg';
          $trip->image_thumb = 'thumb.jpg';
        }

        if($trip->save()) {
          //search stuff
          $search = new Search();
          $search->$title = $request->$title;
          if($lang=='dr' || $lang=='pa'){
          $search->date_dr = $request->$date;
          $search->date_pa = $request->$date;
          }
          else{
            $search->date_en = $request->$date;
          }
          $search->$short_desc = $request->$short_desc;
          $search->$description = $request->$description;
          $search->table_name = 'trips';
          $search->type = $request->type;
          $search->table_id = $id;
          $search->image_thumb = $path.$image_thumb_name;
          $search->save();
        }
        Session::put('lang','');
        Session::put('type','');
        // Log::info($id." Trips record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route("admin_".$request->type);
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
        $trip = Trip::findOrFail($id);
        return view('admin.edit_trip')->with('trip',$trip);
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
        $date = 'date_'.$lang;
        $short_desc = 'short_desc_'.$lang;
        $description = 'description_'.$lang;
        // validation
        $this->validate($request,[
          $title=>'required',
          // $short_desc=>'required',
          $description=>'required',
        ]);

      // trip data storage
       $trip = Trip::findOrFail($id);
       $search_obj = Search::where('table_name','=','trips')->where('table_id','=',$id)->first();
       $trip->$title = $request->$title;
       if($request->$date!='') {
         $trip->$date = $request->$date;
       }
       $trip->$short_desc = $request->$short_desc;
       $trip->$description = $request->$description;
        
       if($request->image!=null) {
            
            // validation
            $this->validate($request,[
            'image'=>'mimes:jpg,jpeg,png,bmp',
            ]);

         //remove existing images
         File::delete($search_obj->image_thumb);
         File::delete(str_replace('_t','',$search_obj->image_thumb));

         //set new images name
         $image_name = $id.'.'.$request->image->getClientOriginalExtension();
         $image_thumb_name = $id.'_t.'.$request->image->getClientOriginalExtension();

         //resize image for thumbnail
         $driver = new imageManager(array('driver'=>'gd'));
         $image_thumb = $driver->make($request->image)->resize(200,150);

         //construct image path
         $image_path = 'uploads/'.$request->type.'/';

         //move i.e.(to storage) image
         $image_thumb->save($image_path.$image_thumb_name);
         $request->image->move($image_path,$image_name);

         //store in db
         $trip->image = $image_name;
         $trip->image_thumb = $image_thumb_name;
       }

       if($trip->save()) {
         $search_obj->$title = $request->$title;
         $search_obj->$date = $request->$date;
         $search_obj->$short_desc = $request->$short_desc;
         $search_obj->$description = $request->$description;
         $search_obj->save();
       }
        
        $log = new Log();

        $log->table_name = 'trips';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

       Session::put('lang','');
       // Log::info($id." $trip->type updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
       return Redirect()->route("admin_".$trip->type);

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $trip = Trip::findOrFail($id);
        $type = $trip->type;
        File::delete('uploads/'.$type.'/'.$trip->image);
        File::delete('uploads/'.$type.'/'.$trip->image_thumb);
        $search = Search::where('table_name','trips')->where('table_id',$id)->first();
        $search->delete();
        $trip->delete();
        
        $log = new Log();

        $log->table_name = 'trips';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info($id." Trip deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('admin_'.$type);
    }

     public function domestic()
    {
        $domestic = DB::table('trips')->where('type','domestic')->orderBy('id','desc')->get();
        return view('admin.domestic')->with('domestic',$domestic);
    }

    public function international()
    {
        $international = DB::table('trips')->where('type','international')->orderBy('id','desc')->get();
        return view('admin.international')->with('international',$international);
    }
}
