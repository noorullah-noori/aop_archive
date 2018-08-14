<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Document;
use App\Category;
use App\Department;
use App\DocumentLanguage;
use App\Upload;
use App\Enquiry;
use App\User;
use App\Log;
use Session;

// use Image;
use Intervention\Image\Facades\Image;
use File;
use Intervention\Image\ImageManager;
use Carbon\Carbon;
use Auth;
use Verta;
use App\DataTables\DocumentsDataTable;
use App\Notifications\DocumentRejected;
use App\Notifications\RequestStatus;
use App\Notifications\RequestStockEdit;
use App\Rules\UniqueDocument;
use Validator;



class DocumentController extends Controller
{

    // public function __construct() {
    //     $this->middleware(['clearance']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('saved_documents');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $departments = Department::orderBy('id','desc')->get();
        $document_language = DocumentLanguage::orderBy('id','desc')->get();
        return view('add_document')->with(['categories'=>$categories,'departments'=>$departments,'document_language'=>$document_language]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate Request
        $validator = Validator::make($request->all(), [
          'document_number'=>"required",
          'document_date'=>'required',
          'document_subject'=>'required',
          'document_page_count'=>'required|numeric',
          'document_department'=>'required',
          'language_id'=>'required',
        ]);

        $validator->after(function($validator) use($request)
        {
            $already_exists = Document::where('number',$request->document_number)->where('date',$request->document_date)->where('category_id',$request->document_categories)->exists();
            if($already_exists) {
                $validator->errors()->add('aleady_exists', 'سند موجود است');
            }
        });

        if ($validator->fails())
        {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }


        // create document object and store necessary information

        $document = new Document();
        $document->number = $request->document_number;
        $document->date = $request->document_date;
        $document->subject = $request->document_subject;
        $document->total_pages = $request->document_page_count;
        $document->category_id = $request->document_categories;
        $document->department_id = $request->document_department;
        $document->receiver = $request->receiver;
        $document->description = $request->description;
        $document->countries = $request->countries;
        $document->document_language_id= $request->language_id ;
        $document->created_by = Auth::user()->id;
        $document->created_at = Verta::now();

        // save the document to get the id
        $document->save();

        createLog('documents',$document->id,'درج سند');



        // document path for storing image(s)
        $path = 'uploads/'.$document->category_id.'/';

        // variable for numbering pages i.e. images(s)
        $i=1;

        // resizing and storing image
        foreach ($request->selected_files as $item) {
          // create uploads object i.e. (uploads table) and store each file in it with document id
          $uploads = new Upload();
          $uploads->document_id = $document->id;

          // resize image if image width is greater than 2000 pixels
          $image = Image::make($item);
          if($image->width()>2000) {
            // resize the image to a width of 1920 and constrain aspect ratio (auto height)
            $image->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
            });
          }

          // path for current image
          $image_name = $document->id.'_'.$i.'.'.$item->getClientOriginalExtension();

          // store current image path in db
          $uploads->file_path = $path.$image_name;

          // create directory based on category if not present
          if(!file_exists($path)) {
            File::makeDirectory($path);
          }

          //store the image in the specified directory
          $image->save($path.$image_name);

