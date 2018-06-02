<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MediaRegisteration;
use App\JournalistRegisteration;
use App\ExpertRegisteration;
use App\MediaStaff;
use Session;
use Config;
// use Log;
use DB;
use Mail;
use Auth;
use Carbon\Carbon;
use App\Log;

class MediaRegisterationController extends Controller {


  public function store_media_form(Request $request) {

      $this->validate($request,[
        'name'=>'required',
        'license_number'=>'required',
        'license_issue_date'=>'required',
        'office_starting_date'=>'required',
        'type'=>'required',
        'coverage_area'=>'required',
        'type_of_broadcasting'=>'required',
        'audience_group'=>'required',
        'language_of_broadcasting'=>'required',
        'official_address'=>'required',
        'email1'=>'required',
        'phone1'=>'required',
        'website'=>'required',
        'facebook'=>'required',
        'twitter'=>'required',
        'd_name'=>'required',
        'd_email'=>'required',
        'd_phone'=>'required',
        'd_facebook'=>'required',
        'd_twitter'=>'required',
      ]);
      $media = new MediaRegisteration();
      $media->name = $request->input('name');
      $media->license_number = $request->input('license_number');
      $media->license_date  = $request->input('license_issue_date');
      $media->starting_date = $request->input('office_starting_date');
      $media->type = $request->input('type');
      $media->coverage_area = $request->input('coverage_area');
      $media->coverage_type = $request->input('type_of_broadcasting');
      $media->recipent_group = $request->input('audience_group');
      $media->broadcasting_language = $request->input('language_of_broadcasting');
      $media->address = $request->input('official_address');
      $media->email1 = $request->input('email1');
      $media->email2 = $request->input('email2');
      $media->email3 = $request->input('email3');
      $media->phone1 = $request->input('phone1');
      $media->phone2 = $request->input('phone2');
      $media->phone3 = $request->input('phone3');
      $media->website = $request->input('website');
      $media->facebook = $request->input('facebook');
      $media->twitter = $request->input('twitter');

      //storing the manager of the media
      $director = new MediaStaff();
      $director->name = $request->input('d_name');
      $director->email = $request->input('d_email');
      $director->telephone = $request->input('d_phone');
      $director->facebook = $request->input('d_facebook');
      $director->twitter = $request->input('d_twitter');
      $director->type = 'manager';



      $reporter = new MediaStaff();
      $secretary = new MediaStaff();
      $journalist1 = new MediaStaff();
      $journalist2 = new MediaStaff();

      if($director->save()) {
        $director_id = $director->id;
        //for storing the fields present in non english forms
        $lang = Config::get('app.locale');
        if($lang!='en') {
          //storing reporter of the media
          $reporter->name = $request->input('r_name');
          $reporter->email = $request->input('r_email');
          $reporter->telephone = $request->input('r_phone');
          $reporter->facebook = $request->input('r_facebook');
          $reporter->twitter = $request->input('r_twitter');
          $reporter->type = 'reporter';

          if($reporter->save()){
            $reporter_id = $reporter->id;
            //storing the secretary information
            $secretary->name = $request->input('s_name');
            $secretary->email = $request->input('s_email');
            $secretary->telephone = $request->input('s_phone');
            $secretary->facebook = $request->input('s_facebook');
            $secretary->twitter = $request->input('s_twitter');
            $secretary->type = 'secretary';
            if($secretary->save()){
              $secretate_id = $secretary->id;
            }
          }
        }
        //stroring journalist 1 information
        $journalist1->name = $request->input('j_name');
        $journalist1->email = $request->input('j_email');
        $journalist1->telephone = $request->input('j_phone');
        $journalist1->facebook = $request->input('j_facebook');
        $journalist1->twitter = $request->input('j_twitter');
        $journalist1->type = 'journalist';

        if($journalist1->save()){

            $journalist1_id = $journalist1->id;
            //stroring journalist 2 information
            $journalist2->name = $request->input('j1_name');
            $journalist2->email = $request->input('j1_email');
            $journalist2->telephone = $request->input('j1_phone');
            $journalist2->facebook = $request->input('j1_facebook');
            $journalist2->twitter = $request->input('j1_twitter');
            $journalist2->type = 'journalist';

            if($journalist2->save()){
              $journalist2_id = $journalist2->id;
              if($lang=='en') {
                $media->media_manager = $director_id;
                $media->journalist1 = $journalist1_id;
                $media->journalist2 = $journalist2_id;
              }
              else {
                $media->reporter = $reporter_id;
                $media->secretary = $secretate_id;
                $media->media_manager = $director_id;
                $media->journalist1 = $journalist1_id;
                $media->journalist2 = $journalist2_id;
              }
            }
          }
        }

        if($media->save()) {

          // Log::info($media->id." Media record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
          $request->session()->flash('success', 'Form Submitted Successfully!');
      }
        else {
          $request->session()->flash('failure', 'Form Submission Problem!');
        }

          $log = new Log();

          $log->table_name = 'media_registeration';
          $log->table_item_id = $media->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

        return Redirect()->route('media_form');
      }

