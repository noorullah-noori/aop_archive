<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presidential_Palace;
// use Log;
use Session;
use Auth;
use Carbon\Carbon;
use App\Log;

class Presidential_PalaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $palace = Presidential_Palace::all();
        return view('admin.palace')->with('palace',$palace);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_palace');
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
          $description=>'required',
        ]);
      
      $palace = new Presidential_Palace();
      $palace->$description = $request->input($description);
      $palace->save();

      $log = new Log();

      $log->table_name = 'presidential_palace';
      $log->table_item_id = $palace->id;
      $log->activity = 'create';
      $log->user_id = Auth::user()->id;
      $log->save();

      Session::put('lang','');
      // Log::info($palace->id." President palace record created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('the_palace.index');
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
        $palace = Presidential_Palace::findOrFail($id);
        return view('admin.edit_palace')->with('palace',$palace);
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
          $description=>'required',
        ]);
      
      $palace =Presidential_Palace::findOrFail($id);
      $palace->$description = $request->input($description);
      $palace->save();
      
      $log = new Log();

      $log->table_name = 'presidential_palace';
      $log->table_item_id = $id;
      $log->activity = 'update';
      $log->user_id = Auth::user()->id;
      $log->save();

      Session::put('lang','');
      // Log::info($id." President Palace Record updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
      return Redirect()->route('the_palace.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        $palace = Presidential_Palace::findOrFail($id);
        $palace->delete();
        
        $log = new Log();

        $log->table_name = 'presidential_palace';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();
        
        // Log::info($id." President Palace record deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_palace.index');
    }
}
