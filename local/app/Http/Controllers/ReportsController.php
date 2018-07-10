<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Document;
use App\Enquiry;
use App\Log;
use App\User;
use Yajra\Datatables\Datatables;
use Excel;
use Verta;

class ReportsController extends Controller
{

    // get date filed name according to input from db
    public function getDocumentsDataField($status){
      $data = array();
      switch ($status) {
        case '0':
          $data['date_field'] = 'created_at';
          $data['alert'] = 'ایجاد شده';
          break;

        case '1':
          $data['date_field'] = 'approved_at';
          $data['alert'] = 'تایید شده';
          break;

        case '2':
          $data['date_field'] = 'rejected_at';
          $data['alert'] = 'رد شده';
          break;

        case '3':
          $data['date_field'] = 'stocked_date';
          $data['alert'] = 'جابجا شده';
          break;
      }
      return $data;
    }

    // return documents report view
    public function documentsReportView() {
      $documents = new \Illuminate\Support\Collection;
      return view('reports.documents_reports')->with('documents',$documents);
    }

    // generate documents report based on inputs
    public function getDocumentsReports(Request $request) {
      $alert= '';
      if($request->single_date != null) {
          if($request->document_status!=''){
            $data =$this->getDocumentsDataField($request->document_status);
            $documents = Document::with('category')->with('department')->with('document_language')->whereBetween($data['date_field'],[$request->single_date.' 00:00:00',$request->single_date.' 23:59:59'])->get();

            $alert = 'نمایش اسناد '.$data['alert'].' به تاریخ "'.afghaniDateFormat($request->single_date).'"';

          }
          else{
            $documents = Document::with('category')->with('department')->with('document_language')->whereBetween('created_at',[$request->single_date.' 00:00:00',$request->single_date.' 23:59:59'])->get();
            $alert = 'نمایش اسناد به تاریخ "'.afghaniDateFormat($request->single_date).'"';
          }
      }
      else {
        if($request->document_status!=''){
          $data =$this->getDocumentsDataField($request->document_status);
          $documents = Document::with('category')->with('department')->with('document_language')->whereBetween($data['date_field'],[$request->from_date.' 00:00:00',$request->to_date.' 23:59:59'])->get();
          $alert = 'نمایش اسناد '.$data['alert'].' از تاریخ "'.afghaniDateFormat($request->from_date).'" الی "'.afghaniDateFormat($request->to_date).'"';
        }
        else{
          $documents = Document::with('category')->with('department')->with('document_language')->whereBetween('created_at',[$request->from_date.' 00:00:00',$request->to_date.' 23:59:59'])->get();
          $alert = 'نمایش اسناد از تاریخ "'.afghaniDateFormat($request->from_date).'" الی "'.afghaniDateFormat($request->to_date).'"';
        }

      }
      $documents->put('alert', $alert);
      return view('reports.documents_report_table_data')->with(['documents'=>$documents]);
    }


    //documents export report to pdf and excel
    public function exportReport(Request $request) {
    $data =json_decode($request->data,true);

      if($request->type == 'pdf') {
        $snappy = \PDF::loadView('reports.pdf_report',['documents'=>$data]);
        return $snappy->download('pdf_report.pdf');
      }
      else if($request->type == 'excel') {
        Excel::create('New file', function($excel) use ($data) {
          $excel->sheet('New sheet', function($sheet) use ($data){
            $sheet->setRightToLeft(true);
            return $sheet->loadView('reports.excel_report', ['documents'=>$data]);
          });
        })->download('xlsx');
        // return view('reports.excel_report')->with('documents',$data);
      }
    }

    // get enquiries date filed name according to input from db
    public function getEnquiriesDataField($status){
      $data = array();
      switch ($status) {
        case '0':
          $data['date_field'] = 'request_date';
          $data['alert'] = 'درج شده';
          break;

        case '1':
          $data['date_field'] = 'expected_return_date';
          $data['alert'] = 'برگشت متوقعه';
          break;

        case '2':
          $data['date_field'] = 'return_date';
          $data['alert'] = 'بازگشت';
          break;

      }
      return $data;
    }

    //return enquries report view

    public function enquiriesReportView()
    {
      return view('reports.enquiries_reports');
    }


    public function getEnquiriesReports(Request $request) {
      $alert= '';
      $enquiries = '';
      if($request->single_date != '') {
        if($request->enquiries_status!=''){
          $data =$this->getEnquiriesDataField($request->enquiries_status);
          $enquiries = Enquiry::with('department')->where($data['date_field'],$request->single_date)->get();

          $alert = 'نمایش درخواستی های  '.$data['alert'].' به تاریخ "'.afghaniDateFormat($request->single_date).'"';

        }
        else{
          $enquiries = Enquiry::with('department')->where('request_date',$request->single_date)->get();
          $alert = 'نمایش اسناد به تاریخ "'.afghaniDateFormat($request->single_date).'"';
        }

      }
      else {
        if($request->enquiries_status!=''){

          $data =$this->getEnquiriesDataField($request->enquiries_status);

          $enquiries = Enquiry::with('department')->whereBetween($data['date_field'],[$request->from_date,$request->to_date])->get();
          $alert = 'نمایش درخواستی های '.$data['alert'].' از تاریخ "'.afghaniDateFormat($request->from_date).'" الی "'.afghaniDateFormat($request->to_date).'"';
        }
        else{
          $enquiries = Enquiry::with('department')->whereBetween('request_date',[$request->from_date,$request->to_date])->get();
          // $enquiries = Enquiry::with('department')->whereBetween('request_date',['1397-02-01','1397-02-01'])->get();
          $alert = 'نمایش درخواستی ها از تاریخ "'.afghaniDateFormat($request->from_date).'" الی "'.afghaniDateFormat($request->to_date).'"';
        }

      }

      if($request->enquiries_type!='') {
        if($request->single_date != '') {
          $data =$this->getEnquiriesDataField($request->enquiries_status);
          $enquiries = Enquiry::with('department')->where('original',$request->enquiries_type)->where('request_date',$request->single_date)->get();
        }
        else {
          $data =$this->getEnquiriesDataField($request->enquiries_status);
          $enquiries = Enquiry::where('original',$request->enquiries_type)->whereBetween('request_date',[$request->from_date,$request->to_date])->get();
        }
      }


      $enquiries->put('alert', $alert);

      return view('reports.enquiries_report_table_data')->with(['enquiries'=>$enquiries]);
    }


    public function viewLogs(){
      $users = User::all();
      return view('view_logs')->with('users',$users);
    }

    public function getLogs(Request $request){
      if($request->single_date!='') {
        if($request->user!=null) {
          $logs = Log::where('date',$request->single_date)->where('user_id',$request->user)->get();
        }else {
          $logs = Log::where('date',$request->single_date)->get();
        }
      }
      else {
        if($request->user!=null) {
          $logs = Log::whereBetween('date',[$request->from_date,$request->to_date])->where('user_id',$request->user)->get();
        }
        else {
          $logs = Log::whereBetween('date',[$request->from_date,$request->to_date])->get();
        }

      }

      return view('logs_return_data')->with(['logs'=>$logs]);
    }
}
