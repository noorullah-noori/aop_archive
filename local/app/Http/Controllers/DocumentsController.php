<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Search;
use Session;
use File;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;

class DocumentsController extends Controller
{ /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document = Document::orderBy('id','desc')->get();
        return view('admin.documents')->with('documents',$document);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_document');
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
          $pdf = 'pdf_'.$lang;
          $documents = 'documents_'.$lang;

          // validation
          $this->validate($request,[
           $title=>'required|max:255|unique:documents',
           $date=>'required',
           $pdf =>'required|mimes:pdf,xlsx,doc,docx',
          ]);

         //data storage
         $document = new Document();
         $document->$title = $request->$title;
         $document->$date = $request->$date;

         //save the record to retreive id later
         $document->save();

          $log = new Log();

          $log->table_name = 'documents';
          $log->table_item_id = $document->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

         //retreive id from previously stored record
          $id = $document->id;

          //retreive document graphic object again
          $document = Document::findOrFail($id);


          //make image path
          $path = 'uploads/'.$documents.'/';
          

          if($request->$pdf!='') {
              //pdf name
              $pdf_name = $id.'.'.$request->$pdf->getClientOriginalExtension();


              //store pdf in storage
              $request->$pdf->move($path,$pdf_name);

              //db pdf storage
              $document->$pdf = $pdf_name;
           }
            else {
            //if pdf not present for search table
            $pdf_thumb_name = 'default.pdf';

            //if no pdf received store the default
            $document->$pdf = 'default.pdf';
          }

          if($document->save()) {
              //search stuff
              $search = new Search();
              $search->$title = $request->$title;
              $search->$date = $request->$date;
              
              $search->table_name = 'documents';
              $search->table_id = $id;
              $search->image_thumb = $path.$pdf_name;
              $search->save();
            }

            Session::put('lang','');
            // Log::info($id." Document record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
            return Redirect()->route('documents.index');
       
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
        $document = Document::findOrFail($id);
        return view('admin.edit_document')->with('document',$document);
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
          $pdf = 'pdf_'.$lang;
          $documents = 'documents_'.$lang;
          // validation
          $this->validate($request,[
            $title=>'required',
          ]);
          
          // info graphics data storage
           $document = Document::findOrFail($id);
           $search_obj = Search::where('table_name','=','documents')->where('table_id','=',$id)->first();
           $document->$title = $request->$title;
           if($request->$date!='') {
             $document->$date = $request->$date;
           }

           if($request->$pdf!=null) {
                // validation
              $this->validate($request,[
               $pdf =>'mimes:pdf,xlsx,doc,docx',
              ]);
             //remove existing pdf
             File::delete($search_obj->image_thumb);

             //set new pdf name
             $pdf_name = $id.'.'.$request->$pdf->getClientOriginalExtension();

             //construct pdf path
             $pdf_path = 'uploads/'.$documents.'/';

             //move i.e.(to storage) pdf
             $request->$pdf->move($pdf_path,$pdf_name);

             //store in db
             $document->$pdf = $pdf_name;
           }

           if($document->save()) {
               $search_obj->$title = $request->$title;
               $search_obj->$date = $request->$date;
               $search_obj->save();
             }
 
              $log = new Log();

              $log->table_name = 'documents';
              $log->table_item_id = $id;
              $log->activity = 'update';
              $log->user_id = Auth::user()->id;
              $log->save();

             Session::put('lang','');
             // Log::info($id." $document->type updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
             return Redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $document = document::findOrFail($id);
        $search = Search::where('table_name','documents')->where('table_id',$id);
        $search->delete();
        $document->delete();

        $log = new Log();

        $log->table_name = 'documents';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();
        
        // Log::info($id." Document deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return redirect()->route('documents.index');
    }
}
