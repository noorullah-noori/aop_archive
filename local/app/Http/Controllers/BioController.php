<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bio;
use Session;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;

class BioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bio = Bio::all();
        return view('admin.bio')->with('bio',$bio);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_bio');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //multi language variable
        $lang = Session::get('lang');
        $bio = 'bio_'.$lang;
        $this->validate($request,[
              $bio=>'required',
            ]);
        $bio_obj = new Bio();
        $bio_obj->$bio = $request->$bio;
        $bio_obj->save();

          $log = new Log();

          $log->table_name = 'biography';
          $log->table_item_id = $bio_obj->id;
          $log->activity = 'create';
          $log->user_id = Auth::user()->id;
          $log->save();

        Session::put('lang','');
        // Log::info($bio_obj->id." Bio created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_bio.index');
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
        $bio = Bio::findOrFail($id);
        return view('admin.edit_bio')->with('bio',$bio);
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
        // multi language variables
        $lang = Session::get('lang');
        $bio = 'bio_'.$lang;

        $bio_obj =Bio::findOrFail($id);
        $bio_obj->$bio = $request->$bio;
        $bio_obj->save();
        
        $log = new Log();

        $log->table_name = 'biography';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

        Session::put('lang','');
        // Log::info($id." Bio updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_bio.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $bio = Bio::findOrFail($id);
        $bio->delete();
        
          $log = new Log();

          $log->table_name = 'biography';
          $log->table_item_id = $id;
          $log->activity = 'delete';
          $log->user_id = Auth::user()->id;
          $log->save();
          
        // Log::info($id." Bio deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_bio.index');
    }
}