  public function store_journalist_form(Request $request) {

      $this->validate($request,[
        'name'=>'required',
        'last_name'=>'required',
        'father_name'=>'required',
        'nationality'=>'required',
        'passport'=>'required',
        'email1'=>'required',
        'phone1'=>'required',
        'discipline'=>'required',
        'facebook'=>'required',
        'twitter'=>'required',
        'linked_in'=>'required',
        'type'=>'required',
        'language'=>'required',
        'starting_date'=>'required',
        'current_media'=>'required',
        'previous_media'=>'required',
        'address'=>'required',
        'o_email1'=>'required',
        'o_phone1'=>'required',
        'o_website'=>'required',
        'o_facebook'=>'required',
        'o_twitter'=>'required',
      ]);
      $journalist = new JournalistRegisteration();
      $journalist->name = $request->input('name');
      $journalist->last_name = $request->input('last_name');
      $journalist->father_name = $request->input('father_name');
      $journalist->nationality = $request->input('nationality');
      $journalist->passport = $request->input('passport');
      $journalist->email1 = $request->input('email1');
      $journalist->email2 = $request->input('email2');
      $journalist->email3 = $request->input('email3');
      $journalist->phone1 = $request->input('phone1');
      $journalist->phone2 = $request->input('phone2');
      $journalist->phone3 = $request->input('phone3');
      $journalist->discipline = $request->input('discipline');
      $journalist->facebook = $request->input('facebook');
      $journalist->twitter = $request->input('twitter');
      $journalist->linked_in = $request->input('linked_in');
      $journalist->type = $request->input('type');
      $journalist->type_text = $request->input('type_text');
      $journalist->language = $request->input('language');
      $journalist->starting_date = $request->input('starting_date');
      $journalist->current_media = $request->input('current_media');
      $journalist->previous_media = $request->input('previous_media');
      $journalist->address = $request->input('address');
      $journalist->o_email1 = $request->input('o_email1');
      $journalist->o_email2 = $request->input('o_email2');
      $journalist->o_email3 = $request->input('o_email3');
      $journalist->o_phone1 = $request->input('o_phone1');
      $journalist->o_phone2 = $request->input('o_phone2');
      $journalist->o_phone3 = $request->input('o_phone3');
      $journalist->o_website = $request->input('o_website');
      $journalist->o_facebook = $request->input('o_facebook');
      $journalist->o_twitter = $request->input('o_twitter');

    if($journalist->save()) {

      $request->session()->flash('success', 'Form Submitted Successfully!');
    }
    else {
      $request->session()->flash('failure', 'Form Submission Problem!');
    }
    
    $log = new Log();

    $log->table_name = 'journalist_registeration';
    $log->table_item_id = $journalist->id;
    $log->activity = 'create';
    $log->user_id = Auth::user()->id;
    $log->save();

    // Log::info($journalist->id." Journalist record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
    return Redirect()->route('journalist_form');
  }

  public function store_expert_form(Request $request) {
      $this->validate($request,[
        'name'=>'required',
        'last_name'=>'required',
        'father_name'=>'required',
        'nationality'=>'required',
        'passport'=>'required',
        'email1'=>'required',
        'phone1'=>'required',
        'descipline'=>'required',
        'facebook'=>'required',
        'twitter'=>'required',
        'linked_in'=>'required',
        'type'=>'required',
        'language'=>'required',
        'starting_date'=>'required',
        'specialization'=>'required',
      ]);
      $expert = new ExpertRegisteration();
      $expert->name = $request->input('name');
      $expert->last_name = $request->input('last_name');
      $expert->father_name = $request->input('father_name');
      $expert->nationality = $request->input('nationality');
      $expert->passport = $request->input('passport');
      $expert->email1 = $request->input('email1');
      $expert->email2 = $request->input('email2');
      $expert->email3 = $request->input('email3');
      $expert->phone1 = $request->input('phone1');
      $expert->phone2 = $request->input('phone2');
      $expert->phone3 = $request->input('phone3');
      $expert->discipline = $request->input('descipline');
      $expert->facebook = $request->input('facebook');
      $expert->twitter = $request->input('twitter');
      $expert->linked_in = $request->input('linked_in');
      $expert->type = $request->input('type');
      $expert->type_text = $request->input('type_text');
      $expert->language = $request->input('language');
      $expert->starting_date = $request->input('starting_date');
      $expert->specialization = $request->input('specialization');
      
    if($expert->save()) {

      $request->session()->flash('success', 'Form Submitted Successfully!');
    }
    else {
      $request->session()->flash('failure', 'Form Submission Problem!');
    }
    
    $log = new Log();

    $log->table_name = 'expert_registeration';
    $log->table_item_id = $expert->id;
    $log->activity = 'create';
    $log->user_id = Auth::user()->id;
    $log->save();

    // Log::info($expert->id." Expert record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
    return Redirect()->route('expert_form');
  }

