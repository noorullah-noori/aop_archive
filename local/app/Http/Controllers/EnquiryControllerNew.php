<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\Document;
use App\Department;
use App\Enquiry;
use App\Category;
use Image;
use File;
use Illuminate\Support\Collection;
use DB;
use App\Upload;
use App\Log;
use Session;
use Auth;
use Carbon\Carbon;
use Verta;
use App\Notifications\EnquiryDeadlineReaches;

class EnquiryControllerNew extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('document_enquiries');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      // validate enquiry inputs
      $this->validate($request,[
        'document_ids'=>'required',
        'enquiry_number'=>'required|numeric',
        'request_date'=>'required',
        'department_id'=>'required|numeric',
        'approval_authority'=>'required',
        // 'expected_return_date'=>'required',
        'approved_enquiry_file'=>'required|mimes:jpeg,jpg',
      ]);
      if($request->original==1){
        $this->validate($request,[
          'expected_return_date'=>'required'
        ]);
      }
      // create document request object and store relevant data
      $enquiry= new Enquiry();
      $enquiry->enquiry_number = $request->enquiry_number;
      $enquiry->department_id = $request->department_id;
      $enquiry->approval_authority = $request->approval_authority;
      $enquiry->request_date = $request->request_date;
      $request->original==1?$enquiry->expected_return_date = $request->expected_return_date:'';
      $request->information!=''?$enquiry->information = $request->information:'';
      $enquiry->original = $request->original;
      $enquiry->created_by = Auth::user()->id;
      $enquiry->created_at = Verta::now();

      // get the image
      $image = Image::make($request->file('approved_enquiry_file'));
      if($image->width()>2000) {
        // resize the image to a width of 1920 and constrain aspect ratio (auto height)
        $image->resize(1920, null, function ($constraint) {
            $constraint->aspectRatio();
        });
      }

      $enquiry->save();

      createLog('enquiry',$enquiry->id,'درج درخواستی');

      //fetch enquiry document ids to an array (hidden field)
      $enquired_documents = explode(',',$request->document_ids);
      // $enquired_documents = explode(',','1,2');

      // get the currently saved enquiry id in order to make the file path
      $enquiry_id = Enquiry::max('id');
      $current_enquiry = Enquiry::find($enquiry_id);

      // setting the path for image e.g. uploads/enquiries/'document_id'_'request->id'
      $path = 'uploads/enquiries/';
      $full_path = $path.$enquiry_id.'.jpg';

      //store the path in db
      $current_enquiry->file_path = $full_path;


      // create directory based on category if not present
      if(!file_exists($path)) {
        File::makeDirectory($path);
      }

      $image->save($full_path);

      $current_enquiry->documents()->attach($enquired_documents);

      $current_enquiry->save();

      return redirect()->route('show_enquiries');


  }
  /**
   * Remove Document From
   *
   * @param  integer current_enquiry_id
   * @param  integer document_id
   * @return \Illuminate\Http\Response
   */
  public function removeEnquiryDocument($enquiry_id,$document_id)
  {
    $enquiry = Enquiry::find($enquiry_id);
    $enquiry->documents()->detach($document_id);

    createLog('enquiry',$enquiry_id,'حذف سند از درخواستی');

    return redirect()->route('edit_enquiry',$enquiry_id);
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
      $enquiry = Enquiry::find($id);
      // fetch all departments and categories from tables for editing enquiry
      $departments = Department::orderBy('id','desc')->get();
      $category = Category::orderBy('id','desc')->get();

      return view('edit_enquiry')->with(['enquiry'=>$enquiry,'category'=>$category,'departments'=>$departments]);
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
      // validate enquiry inputs
      $this->validate($request,[
        'document_ids'=>'required',
        'enquiry_number'=>'required|numeric',
        'request_date'=>'required',
        'department_id'=>'required|numeric',
        'approval_authority'=>'required',
        // 'expected_return_date'=>'required',
      ]);
      if($request->original==1){
        $this->validate($request,[
          'expected_return_date'=>'required'
        ]);
      }

      $enquiry = Enquiry::find($id);
      $enquiry->enquiry_number = $request->enquiry_number;
      $enquiry->department_id = $request->department_id;
      $enquiry->approval_authority = $request->approval_authority;
      $enquiry->request_date = $request->request_date;
      $request->original==1?$enquiry->expected_return_date = $request->expected_return_date:'';
      $request->information!=''?$enquiry->expected_return_date = $request->expected_return_date:'';
      $enquiry->original = $request->original == 1 ? 1 : 0;
      $enquiry->updated_by = Auth::user()->id;
      $enquiry->updated_at = Verta::now();
      $enquiry->save();

      createLog('enquiry',$id,'تصحیح درخواستی درج شده');

      // if enquiry file selected
      if($request->file('approved_enquiry_file')) {

        // get the image
        $image = Image::make($request->file('approved_enquiry_file'));

        // resize the image to a width of 1920 and constrain aspect ratio (auto height)
        if($image->width()>2000) {
          $image->resize(1920, null, function ($constraint) {
              $constraint->aspectRatio();
          });
        }

        // save the image physically
        $image->save($enquiry->file_path);

      }
      Session::flash('success','درخواستی موفقانه تصحیح گردید');
      return redirect()->route('show_enquiries');
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
   * Get the datatable for enquirable documents i.e. all documents
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function getEnquirableDocumentsDatatable()
  {
        $documents = Document::with('category')->with('department')->with('document_language')->where('status',3)->orderBy('id','desc')->get();

      return Datatables::of($documents)
      ->addColumn('action',function($row) {
          return
          '<a data-toggle="tooltip" title="نمایش فایل ها" href="'.route('browse_images',$row['id']).'" target="_blank" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-paper-clip"></i></a>'.
          "<button data-toggle='tooltip' title='انتخاب' style='background:none;' id='btn_".$row['id']."' onclick=addToEnquiries(".$row['id'].")  class='btn btn-xs'><i style='font-size:1.3em !important;color:#35cb35;' class='icon-plus'></i></button>";
      })
      ->rawColumns(['action'])
      ->toJson();
  }

  /**
   * Issue a new document request
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function issueEnquiry($id)
  {
      $document = Document::find($id);
      $departments = Department::orderBy('id','desc')->get();
      return view('issue_enquiry')->with(['document'=>$document,'departments'=>$departments]);

  }

   /**
   * Get the datatable for enquired documents
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function getEnquiredDatatable()
  {
      $enquiries = Enquiry::with('department')->where('returned',0)->orderBy('id','desc')->get();

      return Datatables::of($enquiries)
      ->addColumn('action',function($row) {
          return '
          <a href="'.route('show_request_documents',$row['id']).'" data-toggle="tooltip" title="نمایش فایل ها" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-eye"></i></a>
          <a href="'.route('return_documents',$row['id']).'" data-toggle="tooltip" title="بازگشت سند" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-logout"></i></a>
          ';
      })
      ->make(true);


      // Work from noori

  }


  /**
   * show Documents of specific request
   *
   * @param  void
   * @return \Illuminate\Http\Response
   */
  public function showEnquiryDocuments($id)
  {
      $documents = \DB::table('document_enquiry')->select('document_id')->where('enquiry_id',$id)->orderBy('id','desc');
      $documents_array = (array)$documents[0];
      $uploads = Upload::wherein('document_id',$documents_array)->get();

      return view('show_enquiry_documents')->with('uploads',$uploads);

  }

  /**
   * function to return document data as json by passing document_id
   *
   * @param  integer
   * @return \Illuminate\Http\Response
   */
  public static function getDocumentForEnquiryCheckout($id)
  {
      $document = Document::with('department')->with('category')->find($id);
      return $document;

  }
  // Working on enquiries

  /**
   * Show unreturned enquiries
   *
   * @return \Illuminate\Http\Response
   */
  public function showEnquiries(){
      return view('enquiries');
  }

  /**
   * Get datatable for enquiries
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function getEnquiriesDatatable()
  {
      $enquiries = Enquiry::where('original',1)->where('returned',0)->orderBy('id','desc')->get();

      return Datatables::of($enquiries)
      ->addColumn('action',function($row) {
          return '
          <a  class="btn btn-xs " data-toggle="tooltip" title="نمایش مکتوب درخواستی"><i style="font-size:1.3em !important;" class="icon-eye" onclick="showModal('.$row['id'].')"></i></a>
          <a href="'.route('resubmit_documents',$row['id']).'"  data-toggle="tooltip" title="بازگشت سند" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-logout"></i></a>
          ';
      })
      ->make(true);

  }


  public function editEnquiries(){
    return view('edit_enquiries');
  }

  public function editEnquiriesDatatable(){
        // get all enquiries
        $enquiries = Enquiry::with('department')->select('id','enquiry_number', 'approval_authority','request_date', 'expected_return_date', 'return_date','department_id', 'original', 'returned')->where('returned',0)->orderBy('id','desc')->get();

        // return datatable
        return Datatables::of($enquiries)
        // identifying whether copy or original
        ->editColumn('original',function($row){
            if($row['original']==0){
              return 'کاپی';
            }
            else if($row['original']==1){
              return 'اصلی';
            }
            else{
              return 'معلومات';
            }
        })
        ->addColumn('action',function($row){
          return '
          <a href="'.route('edit_enquiry',$row['id']).'" data-toggle="tooltip" title="تصحیح درخواستی" class="btn btn-xs"><i style="font-size:1.3em !important;" class="icon-note"></i></a>';
        })
        ->make(true);
  }
  /**
   * function to submit documents ids for enquiry registration
   *
   * @param  integer
   * @return \Illuminate\Http\Response
   */
  public static function submitDocumentForEnquiryCheckout($data)
  {
      // convert comma separated documents into array
      $data = explode(',',$data);

      // collection to store documents for enquiry
      $documents = new Collection();

      // fetch enquired documents from table to collection
      foreach($data as $id) {
        $documents->push(Document::with('category')->with('department')->find($id));
      }

      // fetch all departments from departments table for enquiry department
      $departments = Department::orderBy('id','desc')->get();

      return view('issue_enquiry')->with(['documents'=>$documents,'departments'=>$departments]);

  }
  /*
   * Show Document (maktoob) of request
   *
   * @param  id
   * @return \Illuminate\Http\Response
   */
  public function showEnquiryDocument($id)
  {
      $document = Enquiry::FindOrFail($id);

      return $document;

  }

  /**
   * Show Form for re-submitting documents
   *
   * @param  id
   * @return \Illuminate\Http\Response
   */
  public function resubmitDocuments($id){
      $enquiry = Enquiry::FindOrFail($id);
      return view('resubmit_documents')->with('enquiry',$enquiry);
  }

  /**
   * Resubmit Documents of Request
   *
   * @param  id
   * @return \Illuminate\Http\Response
   */
  public function returnDocuments($id, Request $request){
      $enquiry = Enquiry::FindOrFail($id);
      $enquiry->return_date = $request->return_date;
      $enquiry->remarks = $request->remarks;
      $enquiry->returned = '1';
      $enquiry->received_by = Auth::user()->id;
      $enquiry->received_at = Verta::now();
      $enquiry->save();

      createLog('enquiry',$id,'بازگشت سند');

      return redirect()->route('show_enquiries');
  }


   /**
   * Show all enquiries (returned & not returned)
   *
   * @return \Illuminate\Http\Response
   */
  public function showAllEnquiries(){
      return view('all_enquiries');
  }

  /**
   * Get datatable for all enquiries (returned & unreturned)
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function getAllEnquiriesDatatable()
  {
      // get all enquiries
      $enquiries = Enquiry::with('department')->select('id','enquiry_number', 'approval_authority','request_date', 'expected_return_date', 'return_date','department_id', 'original', 'returned')->orderBy('id','desc')->get();

      // return datatable
      return Datatables::of($enquiries)
      // edit enquiry number field to display number in persian format
      ->editColumn('enquiry_number', function($row) {
        return Verta::persianNumbers($row['enquiry_number']);
      })


      ->editColumn('remaining_days', function($row) {
        if($row['original'] == 1) {
          // if the document not returned
          if($row['returned']!=1){
            // if logged in as enquiry or admin user check if upto or less than 3 days remaining_days
            if(auth()->user()->hasAnyRole(['enquiry','admin']) AND documentDeadlineDaysRemanining($row['expected_return_date'], 3)) {
              // fetch all notifications generated by current user, only data section is of concern i.e. to check if any notification generated for current enquiry id
              $notification = auth()->user()->notifications->pluck('data.enquiry_id')->toArray();

              // check if any notification generated for current enquiry id
              if(!in_array($row['id'],$notification)) {
                auth()->user()->notify(new EnquiryDeadlineReaches($row['id'], 'تاریخ برگشت سند '.afghaniDateFormat($row['expected_return_date']).' میباشد.', 'enquiry',  'danger'));
              }
            }

            $remaining_days = documentDeadlineDaysRemanining($row['expected_return_date'],3,'days');

            if($remaining_days<3) {
              // if upto 3 days remaining for return disply in danger badge
              return "<div style='padding:5px;' class='badge badge-danger'>".Verta::persianNumbers($remaining_days)."</div>";

            }
            else {
              // else dispaly with success badge
              return "<div style='padding:5px;' class='badge badge-success'>".Verta::persianNumbers($remaining_days)."</div>";
            }
          }

          }

      })

      //requesting i.e. enquiry date to persian i.e. afghani months e.g. ۱ حمل ۱۳۹۷
      ->editColumn('request_date', function($row) {

          return afghaniDateFormat($row['request_date']);

      })
      //expected return date i.e. enquiry date to persian i.e. afghani months e.g. ۱ حمل ۱۳۹۷
      ->editColumn('expected_return_date', function($row) {
          if($row['original'] == 1) {
            return afghaniDateFormat($row['expected_return_date']);
          }
      })

      // identifying whether copy or original
      ->editColumn('original',function($row){
          if($row['original']==0){
            return 'کاپی';
          }
          else if($row['original']==1){
            return 'اصلی';
          }
          else{
            return 'معلومات';
          }
      })

      ->addColumn('print_copy',function($row) {
        if($row['returned']=='0'){

            return '<a href="'.route('print_document',$row['id']).'" target="_blank"  data-toggle="tooltip" data-placement="top" title="پرنت سند"> <i style="font-size:1.3em !important;color:green;" class="icon-printer"></i></a>';
        }




      })
      ->addColumn('action',function($row) {

          if($row['returned']=='1'){
              return '<i style="font-size:1.3em !important;color:green;" class="icon-check"></i>';
          }


      })
      ->rawColumns(['remaining_days','action','print_copy'])
      ->make(true);

  }

  /**
   * Edit - Enquiry => attached selected document to enquiry
   *
   * @param  void
   * @return Yajra\Datatables\Datatables;
   */
  public function attachDocumentToEnquiry($enquiry_id, $document_id)
  {
      $enquiry = Enquiry::find($enquiry_id);
      if($enquiry->documents->find($document_id)) {
        return redirect()->back()->with('already_exists','این فایل قبلا انتخاب گردیده است.');
      }
      else {
        $enquiry->documents()->attach($document_id);
        createLog('enquiry',$enquiry_id,'اضافه نمودن سند جدید به درخواستی');
        return redirect()->route('edit_enquiry',$enquiry_id)->with('success','فایل موفقانه انتخاب گردید');
      }

  }

  public function printDocument($id){
    $enquiry = Enquiry::find($id);
    $documents = $enquiry->documents->pluck('id');
    $uploads = Upload::wherein('document_id',$documents)->pluck('file_path');
    return view('print_document')->with('uploads',$uploads);


    // $documents = \DB::table('document_enquiry')->select('document_id')->where('enquiry_id',$id)->get();
    // $documents_array = (array)$documents[0];
    // $uploads = Upload::wherein('document_id',$documents_array)->get();
    // foreach ($uploads as $file) {
    //   print_r($file->file_path);
    //   echo "<br>";


  }


}
