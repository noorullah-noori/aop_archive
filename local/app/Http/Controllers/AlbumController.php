<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\AlbumImage;
use App\Search;
use DB;
use File;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;
use Session;
use Intervention\Image\ImageManager;
class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $album = Album::orderBy('id','desc')->get();
         if(Session::get('view_lang')==''){
          Session::put('view_lang','en');
         }
        return view('admin.album')->with('album',$album);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_album');
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

          // validation
          $this->validate($request,[
           $title=>'required|max:255|unique:album',
           $date=>'required',
           'image'=>'required|mimes:jpg,jpeg,png,bmp',
          ]);

         //data storage
         $album = new Album();
         $album->$title = $request->$title;
         if($lang!='en'){
         $album->date_dr = $request->$date;
         $album->date_pa = $request->$date;
         }
         else{
          $album->date_en = $request->$date;
         }

         //save the record to retreive id later
         $album->save();

          $log = new Log();

          $log->table_name = 'album';
          $log->table_item_id = $album->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

         //retreive id from previously stored record
          $id = $album->id;

          //retreive Album graphic object again
          $album = Album::findOrFail($id);

           //make image path
            $path = 'uploads/album/';
          
              //image uploading
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
                  $album->image = $image_name;
                  $album->image_thumb = $image_thumb_name;

                }
               else {
                //if image not present for search table
                $image_thumb_name = 'default.jpg';

                //if no image received store the default
                $album->image = 'default.jpg';
                $album->image_thumb = 'thumb.jpg';
              }

               if($album->save()) {
                  //search stuff
                  $search = new Search();
                  $search->$title = $request->$title;
                  if($lang!='en'){
                     $search->date_dr = $request->$date;
                     $search->date_pa = $request->$date;
                  }
                  else{
                      $search->date_en = $request->$date;
                  }
                  
                  $search->table_name = 'album';
                  $search->type = 'album';
                  $search->table_id = $id;
                  $search->image_thumb = $path.$image_thumb_name;
                  $search->save();
                }
                Session::put('lang','');
                // Log::info($id." Album record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
                return Redirect()->route('album.index');

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
        $album = Album::findOrFail($id);
        return view('admin.edit_album')->with(['album'=>$album]);
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
        // validation
        $this->validate($request,[
          $title=>'required',
        ]);

      // album data storage
       $album = Album::findOrFail($id);
       $search_obj = Search::where('table_name','=','album')->where('table_id','=',$id)->first();
       $album->$title = $request->$title;
       if($request->$date!='') {
         if($lang!='en'){
             $album->date_dr = $request->$date;
             $album->date_pa = $request->$date;
          }
          else{
              $album->date_en = $request->$date;
          }
       }

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
         $image_path = 'uploads/album/';

         //move i.e.(to storage) image
         $image_thumb->save($image_path.$image_thumb_name);
         $request->image->move($image_path,$image_name);

         //store in db
         $album->image = $image_name;
         $album->image_thumb = $image_thumb_name;
       }

        if($album->save()) {
         $search_obj->$title = $request->$title;
         if($lang!='en'){
             $search_obj->date_dr = $request->$date;
             $search_obj->date_pa = $request->$date;
          }
          else{
              $search_obj->date_en = $request->$date;
          }
         $search_obj->save();
       }

          $log = new Log();

          $log->table_name = 'album';
          $log->table_item_id = $id;
          $log->activity = 'update';
          $log->user_id = Auth::user()->id;
          $log->save();
          
         Session::put('lang','');
         // Log::info($id." $album->type updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
         return Redirect()->route('album.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $album = Album::findOrFail($id);
        $album_images = DB::table('album_image')->where('album_id',$id)->get();
        if(sizeof($album_images)>0){
          foreach ($album_images as $value) {
              File::delete('uploads/albumImage/'.$value->image);
              $album_image = AlbumImage::findOrFail($value->id);
              $album_image->delete();
          }
        }
        File::delete('uploads/album/'.$album->image);
        File::delete('uploads/album/'.$album->image_thumb);

        if($album->delete()){
            $search = Search::where('table_name','=','album')->where('table_id','=',$id)->first();
            $search->delete();
        }
          
          $log = new Log();

          $log->table_name = 'album';
          $log->table_item_id = $id;
          $log->activity = 'delete';
          $log->user_id = Auth::user()->id;
          $log->save();

        // Log::info("ID No. ".$id." Album deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return redirect()->route('album.index');
    }

    public function add_album_image($id){
        return view('admin.add_album_image')->with('id',$id);
    }

    public function add_image(Request $request,$id){

        foreach ($request->image as $value) {
            // validation
            $this->validate($request,[
             "$value"=>'mimes:jpg,jpeg,png,bmp',
            ]);

            $album_image = new AlbumImage();
            $album_image->album_id = $id;

            if($album_image->save()){
              $max = $album_image->id;
              $album_image = AlbumImage::findOrFail($max);
              $img = $max.'.'.$value->getClientOriginalExtension();
              $value->move('uploads/albumImage/',$img);
              $album_image->image = $img;
              $album_image->save();
            }
        }
          $log = new Log();

          $log->table_name = 'album_image';
          $log->table_item_id = $album_image->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

        // Log::info("Images added to ID No.  ".$id." album by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return redirect()->route('album.index');
    }

     public function view_album_images($id){
        $album_images = DB::table('album_image')->where('album_id',$id)->get();
        return view('admin.view_album_images')->with(['images'=>$album_images,'album_id'=>$id]);
    }

    public function update_album_image_title($id , Request $request){
        $lang = Session::get('view_lang');
        $title = "title_".$lang;
        $album_image = AlbumImage::findOrFail($id);
        $album_image->$title = $request->title;
        $album_image->save();
          

          $log = new Log();

          $log->table_name = 'album';
          $log->table_item_id = $id;
          $log->activity = 'update';
          $log->user_id = Auth::user()->id;
          $log->save();

        $album_images = DB::table('album_image')->where('album_id',$request->album_id)->get();
        return view('admin.view_album_images')->with(['images'=>$album_images,'album_id'=>$request->album_id]);
    }

    public function edit_images($id){
        $album_images = DB::table('album_image')->where('album_id',$id)->get();
        return view('admin.edit_album_images')->with(['images'=>$album_images,'id'=>$id]);
    }

    public function edit_album_image($id){
        $album_image = AlbumImage::findOrFail($id);
        return view('admin.edit_album_image')->with('image',$album_image);
    }
    public function update_album_image(Request $request , $id){

        // validation
          $this->validate($request,[
           'image'=>'mimes:jpg,jpej,png,bmp',
          ]);

        $album_image = AlbumImage::findOrFail($id);

        $image = '';
        if($request->file('image')==null){
            $image = $album_image->image;
        }
        else{
            File::delete('uploads/albumImage/'.$album_image->image);
            $image = $id.'.'.$request->file('image')->getClientOriginalExtension();
            $request->file('image')->move('uploads/albumImage/',$image);
        }
        $album_image->image = $image;
        $album_image->save();


        $log = new Log();

        $log->table_name = 'album_image';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info("Images updated in ".$id." album by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return redirect()->route('album.index');
    }

      public function delete_album_image($id,$album_id){

        $album_image = AlbumImage::findOrFail($id);
        File::delete('uploads/albumImage/'.$album_image->image);
        $album_image->delete();
        
        $log = new Log();

        $log->table_name = 'album_image';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info("Image deleted from ".$id." album by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return \Redirect::to('admin/edit_images/'.$album_id);
    }
}
