<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;

Route::get('date_changer',function(){
  return view('date_changer');
});

Route::group(['middleware' => ['auth']], function () {
// mark a notification as read
Route::get('mark_as_read/{id?}',function($id) {
  $entry_user = auth()->user();
  $notification = $entry_user->unreadNotifications->where('id',$id);
  $notification->markAsRead();
  return $notification;
});

// get unread notifications count
Route::get('get_unread_notifications_count',function() {
  $user = auth()->user();
  $notifications = $user->unreadNotifications->count();
  return $notifications;
});

// get unread notifications
Route::get('get_unread_notifications',function() {
  Carbon\Carbon::setLocale('fa');
  $entry_user = auth()->user();
  $notifications = $entry_user->unreadNotifications;
  return view('layouts.partials.notification')->with('notifications',$notifications);
});
//print tage

Route::get('label_print/{id}','DocumentController@printLabel')->name('label_print');

// view document details with images
Route::get('browse_images/{id?}','DocumentController@browseImages')->name('browse_images');

Route::get('print_cover/{id}/{reprint?}','DocumentController@printCover')->name('print_cover');

Route::get('print_document/{id}','EnquiryControllerNew@printDocument')->name('print_document');


// entry role routes
Route::group(['middleware' => ['role:entry']], function () {
  // create,edit,update,store document routes
  Route::resource('documents','DocumentController');

  // edit a rejected document
  Route::get('edit_rejected_document/{id?}','DocumentController@editRejectedDocument')->name('edit_rejected_document');

  // delete image from a document
  Route::get('delete_document_image/{id?}','DocumentController@deleteDocumentImage')->name('delete_document_image');


});

// routes common for entry and admin roles
Route::group(['middleware' => ['role:entry']], function () {
  // return saved documents view (entry: registered by the entry user)
  Route::get('saved_documents','DocumentController@savedDocuments')->name('saved_documents');

});

// routes common for entry and approval roles
Route::group(['middleware' => ['role:entry']], function () {

  // get the datatable for saved documents
  Route::get('get_saved_documents_datatable','DocumentController@getSavedDocumentsDatatable')->name('get_saved_documents_datatable');

  // get approved documents (entry: registered by the entry user) and (approval: approved by approval user)
  Route::get('approved_documents','DocumentController@approvedDocuments')->name('approved_documents');

  // returns rejected documents view | (entry: registered by the entry user) and (approval: rejected by approval user)
  Route::get('rejected_documents','DocumentController@rejectedDocuments')->name('rejected_documents');

  // get the datatable for approvable documents
  Route::get('get_approvable_documents_datatable','DocumentController@getApprovableDocumentsDatatable')->name('get_approvable_documents_datatable');

  // get rejected documents datatable, parameter id optional for notification i.e. highlighting the record with passed id
  Route::get('get_rejected_documents_datatable/{id?}','DocumentController@getRejectedDocumentsDatatable')->name('get_rejected_documents_datatable');

  // get approved documents datatable | no operation
  Route::get('get_approved_documents_datatable','DocumentController@getApprovedDocumentsDatatable')->name('get_approved_documents_datatable');

  // get all documents i.e. saved, approved, completed
  Route::get('show_all_documents','DocumentController@allDocuments')->name('all_documents');


});

// approve role routes
Route::group(['middleware' => ['role:approval']], function () {

  // return view to approve or reject a document
  Route::get('documents_approval','DocumentController@documentsApproval')->name('documents_approval');

  // approvable document details
  Route::get('show_approvable_document/{id?}','DocumentController@showApprovableDocuments')->name('show_approvable_document');

  // approve a document
  Route::get('approve_document/{id?}','DocumentController@approveDocument')->name('approve_document');

  // reject a document
  Route::post('reject_document/{id?}','DocumentController@rejectDocument')->name('reject_document');

  // undo approve/reject
  Route::get('undo_approval/{id}','DocumentController@undoApproval')->name('undo_approval');

});

// stock role routes
Route::group(['middleware' => ['role:stock']], function () {

  // return view of stockable documents with functionality to stock
  Route::get('stockable_documents/{status?}','DocumentController@stockableDocuments')->name('stockable_documents');

  // get the datatable for stockable documents
  Route::get('get_stockable_documents_datatable','DocumentController@getStockableDocumentsDatatable')->name('get_stockable_documents_datatable');

  // show the form to stock a single document
  Route::get('show_stockable_document_form/{id?}','DocumentController@showStockableDocumentForm')->name('show_stockable_document_form');

  Route::get('get_folder_count','DocumentController@getFolderCount')->name('get_folder_count');

  Route::get('folder_view','DocumentController@folderView')->name('folder_view');

  Route::post('get_folders','DocumentController@getFolders')->name('get_folders');

  Route::get('get_folder_data/{id?}','DocumentController@getFolderData')->name('get_folder_data');

  Route::get('print_folder/{tag?}','DocumentController@printFolder')->name('print_folder');

  // submit the form to store storage i.e. block, cabinet, ... information
  Route::post('stock_document/{id?}','DocumentController@stockDocument')->name('stock_document');

  // return form to edit stocked document details
  Route::get('edit_stock/{id}','DocumentController@editStock')->name('edit_stock');

  // update stock details
  Route::any('update_stock/{id}','DocumentController@updateStock')->name('update_stock');
});

// routes common for stock and admin roles
Route::group(['middleware' => ['role:stock|admin']], function () {
    // show stocked i.e. completed documents
    Route::get('show_completed_documents','DocumentController@completedDocuments')->name('completed_documents');

    // get stocked documents datatable
    Route::get('get_completed_documents_datatable','DocumentController@getCompletedDocumentsDatatable')->name('get_completed_documents_datatable');

    // submit request for editing stock details
    // Route::post('submit_stock_edit_request/{id}','DocumentController@submitStockEditRequest')->name('submit_stock_edit_request');


    // show enquiry edit status
    // Route::get('show_stocked_edit_status','DocumentController@showStockedEditStatus')->name('show_stocked_edit_status');

    // Route::get('get_stocked_edit_status','DocumentController@getStockedEditStatus')->name('get_stocked_edit_status');

    //notice routes
    Route::resource('notice','NoticeController');
    Route::get('get_notice','NoticeController@getNoticeDatatable')->name('get_notice');
    Route::get('update_status/{id}/{status?}','NoticeController@updateStatus')->name('update_status');

    //Routes for logs view
    Route::get('view_logs','ReportsController@viewLogs')->name('view_logs');
    Route::post('get_logs','ReportsController@getLogs')->name('get_logs');

    // update user status
    Route::get('update_user_status/{id}/{status?}','UserController@updateUserStatus')->name('update_user_status');


  });

// enquiry role routes
Route::group(['middleware' => ['role:enquiry']], function() {
  // create,edit,update,store approval routes
  Route::resource('enquiries','EnquiryControllerNew');

  // fetch the document from controller after pressing + button for enquiry checkout
  Route::get('get_document_for_enquiry_checkout/{id?}','EnquiryControllerNew@getDocumentForEnquiryCheckout')->name('get_document_for_enquiry_checkout');

  // submit selected documents for enquiry registration
  Route::get('submit_documents_for_enquiry_checkout/{data?}','EnquiryControllerNew@submitDocumentForEnquiryCheckout')->name('submit_documents_for_enquiry_checkout');

  // get the datatable for enquirable documents
  Route::get('get_enquirable_documents_datatable/{id?}','EnquiryControllerNew@getEnquirableDocumentsDatatable')->name('get_enquirable_documents_datatable');

  // return the view to display all i.e. not returned enquiries
  Route::get('show_enquiries','EnquiryControllerNew@showEnquiries')->name('show_enquiries');

  // return the view to display all enquiries for editing.
  Route::get('edit_enquiries','EnquiryControllerNew@editEnquiries')->name('edit_enquiries');

  // get the datatable for all non returned enquiries to be edited.
  Route::get('edit_enquiries_datatable','EnquiryControllerNew@editEnquiriesDatatable')->name('edit_enquiries_datatable');

  // get the datatable for enquiries of non returned documents
  Route::get('get_enquiries_datatable','EnquiryControllerNew@getEnquiriesDatatable')->name('get_enquiries_datatable');

  //?
  // Route::get('show_enquiry_documents/{id?}','EnquiryController@showEnquiryDocuments')->name('show_enquiry_documents');

  // get the image for current enquiry maktoob
  Route::get('show_enquiry_document/{id?}','EnquiryControllerNew@showEnquiryDocument')->name('show_enquiry_document');

  // ?
  // Route::get('issue_enquiry/','EnquiryControllerNew@issueEnquiry')->name('issue_enquiry');

  //return the view for enquired document(s) to be returned
  Route::get('resubmit_documents/{id?}','EnquiryControllerNew@resubmitDocuments')->name('resubmit_documents');

  // return the enquired document(s)
  Route::post('return_documents/{id?}','EnquiryControllerNew@returnDocuments')->name('return_documents');

  // edit the current enquiry information
  Route::get('edit_enquiry/{id?}','EnquiryControllerNew@edit')->name('edit_enquiry');

  // remove a checked out document from current enquiry
  Route::get('remove_enquiry_document/{enquriy_id}/{document_id}','EnquiryControllerNew@removeEnquiryDocument')->name('remove_enquiry_document');

  // attach a new document to current enquiry
  Route::get('attach_document_to_enquiry/{enquriy_id}/{document_id}','EnquiryControllerNew@attachDocumentToEnquiry')->name('attach_document_to_enquiry');


});

Route::group(['middleware' => ['role:enquiry|admin']], function() {
  // return the view to display both returned and unreturned requests
  Route::get('show_all_enquiries','EnquiryControllerNew@showAllEnquiries')->name('show_all_enquiries');

  // get the datatable for all enquiries
  Route::get('get_all_enquiries','EnquiryControllerNew@getAllEnquiriesDatatable')->name('get_all_enquiries_datatable');
});


// admin role routes

Route::get('documents_reports', 'ReportsController@documentsReportView')->name('documents_reports');

Route::post('get_documents_reports', 'ReportsController@getDocumentsReports')->name('get_documents_reports');

Route::any('export_report', 'ReportsController@exportReport')->name('export_report');

// enquiries reports routes
Route::get('enquiries_reports','ReportsController@enquiriesReportView')->name('enquiries_reports');

Route::post('get_enquiries_reports','ReportsController@getEnquiriesReports')->name('get_enquiries_reports');

// resourcefull routes
Route::resource('departments','DepartmentController');

Route::resource('categories','CategoryController');


Route::get('/', 'HomeController@index')->name('dashboard');

Route::get('home', 'HomeController@index')->name('home');

//documeats language routes

Route::get('document_language','LanguageController@documentLanguage')->name('document_language');

Route::get('get_document_language','LanguageController@getDocumentLanguage')->name('get_document_language');

Route::get('show_language_form','LanguageController@loadLanguageForm')->name('show_language_form');

Route::post('insert_language','LanguageController@insert')->name('insert_language');
//select row for update language
Route::get('select_language/{id}','LanguageController@selectLanguage')->name('select_language');
//update language_name
Route::any('update_language/{id?}','LanguageController@updateLanguage')->name('update_language');




// // Show all requests for editing stock details from stock user to admin
// Route::get('stock_edit_requests','DocumentController@stockEditRequests')->name('stock_edit_requests');


  // Show all requests for editing stock details from stock user to admin
  Route::get('show_stock_edit_request/{id}','DocumentController@showStockEditRequest')->name('show_stock_edit_request');

  // Show all requests for editing stock details from stock user to admin
  Route::get('approve_request/{id}','DocumentController@approveRequest')->name('approve_request');

  // Show all requests for editing stock details from stock user to admin
  Route::post('reject_request/{id}','DocumentController@rejectRequest')->name('reject_request');


// // get datatable for all requests for stock editing
// Route::get('get_edit_requests_datatable','DocumentController@getEditRequestsDatatable')->name('get_edit_requests_datatable');

// Route::resource('documents','DocumentController');

// departments routes
Route::get('get_department_datatable','DepartmentController@getDepartmentDatatable')->name('get_department_datatable');

// categories routes
Route::get('get_categories_datatable','CategoryController@getCategoryDatatable')->name('get_categories_datatable');

// documents routes
Route::get('get_documents_datatable','DocumentController@getDocumentDatatable')->name('get_documents_datatable');


});


Route::get('edit_user_role/{id?}', 'UserController@editUserRole')->name('users.edit_role');
Route::put('update_user_role/{id?}', 'UserController@updateUserRole')->name('users.update_role');

Route::resource('roles', 'RoleController');

Route::resource('permissions', 'PermissionController');

// Route::resource('posts', 'PostController');

Route::get('401',function() {
return view('errors.401');
})->name('401');

// Route::get('test',function(){
//     return view('test');
// });

Auth::routes();

//documents reports routes

Route::group(['middleware' => ['role:entry|approval|stock|enquiry|admin']], function () {
  Route::resource('users', 'UserController');
});

Route::get('all_notifications',function() {
  \Carbon\Carbon::setLocale('fa');
  $read = auth()->user()->readNotifications;
  $unread = auth()->user()->unreadNotifications;
  return view('all_notifications')->with(['read'=>$read,'unread'=>$unread]);
})->name('all_notifications');
