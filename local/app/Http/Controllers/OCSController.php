<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OCS;
use Session;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;

class OCSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ocs = OCS::all();
        return view('admin.ocs')->with('ocs',$ocs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_ocs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lang = Session::get('lang');
        $description = 'description_'.$lang;
        
        $this->validate($request,[
              $description=>'required|'
        ]);

        $ocs = new OCS();
        $ocs->$description = $request->input($description);
        $ocs->save();

        $log = new Log();

        $log->table_name = 'ocs';
        $log->table_item_id = $ocs->id;
        $log->activity = 'create';
        $log->user_id = Auth::user()->id;
        $log->save();

        Session::put('lang','');
        // Log::info($ocs->id." OCS created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_ocs.index');
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
        $ocs = OCS::findOrFail($id);
        return view('admin.edit_ocs')->with('ocs',$ocs);
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
      
      $lang=Session::get('lang');
      $description = 'description_'.$lang;
      $this->validate($request,[
          $description=>'required|'
        ]);
      $ocs =OCS::findOrFail($id);
      $ocs->$description = $request->input($description);
      $ocs->save();
      
        $log = new Log();

        $log->table_name = 'ocs';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();

      Session::put('lang','');
      // Log::info($id." OCS updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('the_ocs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $ocs = OCS::findOrFail($id);
        $ocs->delete();
        
        $log = new Log();

        $log->table_name = 'ocs';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();

        // Log::info($id." OCS deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_ocs.index');
    }
}
