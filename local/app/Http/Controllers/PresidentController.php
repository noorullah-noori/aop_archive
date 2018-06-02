<?php

namespace App\Http\Controllers;

use App\President;
use Illuminate\Http\Request;
use DB;
use File;
use App\Search;
use Session;
use URL;
// use Log;
use Intervention\Image\ImageManager;
use Image;
use Auth;
use Carbon\Carbon;
use App\Log;

class PresidentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_order');
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
        
        if($request->type=='word'){

          // validation
        $this->validate($request,[
          $short_desc=>'required',
          'image'=>'required|mimes:jpg,jpeg,png,bmp',
        ]);
        }
        elseif($request->type=='decree' || $request->type=='order'){
          // validation
          $this->validate($request,[
            $title=>'required|max:250',
            $short_desc=>'max:250',
            $description=>'required',
            'image'=>'mimes:jpg,jpeg,png,bmp',
          ]);
        }
        else{
          // validation
          $this->validate($request,[
            $title=>'required|max:250',
            $short_desc=>'required|max:250',
            $description=>'required',
            'image'=>'mimes:jpg,jpeg,png,bmp',
          ]);
        }

        //data storage
        $the_president = new President();
        $the_president->$title = $request->$title;
        if($lang!='en'){
          $the_president->date_pa = $request->$date;
          $the_president->date_dr = $request->$date;
        }
        else{
          $the_president->date_en = $request->$date;
        }
        $the_president->$short_desc = $request->$short_desc;
        $the_president->$description = $request->$description;
        $the_president->type = $request->type;

        //save the record to retreive id later
        $the_president->save();

        $log = new Log();

        $log->table_name = 'president';
        $log->table_item_id = $the_president->id;
        $log->activity = 'create';
        $log->user_id = Auth::user()->id;
        $log->save();

        //retreive id from previously stored record
        $id = $the_president->id;

        //retreive president object again
        $the_president = President::findOrFail($id);


        //make image path
        $path = 'uploads/'.$request->type.'/';

        //variable for thumb image if present or otherwise
        $image_thumb_name = '';

        //image uploading
        if($request->image!='') {

          $image = Image::make($request->image);

          //image names i.e. (image and image_thumb)
          $image_name = $id.'.'.$request->image->getClientOriginalExtension();
          $image_thumb_name = $id.'_t.'.$request->image->getClientOriginalExtension();

          //resize image for thumbnail
          $driver = new imageManager(array('driver'=>'gd'));
          $image_thumb = $image->resize(200, null, function ($constraint) {
                            $constraint->aspectRatio();
                          });
          //store image and thumbnail in storage
          $request->image->move($path,$image_name);
          $image_thumb->save($path.$image_thumb_name);

          //db image storage
          $the_president->image = $image_name;
          $the_president->image_thumb = $image_thumb_name;

        }
        else {
          //if image not present for search table
          $image_thumb_name = 'default.jpg';

          //if no image received store the default
          $the_president->image = 'default.jpg';
          $the_president->image_thumb = 'thumb.jpg';
        }

        if($the_president->save()) {
          //search stuff
          $search = new Search();
          $search->$title = $request->$title;
          if($lang!='en'){
              $search->date_pa = $request->$date;
              $search->date_dr = $request->$date;
          }
          else{
              $search->date_en = $request->$date;
          }
          
          $search->$short_desc = $request->$short_desc;
          $search->$description = $request->$description;
          $search->table_name = 'president';
          $search->type = $request->type;
          $search->table_id = $id;
          $search->image_thumb = $path.$image_thumb_name;
          // print_r($search->image_thumb);exit;
          $search->save();
        }
        // print_r($title);exit;
        Session::put('lang','');
        Session::put('type','');
        // Log::info($id." President record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
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
        $the_president = President::findOrFail($id);
        return view('admin.edit_order')->with('the_president',$the_president);
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
      $lang = \Session::get('lang');
      $title = 'title_'.$lang;
      $date = 'date_'.$lang;
      $short_desc = 'short_desc_'.$lang;
      $description = 'description_'.$lang;

      // president data storage
       $the_president = President::findOrFail($id);
       $search_obj = Search::where('table_name','=','president')->where('table_id','=',$id)->first();
       $the_president->$title = $request->$title;
       if($request->$date!='') {
        if($lang!='en'){
         $the_president->date_pa = $request->$date;
         $the_president->date_dr = $request->$date;
        }
        else{
         $the_president->date_en = $request->$date; 
        }
       }
       $the_president->$short_desc = $request->$short_desc;
       $the_president->$description = $request->$description;


       if($request->image!=null) {
        
        $image = Image::make($request->image);

        if($request->type=='order' || $request->type=='decree'){
          File::delete('uploads/'.$request->type.'/default.jpg');
          //resize image for thumbnail
         $driver = new imageManager(array('driver'=>'gd'));
         $image = $driver->make($request->image)->resize(200,150);
         $image_name= 'default.jpg';
         $image_path = 'uploads/'.$request->type.'/';
         $image->save($image_path.$image_name);
        }
        else{
          
          // validation
          $this->validate($request,[
            'image'=>'required|mimes:jpg,jpeg,png,bmp',
          ]);

         //remove existing images
         File::delete($search_obj->image_thumb);
         File::delete(str_replace('_t','',$search_obj->image_thumb));

         //set new images name
         $image_name = $id.'.'.$request->image->getClientOriginalExtension();
         $image_thumb_name = $id.'_t.'.$request->image->getClientOriginalExtension();

         //resize image for thumbnail
         $driver = new imageManager(array('driver'=>'gd'));
         $image_thumb = $image->resize(200, null, function ($constraint) {
                          $constraint->aspectRatio();
                        });

         //construct image path
         $image_path = 'uploads/'.$request->type.'/';

         //move i.e.(to storage) image
         $image_thumb->save($image_path.$image_name);
         $request->image->move($image_path,$image_thumb_name);

         //store in db
         $the_president->image = $image_name;
         $the_president->image_thumb = $image_thumb_name;
         }
       }

       if($the_president->save()) {
         $search_obj->$title = $request->$title;
          if($request->$date!='') {
            if($lang!='en'){
             $search_obj->date_dr = $request->$date;
             $search_obj->date_pa = $request->$date;
            }
            else{
             $search_obj->date_en = $request->$date; 
            }
           }
         $search_obj->$short_desc = $request->$short_desc;
         $search_obj->$description = $request->$description;
         $search_obj->save();
       }
        
        $log = new Log();

        $log->table_name = 'president';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

       Session::put('lang','');
       // Log::info("Record ID No. '".$id."' President record updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
       return Redirect()->route("admin_".$request->type);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $president = President::findOrFail($id);
        $type = $president->type;
        File::delete('uploads/'.$type.'/'.$president->image);
        File::delete('uploads/'.$type.'/'.$president->image_thumb);
        $search = Search::where('table_name','president')->where('table_id',$id);
        $search->delete();
        $president->delete();
        
        $log = new Log();

        $log->table_name = 'president';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info($id." President record deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('admin_'.$type);
    }

    public function decrees()
    {
        $decrees = DB::table('president')->where('type','decree')->orderBy('id','desc')->get();
        return view('admin.decrees')->with('decrees',$decrees);
    }

    public function orders()
    {
      
        $orders = DB::table('president')->where('type','order')->orderBy('id','desc')->get();
        return view('admin.orders')->with('orders',$orders);
    }

    public function statements()
    {
        $statements = DB::table('president')->where('type','statement')->orderBy('id','desc')->get();
        return view('admin.statements')->with('statements',$statements);
    }
    public function messages()
    {
        $messages = DB::table('president')->where('type','message')->orderBy('id','desc')->get();
        return view('admin.messages')->with('messages',$messages);
    }
    public function words()
    {
        $words = DB::table('president')->where('type','word')->orderBy('id','desc')->get();
        return view('admin.words')->with('words',$words);
    }
}