  public function view() {
    $complaints = Complaints::all();
    return view('admin.complaints')->with('complaints',$complaints);
  }
  public function destroy($id) {
    $complaint = Complaints::findOrFail($id);
    $complaint->delete();

    $log = new Log();

    $log->table_name = 'complaint';
    $log->table_item_id = $id;
    $log->activity = 'delete';
    $log->user_id = Auth::user()->id;
    $log->save();

    return Redirect()->route('view_complaints');
  }

  public function view_media(){
    $media = MediaRegisteration::orderBy('status','desc')->get();
    return view('admin.view_media_register')->with('media',$media);
  }
  public function view_journalist(){
    $journalist = JournalistRegisteration::orderBy('status','desc')->get();
    return view('admin.view_journalist_register')->with('journalist',$journalist);
  }
  public function view_expert(){
    $expert = ExpertRegisteration::orderBy('status','desc')->get();
    return view('admin.view_expert_register')->with('expert',$expert);
  }

  public function view_media_user($id){
    $user = MediaRegisteration::findOrFail($id);
    $user->status = 'read';
    $user->save();

    $reporter = new MediaStaff();
    $manager = new MediaStaff();
    $journalist1 = new MediaStaff();
    $journalist2 = new MediaStaff();
    $secretary = new MediaStaff();

    if($user->media_manager!=''){
      $manager = DB::table('media_staff')->where('id',$user->media_manager)->first();
    }
    if($user->reporter!=''){
      $reporter = DB::table('media_staff')->where('id',$user->reporter)->first();
    }
    if($user->journalist1){
      $journalist1 = DB::table('media_staff')->where('id',$user->journalist1)->first();
    }
    if($user->journalist2){
      $journalist2 = DB::table('media_staff')->where('id',$user->journalist2)->first();
    }
    if($user->secretary){
      $secretary = DB::table('media_staff')->where('id',$user->secretary)->first();
    }

    return view('admin.view_media_user')->with(['user'=>$user,'reporter'=>$reporter,'journalist1'=>$journalist1,'journalist2'=>$journalist2,'secretary'=>$secretary,'manager'=>$manager]);
  }

   public function view_journalist_user($id){
    $user = JournalistRegisteration::findOrFail($id);
    $user->status = 'read';
    $user->save();
    return view('admin.view_journalist_user')->with('user',$user);
  }

  public function view_expert_user($id){
    $user = ExpertRegisteration::findOrFail($id);
    $user->status = 'read';
    $user->save();
    return view('admin.view_expert_user')->with('user',$user);
  }

  public function delete_media_user($id){
    $user = MediaRegisteration::findOrFail($id);
    
    if($user->reporter!=''){
      $reporter = MediaStaff::findOrFail($user->reporter);
      $reporter->delete();
    }
    if($user->journalist1){
      $journalist1 = MediaStaff::findOrFail($user->journalist1);
      $journalist1->delete();
    }
    if($user->journalist2){
      $journalist2 = MediaStaff::findOrFail($user->journalist2);
      $journalist2->delete();
    }
    if($user->secretary){
      $secretary = MediaStaff::findOrFail($user->secretary);
      $secretary->delete();
    }
    $user->delete();
    $log = new Log();

    $log->table_name = 'media_registeration';
    $log->table_item_id = $id;
    $log->activity = 'delete';
    $log->user_id = Auth::user()->id;
    $log->save();

    return Redirect()->route('view_media_register');    
  }

  public function delete_journalist_user($id){
    $user = JournalistRegisteration::findOrFail($id);
    $user->delete();
    
    $log = new Log();

    $log->table_name = 'journalist_registeration';
    $log->table_item_id = $id;
    $log->activity = 'delete';
    $log->user_id = Auth::user()->id;
    $log->save();

    return Redirect()->route('view_journalist_register');    
  }

  public function delete_expert_user($id){
    $user = ExpertRegisteration::findOrFail($id);
    $user->delete();
    
    $log = new Log();

    $log->table_name = 'expert_registeration';
    $log->table_item_id = $id;
    $log->activity = 'delete';
    $log->user_id = Auth::user()->id;
    $log->save();

    return Redirect()->route('view_expert_register');    
  }
}
