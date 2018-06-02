<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chief;
use Session;
// use Log;
use Auth;
use Carbon\Carbon;
use App\Log;

class ChiefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chief = Chief::all();
        return view('admin.chief')->with('chief',$chief);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_chief');
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

        $chief = new Chief();
        $chief->$description = $request->input($description);
        $chief->save();
        
        $log = new Log();

        $log->table_name = 'chief';
        $log->table_item_id = $chief->id;
        $log->activity = 'create';
        $log->user_id = Auth::user()->id;
        $log->save();

        Session::put('lang','');
        // Log::info($chief->id." Cheif of staff details created by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_chief.index');
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
        $chief = Chief::findOrFail($id);
        return view('admin.edit_chief')->with('chief',$chief);
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
        $lang = Session::get('lang');
        $description = 'description_'.$lang;

        $this->validate($request,[
             $description=>'required',
           ]);

        $chief =Chief::findOrFail($id);
        $chief->$description = $request->input($description);
        $chief->save();

        $log = new Log();

        $log->table_name = 'chief';
        $log->table_item_id = $id;
        $log->activity = 'update';
        $log->user_id = Auth::user()->id;
        $log->save();


        Session::put('lang','');
        // Log::info($id." Cheif of staff details updated by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_chief.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $chief = Chief::findOrFail($id);
        $chief->delete();

        $log = new Log();

        $log->table_name = 'chief';
        $log->table_item_id = $id;
        $log->activity = 'delete';
        $log->user_id = Auth::user()->id;
        $log->save();


        // Log::info($id." Chief of staff details deleted by ".Session::get('email')." on ".date('l jS \of F Y h:i:s A'));
        return Redirect()->route('the_chief.index');
    }
}
