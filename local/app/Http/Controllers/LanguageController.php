<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DocumentLanguage;
use Yajra\Datatables\Datatables;
use validate;
use Session;

class LanguageController extends Controller
{

  /**
   * Display a listing of doucment language.
   *
   * @return \Illuminate\Http\Response
   */

   public function documentLanguage(){

     return view('document_language');
   }
   /**
    * Display a listing at DataTable.
    *
    * @return \Illuminate\Http\Response
    */

   public function getDocumentLanguage(){

     $language = DocumentLanguage::select(['id', 'language_name'])->orderBy('id','desc');
     return Datatables::of($language)
     ->addColumn('action',function($row) {
       //to update language records
         return '<a class=" dark" onclick="openmodel('.$row['id'].')"> <i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
     })
     ->make();
   }

   /**
    * Display Insert Form of Language.
    *
    * @return \Illuminate\Http\Response
    */

   public function loadLanguageForm(){

     return view('add_language');
   }

   public function insert(Request $request){

     $this->validate($request,[

       'language_name'=> 'string|required|unique:document_language,language_name'
     ]);

     $language=new DocumentLanguage();

     $language->language_name=$request->language_name;

     $language->save();
     createLog('languages',$language->id,'ایجاد لسان جدید');
     // flash alert i.e. print success message
     Session::flash('success',"$language->language_name موفقانه اضافه گردید");

     return redirect()->route('show_language_form');

   }

   public function selectLanguage($id){

     $language=DocumentLanguage::findOrFail($id);
     return $language;
   }

   public function updateLanguage(Request $request,$id){

     $this->validate($request,[

       'language_name'=> 'string|required|unique:document_language,language_name'
     ]);
     $language=DocumentLanguage::findOrFail($id);

     $language->language_name=$request->language_name;

     $language->save();
     createLog('languages',$id,'تصحیح لسان');
     // flash alert i.e. print success message
     Session::flash('success',"تغییرات مؤفقانه اجراء گردید");

     return redirect()->route('document_language');


   }


}
