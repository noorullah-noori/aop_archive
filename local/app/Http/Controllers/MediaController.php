<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Media;
use DB;
use App\Search;
use File;
use Session;
// use Log;
use Image;
use Auth;
use Carbon\Carbon;
use App\Log;
use Intervention\Image\ImageManager;

class MediaController extends Controller
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
        return view('admin.create_media');
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
        // print_r($image);exit;

        // validation
          $this->validate($request,[
           $title=>'required|max:255|unique:media',
           $date=>'required',
           $short_desc=>'required|max:250',
           $description=>'required',
           'image-data' =>'required',
          ]);

        //data storage
        $media = new Media();
        $media->$title = $request->$title;
        if($lang!='en'){
         $media->date_pa = $request->$date;
         $media->date_dr = $request->$date;
        }
        else{
         $media->date_en = $request->$date; 
        }
        $media->$short_desc = $request->$short_desc;
        $media->$description = $request->$description;
        $media->type = $request->type;
        $media->tags = $request->input('tags_array');
        $media->type = $request->input('type');

        //save the record to retreive id later
        $media->save();

        $log = new Log();

        $log->table_name = 'media';
        $log->table_item_id = $media->id;
        $log->activity = 'create';
        $log->user_id = Auth::user()->id;
        $log->save();

        //retreive id from previously stored record
        $id = $media->id;
        // $id = 99;

        //retreive media object again
        $media = Media::findOrFail($id);

         //make image path
        $path = 'uploads/'.$request->type.'/';

        //variable for thumb image if present or otherwise
        $image_thumb_name = '';

          //image uploading
        if($request->input('image-data')!='') {
          // if image is present

          //get the Image
          $image = Image::make($request->input('image-data'));
          //resize if width larger than 2000px
          if($image->width()>2000) {
            $image->resize(725, null, function ($constraint) {
              $constraint->aspectRatio();
            });
          }
          // set an image name and path
          $image_name = $id.'.jpg';
          // save the image to storage and store in db
          $image->save($path.$image_name);
          $media->image = $image_name;


          //make thumbnail

          // set an image thumbnail name and path
          $image_thumb_name = $id.'_t.jpg';
          //resize image for thumbnail
          $image_thumb = $image->resize(200, null, function ($constraint) {
                            $constraint->aspectRatio();
                          });

          // save the thumbnail image to storage and store in db
          $image_thumb->save($path.$image_thumb_name);
          $media->image_thumb = $image_thumb_name;
          $media->save();
        }
         else {
          //if image not present for search table
          $image_thumb_name = 'default.jpg';

          //if no image received store the default
          $media->image = 'default.jpg';
          $media->image_thumb = 'thumb.jpg';
        }

        if($media->save()) {
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
          $search->table_name = 'media';
          $search->type = $request->type;
          $search->table_id = $id;
          $search->image_thumb = $path.$image_thumb_name;
          $search->save();
        }
        Session::put('lang','');
        Session::put('type','');
        // Log::info($id." Media record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
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
        $media = Media::findOrFail($id);
        return view('admin.edit_media')->with('media',$media);
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
          $title=>'required|max:250',
          $short_desc=>'required|max:250',
          $description=>'required',
        ]);

      // media data storage
       $media = Media::findOrFail($id);
       $search_obj = Search::where('table_name','=','media')->where('table_id','=',$id)->first();
       $media->$title = $request->$title;
       if($request->$date!='') {
         if($lang!='en'){
           $media->date_pa = $request->$date;
           $media->date_dr = $request->$date;
          }
          else{
           $media->date_en = $request->$date; 
          }
       }
       $media->$short_desc = $request->$short_desc;
       $media->$description = $request->$description;

        //image uploading
      if($request->input('image-data')!='') {
        // if image is present

        //make image path
       $path = 'uploads/'.$request->type.'/';

        //get the Image
        $image = Image::make($request->input('image-data'));

        //resize if width larger than 2000px
        if($image->width()>2000) {
          $image->resize(725, null, function ($constraint) {
            $constraint->aspectRatio();
          });
        }

        // set an image name and path
        $image_name = $id.'.jpg';
        // save the image to storage and store in db
        $image->save($path.$image_name);
        $media->image = $image_name;


        //make thumbnail

        // set an image thumbnail name and path
        $image_thumb_name = $id.'_t.jpg';
        //resize image for thumbnail
        $image_thumb = $image->resize(200, null, function ($constraint) {
                          $constraint->aspectRatio();
                        });

        // save the thumbnail image to storage and store in db
        $image_thumb->save($path.$image_thumb_name);
        $media->image_thumb = $image_thumb_name;
        $media->save();
       }

       if($media->save()) {
         $search_obj->$title = $request->$title;
        if($request->$date!='') {
         if($lang!='en'){
           $search_obj->date_pa = $request->$date;
           $search_obj->date_dr = $request->$date;
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

        $log->table_name = 'media';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

       Session::put('lang','');
       // Log::info($id." $media->type updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
       return Redirect()->route("admin_".$media->type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $media = Media::findOrFail($id);
        $type = $media->type;
        // File::delete(public_path().'../uploads/media/'.$type.'/'.$media->image);
        $path = 'uploads/'.$type.'/'.$media->image;
        $path_thumb = 'uploads/'.$type.'/'.$media->image_thumb;
        File::delete($path);
        File::delete($path_thumb);
        $search = Search::where('table_name','media')->where('table_id',$id);
        $search->delete();
        $media->delete();
        
        $log = new Log();

        $log->table_name = 'media';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info($id." $type deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('admin_'.$type);
    }

     public function news()
    {
        $news = DB::table('media')->where('type','news')->orderBy('id','desc')->get();
        return view('admin.news')->with('news',$news);
    }

    public function articles()
    {
        $articles = DB::table('media')->where('type','article')->orderBy('id','desc')->get();
        return view('admin.articles')->with('articles',$articles);
    }

     public function reports()
    {
        $reports = DB::table('media')->where('type','report')->orderBy('id','desc')->get();
        return view('admin.reports')->with('reports',$reports);
    }
}