          $uploads->save();
          // increment for next image
          $i++;
        }

        Session::flash('success','سند مؤفقانه ثبت گردید.');
        return redirect()->route('documents.create');

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
        $document = Document::find($id);
        $categories = Category::all();
        // select document types which are given permission to the user
        // $roles = Auth::user()->getRoleNames();
        // $rolesArray = $roles->toArray();
        // $categories = new Collection();
        // foreach($rolesArray as $key =>$value){
        //   $categories->push(Category::where('name_en',$value)->first());
        // }

        $document_language = DocumentLanguage::orderBy('id','desc')->get();
        $departments = Department::orderBy('id','desc')->get();
        return view('edit_document')->with(['document'=>$document,'categories'=>$categories,'departments'=>$departments,'document_language'=>$document_language]);
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
      $countries= $request->countries!=''?array_unique($request->countries):null;

        // Validate Request
        $this->validate($request,[
          'document_number'=>'required|numeric',
          'document_date'=>'required',
          'document_subject'=>'required',
          'document_page_count'=>'required|numeric',
          'document_categories'=>'required',
          'document_department'=>'required',
          'language_id'=>'required',
        ]);

        // retreive document record for updating
        $document = Document::findOrFail($id);

        // store updated information in fields
        $document->number = $request->document_number;
        $document->date = $request->document_date;
        $document->subject = $request->document_subject;
        $document->total_pages = $request->document_page_count;
        $document->category_id = $request->document_categories;
        $document->department_id = $request->document_department;
        $document->receiver = $request->receiver;
        $document->description = $request->description;
        $document->countries = $countries;
        $document->document_language_id = $request->language_id;
        $document->updated_by = Auth::user()->id;
        $document->updated_at = Verta::now();
        $document->status = 0;


        // document path
        $path = 'uploads/'.$document->category_id.'/';

        $uploads = $document->uploads;

         // variable for numbering pages i.e. files
        $i=1;


        // updating existing images names
        foreach ($uploads as $upload) {
            $extension = File::extension($upload->file_path);

            // new name for current image
            $image_name = $id.'_'.$i.'.'.$extension;

            // full path for current image
            $new_full_path = $path.$image_name;

            // create category directory if not present
            if(!file_exists($path)) {
                File::makeDirectory($path);
            }


            $image = Image::make($upload->file_path);
            // remove the file if already exists with the same name
            if(file_exists($upload->file_path)){
                File::delete($upload->file_path);
            }
            //store the image in the specified path
            $image->save($new_full_path);

            // store new file path in db
            $upload->file_path = $new_full_path;

            // save the current upload object
            $upload->save();

            // increment for next image
            $i++;
        }

        // upload new images if selected
        if ($request->selected_files!='') {
            foreach ($request->selected_files as $item) {

              // set current image name
              $image_name = $id.'_'.$i.'.'.$item->getClientOriginalExtension();

              // full path for current image
              $new_full_path = $path.$image_name;

              $upload = new Upload();

              // create new intervention object for current image
              $image = Image::make($item);

              // resize image if image width is greater than 2000 pixels
              if($image->width()>2000) {

                // resize the image to a width of 1920 and constrain aspect ratio (auto height)
                $image->resize(1920, null, function ($constraint) {
                  $constraint->aspectRatio();
                });
              }

              // store path for current image in db
              $upload->file_path = $new_full_path;


              //store the current image in specified directory
              $image->save($new_full_path);

              // the current image belongs to document with id:
              $upload->document_id = $id;

              // store current image information in db
              $upload->save();

              // increment $i for naming next image
              $i++;
            }
        }

        // store updated document information in db
        $document->save();

        createLog('documents',$id,'تصحیح سند درج شده');


        if(strpos(url()->previous(),'rejected')) {
            $route = 'rejected_documents';
        }
        else {
            $route = 'documents.index';
        }

        return redirect()->route($route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Approve/reject registered documents view.
     *
     * @return \Illuminate\Http\Response
     */

    public function documentsApproval(){
        return view('documents_approval');
    }


    // show saved Documents Datatable
    public function getApprovableDocumentsDatatable(){

        $documents = Document::with('category')->with('user')->with('department')->with('document_language')->select('id','number','subject','date','total_pages','department_id','category_id','document_language_id','created_by')->where('status','0')->orderBy('id','desc');
        return Datatables::of($documents)->addColumn('action',function($row){
            return '<a href="'.route('show_approvable_document',$row['id']).'" class="btn "><i style="font-size:1.3em !important;" class="icon-eye"></i></a>';
        })->make();
    }

    /**
     * show Approvable/saved document.
     *
     * @return \Illuminate\Http\Response
     */
    public function showApprovableDocuments($id){
        $document  = Document::findOrFail($id);
        $uploads = Upload::where('document_id',$id)->get();
        return view('approvable_document')->with(['document'=>$document,'uploads'=>$uploads]);
    }

    /**
     * show Approved documents.
     *
     * @return \Illuminate\Http\Response
     */

    public function approvedDocuments(){
        return view('approved_documents');
    }

    /**
     * show Approved documents.
     *
     * @return \Illuminate\Http\Response
     */

    public function getApprovedDocumentsDatatable(){
      if(Auth::user()->hasrole('admin')){
        $documents = Document::with('category')->with('department')->with('document_language')->with('uploads')->select('id','number','subject','date','total_pages','department_id','category_id','document_language_id')->where('status','1')->orderBy('id','desc');
      }
      else{
        $documents = Document::with('category')->with('department')->with('document_language')->with('uploads')->select('id','number','subject','date','total_pages','department_id','category_id','document_language_id')->where('status','1')->where('approve_reject_auth',Auth::user()->id)->orderBy('id','desc');
      }
        return Datatables::of($documents)
        ->addColumn('files',function($row){
            $res = '<a href="'.route('browse_images',$row['id']).'" target="_blank" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-paper-clip"></i></a>';
            if(Auth::user()->hasrole('approval')) {
              $res .='<a href="'.route('undo_approval',$row['id']).'" onclick="confirm("آیا مطمئن هستید این فایل را از حالت تاییدی خارج کنید؟")" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-action-undo"></i></a>';
            }
            return $res;

        })
        ->rawColumns(['files'])
        ->make();
    }

    /**
     * Undo Approve/reject
     *
     * @return \Illuminate\Http\Response
     */
    public function undoApproval($id){
      $document = Document::findOrFail($id);

      if($document->status==1){
          createLog('documents',$id,'لغو تایید سند');
      }
      else{
        createLog('documents',$id,'لغو رد سند');
      }

      $document->status = 0;
      $document->save();

      return Redirect()->route('approved_documents');
    }

    /**
     * show Approved documents.
     *
     * @return \Illuminate\Http\Response
     */

    public function getRejectedDocumentsDatatable(){
        if(Auth::user()->hasrole('admin')){
          $documents = Document::with('category')->with('department')->with('document_language')->with('uploads')->where('status',2)->orderBy('id','desc');
        }
        else if(Auth::user()->hasrole('entry')){
          $documents = Document::with('category')->with('department')->with('document_language')->with('uploads')->where('status',2)->where('created_by',Auth::user()->id)->orderBy('id','desc')->get();
        }
        else{
          $documents = Document::with('category')->with('department')->with('document_language')->with('uploads')->where('status',2)->where('approve_reject_auth',Auth::user()->id)->orderBy('id','desc')->get();
        }
        return Datatables::of($documents)
        ->addColumn('files',function($row){
            $res = '<a href="'.route('browse_images',$row['id']).'" target="_blank" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-paper-clip"></i></a>';
            if(Auth::user()->can('undo_approval')){
              $res .= '<a href="'.route('undo_approval',$row['id']).'" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-action-undo"></i></a>';
            }
            if(Auth::user()->can('edit_rejected_document')) {
              $res .= '<a href="'.route('edit_rejected_document',$row['id']).'" target="_blank" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-note"></i></a>';
            }
            return $res;
        })
        ->rawColumns(['files'])
        ->make();
    }


    /**
     * show Rejected documents.
     *
     * @return \Illuminate\Http\Response
     */

    public function rejectedDocuments(){
        return view('rejected_documents');
    }

    // //Get rejected documents
    // public function getRejectedDocuments(){
    //
    //     $documents = Document::with('category')->with('department')->select('documents.*')->where('status',2);
    //     return Datatables::of($documents)
    //     // ->addColumn('action',function($row) {
    //     //     return '<a href="'.route('edit_rejected_document',$row['id']).'" class=""><i style="font-size:1.3em !important;" class="icon-note"></i></a>';
    //     // })
    //     ->make();
    // }

    /**
     * Edit Form For rejected Document.
     *
     * @return Form
     */

    public function editRejectedDocument($id){
        // retreive rejected document model record
        $document = Document::findOrFail($id);
        $categories = Category::all();

        $departments = Department::orderBy('id','desc')->get();
        $document_language = DocumentLanguage::orderBy('id','desc')->get();
        // $user = User::find($document->created_by);
        return view('edit_rejected_document')->with(['document'=>$document,'departments'=>$departments,'categories'=>$categories,'document_language'=>$document_language]);
    }



    /**
     * stocked documents.
     *
     * @return \Illuminate\Http\Response
     */

    public function stockableDocuments(){
        return view('stockable_documents');
    }


    /**
     * Get Stockable Documents Datatable
     *
     * @return \Illuminate\Http\Response
     */

    public function getStockableDocumentsDatatable(){
        $documents = Document::with('category')->with('department')->with('document_language')->select('documents.*')->where('status',1)->orderBy('id','desc');
        return Datatables::of($documents)
        ->addColumn('action',function($row) {
            return '<a href="'.route('show_stockable_document_form',$row['id']).'" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-drawer"></i></a>';
        })
        ->make();
    }


    /**
     *
     * Show stockable item form
     *
     * @return \Illuminate\Http\Response
     */

    public function showStockableDocumentForm($id){
        // get stockable document Model
        $document = Document::findOrFail($id);
        return view('stock_document')->with('document',$document);
    }

    public function getFolderCount(Request $request){
      $year = $request->year;
      $number = $request->number;
      $row = $request->row;
      $folder = $request->folder;
      $category_id = $request->category_id;

      $count = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->where('folder',$folder)->where('category_id',$category_id)->max('file');
      $folder_count = '';
      if($count==null){
        $folder_count = 0;
      }
      else{
          $folder_count = $count;
      }
      return $folder_count;
    }

    public function getAvailableFolders(Request $request){
        $year = $request->year;
        $number = $request->number;
        $row = $request->row;
        $category_id = $request->category_id;

        $final = '';
        $last_folder = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->select('folder')->orderBy('id','desc')->first();
        $folder_value = '';
        if($last_folder!=''){
            $folder_value = $last_folder->folder+1;
        }
        else{
            $folder_value = 1;
        }

        $folders = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->where('category_id',$category_id)->select('folder','folder_count')->orderBy('id','desc')->get();

        if(sizeof($folders)==0){
            $final = [array(
                'folder' => $folder_value,
                'folder_count' => 0,
            )];
        }
        else{
            $final  =$folders->toArray();
            $final[sizeof($final)+1] = array(
                'folder'=>$folder_value,
                'folder_count'=>0,
            );

        }

        return $final;
      }


    public function folderView(){
        $categories = Category::all();
        return view('folder_view')->with('categories', $categories);
    }

    public function getFolders(Request $request){

        $year = $request->cabinet_year;
        $number = $request->cabinet_number;
        $row = $request->row;


        // $folders = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->groupBy('category_id')->selectRaw("MIN(folder_count) AS folder_to, MAX(folder_count) AS folder_from,folder,category_id")->get();
        // $folders = Document::with('category')->where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->where('category_id', $category)->orderBy('category_id')->get();
        // $alert= '';

        $folders = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->groupBy('folder')->get();

        // $folders = Document::where('cabinet_year',$year)->where('cabinet_number',$number)->where('row',$row)->groupBy('category_id')->selectRaw("MIN(folder_count) AS folder_to, MAX(folder_count) AS folder_from,folder,category_id")->get();

        // $alert= '';
        // $alert = 'نمایش اسناد '.$data['alert'].' به تاریخ ""';

        // $documents->put('alert', $alert);
        return view('folders_view')->with(['folders'=>$folders]);
    }

    public function printFolder($folder){
      
        $year = $_GET['year'];
        $cabinet = $_GET['cabinet'];
        $row = $_GET['row'];
        $document = $_GET['document'];

        $min = Document::where('cabinet_year',$year)->where('cabinet_number',$cabinet)->where('row',$row)->where('folder',$folder)->min('file');
        $max = Document::where('cabinet_year',$year)->where('cabinet_number',$cabinet)->where('row',$row)->where('folder',$folder)->max('file');
        
        return view('print_folder')->with(['min'=>$min,'max'=>$max,'document'=>$document,'year'=>$year,'folder'=>$folder]);
    }


    public function getFolderData($id){

        $folder_data = Document::findOrFail($id);
        $type = $folder_data->category->name;



    }

    /**
     * Stock a stockable item into the database
     *
     * @return \Illuminate\Http\Response
     */

     public function stockDocument($id , Request $request){
        // Validate Request

        $this->validate($request,[
            'cabinet_year'=>'numeric|required',
            'cabinet_number'=>'numeric|required',
            'row'=>'required|numeric',
            'folder'=>'required|numeric',
            'file'=>'required|numeric',
        ]);

        $print_check=$request->checkbox;

        // generating lable for document
        $label = $request->cabinet_year.'-'.$request->cabinet_number.'-'.$request->row.'-'.$request->folder.'-'.$request->file;

        // get stockable document Model and store form data in it
        $document = Document::findOrFail($id);
        $document->cabinet_year = $request->cabinet_year;
        $document->cabinet_number = $request->cabinet_number;
        $document->row = $request->row;
        $document->folder = $request->folder;
        $document->file = $request->file;
        $document->stocked_by = Auth::user()->id;
        $document->stocked_date = Verta::now();
        $document->status = 3;
        $document->label = $label;
        $document->save();
        createLog('documents',$document->id,'جابجایی سند');
        if($print_check =='on'){
          createLog('documents',$document->id,'چاپ فهرست و لیبل');
        return view('print_label')->with(['label'=>$label,'id'=>$id]);

        }else{

         return redirect()->route('stockable_documents')->with('success','سند موفقانه جابجا گردید!.');

        }
    }

    public function printCover($id,$reprint=''){
      $documents = Document::with('category')->with('department')->with('document_language')->select('documents.*')->where('id',$id)->first();
      createLog('documents',$id,'چاپ دوباره فهرست');
      return view('print_cover')->with(['documents'=>$documents,'reprint'=>$reprint]);
    }

    /**
     * show saved documents list
     *
     * @return \Illuminate\Http\Response
     */
     public function savedDocuments()
     {
       return view('saved_documents');
     }

    /**
     * get saved documents datatable
     *
     * @return \Illuminate\Http\Response
     */
     public function getSavedDocumentsDatatable()
     {
       if(Auth::user()->hasrole('admin')){
         $documents = Document::with('department')->with('category')->with('document_language')->where('status',0)->orderBy('id','desc');
       }
       else{
         $documents = Document::with('department')->with('category')->with('document_language')->where('status',0)->where('created_by',Auth::user()->id)->orderBy('id','desc');
       }

       $i=0;
       return Datatables::of($documents)
       ->editColumn('id',function($row) use(&$i) {
        return ++$i;
      })
       ->addColumn('action',function($row) {
           $res = '<a href="'.route('browse_images',$row['id']).'" class="btn btn-xs"><i style="font-size:1.3em !important;" class=" icon-eye"></i></a>';
           if(Auth::user()->can("edit_saved_document")) {
             $res .= '<a href="'.route('documents.edit',$row['id']).'" class="btn btn-xs"><i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
           }
           return $res;

       })
       ->make();
     }



         /**
     * show completed documents list
     *
     * @return \Illuminate\Http\Response
     */
     public function completedDocuments()
     {
       return view('completed_documents');
     }

    /**
     * get completed documents datatable
     *
     * @return \Illuminate\Http\Response
     */
     public function getCompletedDocumentsDatatable()
     {
      //  get completed documents i.e. entry, approve, stock done
       if(Auth::user()->hasrole('admin')){
        //  for admin show documents stocked by anyone
         $documents = Document::with('category')->with('department')->with('document_language')->select('documents.*')->where('status',3)->orderBy('id','desc')->get();
       }
       else{
        //  for stock user display documents stocked by user only
         $documents = Document::with('category')->with('department')->with('document_language')->select('documents.*')->where('status',3)->where('stocked_by',Auth::user()->id)->orderBy('id','desc')->get();
       }



      //  $i=0;
       return Datatables::of($documents)
       ->addColumn('files',function($row) {

          //  detailed information about document
          $res =  '<a href="'.route('browse_images',$row['id']).'" target="_blank" data-toggle="tooltip" data-placement="top" title="نمایش فایل و معلومات سند" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-paper-clip"></i></a>'
          .'<a href="'.route('label_print',$row['id']).'"  data-toggle="tooltip" data-placement="top" title="پرنت لیبل" target="_blank"  class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-printer"></i></a>'
          .'<a href="'.url('print_cover/'.$row['id'].'/reprint').'"  data-toggle="tooltip" data-placement="top" title="پرنت معلومات سند! " target="_blank"  class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-screen-tablet"></i></a>';


          // code for requesting stock edit
          if(Auth::user()->hasrole('stock')){
              //$res .= '<a href="'.route('edit_stock',$row['id']).'" class="btn" data-toggle="tooltip" data-placement="top" title="تصحیح جابجایی اسند"  style="padding:0;"><i style="font-size:1.3em !important;" class="icon-note"></i></a>';
            // }

          }
          return $res;
       })
       ->rawColumns(['files'])
       ->make();
     }

     /**
      * submit request to admin for editing stocked data
      *
      * @return \Illuminate\Http\Response
      */
    // public function submitStockEditRequest($id, Request $request){
    //   $document = Document::findOrFail($id);
    //   $document->stock_edit_request_date = Verta::now();
    //   $document->stock_edit_request_by = Auth::user()->id;
    //   $document->stock_edit_request_remarks = $request->remarks;
    //   $document->stock_edit_request_approve = 0;
    //   $document->save();

    //   createLog('documents',$id,'درخواست تصحیح جابجایی سند');
    //   if(auth()->user()->hasRole('stock')) {
    //     $user = User::find(1);//admin
    //     $notifications = $user->notifications->pluck('data.document_id')->toArray();
    //     if(!in_array($id,$notifications )) {
    //       $user->notify(new RequestStockEdit($id,'stock_edit', $request->remarks, 'admin', 'success' ));
    //     }
    //   }

    //   Session::flash('success','درخواست موفقانه ثبت گردید!!!');
    //   return Redirect()->route('completed_documents');
    // }

       /**
        * show all the requests for editing stocked data to admin
        *
        * @return \Illuminate\Http\Response
       //  */
       // public function stockEditRequests(){
       //   return view('stock_edit_requests');
       // }


     /**
      * show all the requests datatable for editing stocked data
      *
      * @return \Illuminate\Http\Response
      */
      // public function getEditRequestsDatatable()
      // {

      //     $requests = Document::with('category')->with('department')->select('documents.*')->where('status',3)->whereNotNull('stock_edit_request_by')->where('stock_edit_request_approve',0)->orderBy('id','desc')->get();

      //   $i=0;
      //   return Datatables::of($requests)
      //   ->addColumn('files',function($row) {
      //      return '<a href="'.route('show_stock_edit_request',$row['id']).'" class="btn "><i style="font-size:1.3em !important;" class="icon-eye"></i></a>';
      //   })
      //   ->rawColumns(['files'])
      //   ->make();
      // }


          /**
           * Show reuested document details for editing stocked data
           *
           * @return \Illuminate\Http\Response
           */
          public function showStockEditRequest($id){
              $document  = Document::findOrFail($id);
              $uploads = Upload::where('document_id',$id)->get();
              return view('show_stock_edit_request')->with(['document'=>$document,'uploads'=>$uploads]);
          }

          /**
           * approve request for updating stocked data
           *
           * @return \Illuminate\Http\Response
           */
          public function approveRequest($id){
              $document  = Document::findOrFail($id);
              $document->stock_edit_request_approve = 1;
              $document->stock_edit_request_approve_date = Verta::now();
              $document->save();

              createLog('documents',$id,'تایید درخواست تصحیح جابجایی سند');

              Session::flash('success','درخواست موفقانه ثبت گردید!!!');
              return Redirect()->route('stock_edit_requests');
          }

          /**
           * Reject request for editing stocked data
           *
           * @return \Illuminate\Http\Response
           */
          public function rejectRequest($id , Request $request){
              $document  = Document::findOrFail($id);
              $document->stock_edit_request_approve = 2;
              $document->stock_edit_request_approve_date = Verta::now();
              $document->stock_edit_request_reject_remarks = $request->remarks;
              $document->save();

              createLog('documents',$id,'رد درخواست تصحیح جابجایی سند');

              Session::flash('success','درخواست موفقانه ثبت گردید!!!');
              return Redirect()->route('stock_edit_requests');
          }



      /**
       * show form for editing stock data
       *
       * @return \Illuminate\Http\Response
       */
       public function editStock($id){
         $document = Document::findOrFail($id);
         return view('edit_stock')->with('document',$document);
       }

     /**
      * update Stocked item into the database
      *
      * @return \Illuminate\Http\Response
      */

      public function updateStock($id , Request $request){

         // Validate Request
         $this->validate($request,[
             'block'=>'numeric|required',
             'section'=>'required|string',
             'row'=>'required|numeric',
             'cabinet_row'=>'required|numeric',
             'cabinet_column'=>'required|numeric',
             'cabinet_side'=>'required|string',
             'edition'=>'numeric',
         ]);

         $print_check=$request->checkbox;
         $row = sprintf("%02d",$request->row);
         $column = sprintf("%02d",$request->cabinet_column);

         // generating lable for document
         $label = $request->block.'-'.$request->section.'-'.$row.'-'.$request->cabinet_side.'-'.$request->cabinet_row.'-'.$column.'-D'.$request->edition;


         // get stockable document Model and store form data in it
         $document = Document::findOrFail($id);
         $document->block = $request->block;
         $document->section = $request->section;
         $document->cabinet_side = $request->cabinet_side;
         $document->row = $row;
         $document->cabinet_column = $column;
         $document->cabinet_row = $request->cabinet_row;
         $document->edition = $request->edition;
         $document->stock_updated_by = Auth::user()->id;
         $document->stock_updated_date = Verta::now();
         $document->status = 3;
         $document->label = $label;

         $document->save();
         createLog('documents',$id,'تصحیح جابجایی سند');

         if($print_check =='on'){
         createLog('documents',$id,'چاپ فهرست و لیبل');
         return view('print_label')->with(['label'=>$label,'id'=>$id]);
         }
         else{
           return redirect()->route('completed_documents')->with('success','سند موفقانه جابجا گردید!.');
         }

     }


    /**
     * browse all the images of completed document
     * @return \Illuminate\Http\Response
     */
     public function browseImages($id){

        $document = Document::findOrFail($id);
        return view('browse_images')->with(['document'=>$document]);
     }

    /**
     * delete an image from document
     * @param  App\Upload  $id
     * @return \Illuminate\Http\Response
     */
     public function deleteDocumentImage($id)
     {
       $upload = Upload::find($id);
       // unlink($upload->file_path);
       File::delete($upload->file_path);
       $upload->delete();

       createLog('uploads',$id,'حذف فایل سند');

       Session::flash('success','فایل مؤفقانه حذف گردید!!!');
       return redirect()->back();

     }

     /**
     * Save status of rejecting document.
     *
     * @return \Illuminate\Http\Response
     */
    public function rejectDocument($id, Request $request){
        // Validate Request (Remarks)

        $this->validate($request,[
            'remarks'=>'required|string'
        ]);

        // Retreive document model object and update two columns (status,remarks)
        $document = Document::findOrFail($id);
        $document->status = 2;
        $document->remarks = $request->remarks;
        $document->approve_reject_auth = Auth::user()->id;
        $document->rejected_at = Verta::now();
        $document->save();

        createLog('documents',$id,'رد سند');

        $user = User::find($document->created_by);
        // generate document rejected notification
        $user->notify(new DocumentRejected($document->id,$document->remarks, auth()->user()->id, 'document', 'danger'));

        Session::flash('success','Status Changed Successfully.');
        return Redirect()->route('documents_approval');
    }


    /**
     * Save status of approving document.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveDocument($id, Request $request){
        // Retreive document model object and update one columns (status)

        $document = Document::findOrFail($id);
        $document->status = 1;
        $document->approve_reject_auth = Auth::user()->id;
        $document->approved_at = Verta::now();
        $document->save();

        createLog('documents',$id,'تایید سند');

        Session::flash('success','Status Changed Successfully.');
        return Redirect()->route('documents_approval');
    }

    public function requestedDocuments(){
        return view('requested_documents');
    }
    public function getRequestedDocumentsDatatable() {
        $enquiries = Enquiry::with('documents')->where('returned','0')->orderBy('id','desc')->get();
        $documents = $enquiries[0]->documents;

        $i=0;
        return Datatables::of($documents)
        ->editColumn('id',function($row) use(&$i) {
        return ++$i;
        })->make();

    }

    // public function showStockedEditStatus(){
    //   return view('show_stocked_edit_status');
    // }

    // public function getStockedEditStatus(){
    //   //  get completed documents request for edit stock status
    //   $documents = Document::with('category')->with('department')->with('document_language')->select('documents.*')->where('status',3)->where('stocked_by',Auth::user()->id)->orderBy('id','desc')->get();

    //    return Datatables::of($documents)
    //    ->addColumn('stock_edit_request',function($row){
    //      if($row['stock_edit_request_date'] !=null AND $row['stock_edit_request_approve']==0){
    //        return "<i class='icon-check' style='font-size:1.3em !important; color: #1fb89e !important;'></i>";
    //      }
    //    })
    //    ->addColumn('stock_edit_request_status',function($row){
    //      if($row['stock_edit_request_date'] !=null AND $row['stock_edit_request_approve']==1){
    //        return "<i class='icon-check' style='font-size:1.3em !important; color: #1fb89e !important;'></i>";
    //      }

    //    })
    //    ->addColumn('files',function($row) {

    //       //  detailed information about document
    //       $res =  '<a href="'.route('browse_images',$row['id']).'" target="_blank" class="btn" style="padding:0;"><i style="font-size:1.3em !important;" class="icon-paper-clip"></i></a>';

    //       return $res;
    //    })
    //    ->rawColumns(['files','stock_edit_request_status','stock_edit_request'])
    //    ->make();

    // }


    // print lable
    public function printLabel($id){

      $status=1;
      // $label = Document::find($id)->pluck('label')->first();
      $label = Document::find($id);

        return view('print_label')->with(['label'=>$label,'status'=>$status]);
    }

}
