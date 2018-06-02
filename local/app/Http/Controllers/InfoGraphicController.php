<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InfoGraphic;
use App\Search;
use Session;
use File;
// use Log;
use Image;
use Auth;
use Carbon\Carbon;
use App\Log;
use Intervention\Image\ImageManager;

class InfoGraphicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = InfoGraphic::orderBy('id','desc')->get();
        return view('admin.infographics')->with('info',$info);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_infographic');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



       // multi language variables
        $lang = Session::get('lang');
        $title = 'title_'.$lang;
        $date = 'date_'.$lang;
          // 1
        $img = 'image_'.$lang;
        $img_thumb = "image_thumb_".$lang;
        // validation
        // 2
          $this->validate($request,[
            $title=>'required',
            $date=>'required',
            $img=>'required|mimes:jpg,jpeg,png,svg',
          ]);

        //data storage
         $info = new InfoGraphic();
         $info->$title = $request->$title;
         $info->$date = $request->$date;

         //save the record to retreive id later
         $info->save();

          $log = new Log();

          $log->table_name = 'infographics';
          $log->table_item_id = $info->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

         //retreive id from previously stored record
          $id = $info->id;

          //retreive info graphic object again
          $info = InfoGraphic::findOrFail($id);


          //make image path
          // 3
          $path = 'uploads/infographics/'.$lang."/";

          //variable for thumb image if present or otherwise
          $image_thumb_name = '';

          if($request->$img!='') {
            // make image
            $image = Image::make($request->$img);
            $image_thumb = Image::make($request->$img_thumb);
             // //resize if width larger than 2000px
             //  if($image->width()>2000) {
             //    $image->resize(725, null, function ($constraint) {
             //      $constraint->aspectRatio();
             //    });
             //  }

            //image names i.e. (image and image_thumb)
            $image_name = $id.'.'.$request->$img->getClientOriginalExtension();
            $image_thumb_name = $id.'_t.'.$request->$img_thumb->getClientOriginalExtension();

            // save the orignal image resized
            $image->save($path.$image_name);

            //resize image for thumbnail
            // $driver = new imageManager(array('driver'=>'gd'));
            // $image_thumb = $image->resize(200, null, function ($constraint) {
            //                   $constraint->aspectRatio();
            //                 });

            //store image and thumbnail in storage
            $image_thumb->save($path.$image_thumb_name);

            //db image storage
            $info->$img = $image_name;
            $info->$img_thumb = $image_thumb_name;

         }
          else {
            //if image not present for search table
            $image_thumb_name = 'default.jpg';

            //if no image received store the default
            $info->$img = 'default.jpg';
            $info->$img_thumb = 'thumb.jpg';
          }
           if($info->save()) {
              //search stuff
              $search = new Search();
              $search->$title = $request->$title;
              $search->$date = $request->$date;
              
              $search->table_name = 'infographics';
              $search->type = 'infographic';
              $search->table_id = $id;
              $search->image_thumb = $image_thumb_name;
              $search->save();
            }
            Session::put('lang','');
            // Log::info($id." InfoGraphics record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
            return Redirect()->route('infographic.index');
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
        $info = InfoGraphic::findOrFail($id);
        return view('admin.edit_infographic')->with('info',$info);

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
        $img = 'image_'.$lang;
        $img_thumb = "image_thumb_".$lang;
        
        // validation
        $this->validate($request,[
          $title=>'required',
        ]);

        // info graphics data storage
         $info = InfoGraphic::findOrFail($id);
         
         $search_obj = Search::where('table_name','=','infographics')->where('table_id','=',$id)->first();

         $info->$title = $request->$title;
         
         if($request->$date!='') {

           $info->$date = $request->$date;
         }
         
          if($request->$img!=null) {

            //construct image path
             $image_path = 'uploads/infographics/'.$lang.'/';
            
            // validation
              $this->validate($request,[
                $img=>'required|mimes:jpg,jpeg,png,svg,bmp',
              ]);

            if($search_obj!=''){
                if(file_exists($search_obj->image_thumb)){
                  //remove existing images
                  File::delete($search_obj->image_thumb);
                  File::delete(str_replace('_t','',$search_obj->image_thumb));
                }
            }

            //get the Image
            $image = Image::make($request->$img);
            $image_thumb = Image::make($request->$img_thumb);
                
           //  //resize if width larger than 2000px
           // if($image->width()>2000) {
           //    $image->resize(725, null, function ($constraint) {
           //    $constraint->aspectRatio();
           //    });
           //  }

             //set new images name
             $image_name = $id.'.'.$request->$img->getClientOriginalExtension();
             $image_thumb_name = $id.'_t.'.$request->$img_thumb->getClientOriginalExtension();

             $image->save($image_path.$image_name);
             
             //resize image for thumbnail
             // $driver = new imageManager(array('driver'=>'gd'));
             // $image_thumb =  $image->resize(200, null, function ($constraint) {
             //                  $constraint->aspectRatio();
             //                });

             //move i.e.(to storage) image
             $image_thumb->save($image_path.$image_thumb_name);
             //store in db
             $info->$img = $image_name;
             $info->$img_thumb = $image_thumb_name;
           }

           if($info->save()) {
               $search_obj->$title = $request->$title;
               $search_obj->$date = $request->$date;
               $search_obj->save();
             }

            $log = new Log();

            $log->table_name = 'infographics';
            $log->table_item_id = $id;
            $log->activity = 'update';
            $log->user_id = Auth::user()->id;
            $log->save();

             Session::put('lang','');
             // Log::info($id." $info->type updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
             return Redirect()->route('infographic.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $info = InfoGraphic::findOrFail($id);
        File::delete('uploads/infographics/en/'.$info->image_en);
        File::delete('uploads/infographics/dr/'.$info->image_dr);
        File::delete('uploads/infographics/pa/'.$info->image_pa);
        File::delete('uploads/infographics/en/'.$info->image_thumb_en);
        File::delete('uploads/infographics/dr/'.$info->image_thumb_dr);
        File::delete('uploads/infographics/pa/'.$info->image_thumb_pa);
        
        $search = Search::where('table_name','infographics')->where('table_id',$id);
        $search->delete();
        $info->delete();

        $log = new Log();

        $log->table_name = 'infographics';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();


        // Log::info($id." InfoGraphic deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('infographic.index');
    }
}
