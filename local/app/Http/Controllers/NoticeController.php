<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
use Session;
use Yajra\Datatables\Datatables;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('notice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_notice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
        'notice_title'=>'required|string',
        'notice_description'=>'required|string'
      ]);

      $notice=new Notice();

      $notice->title=$request->notice_title;
      $notice->description=$request->notice_description;

      $notice->save();
      createLog('notices',$notice->id,'ایجاد اطلاعیه جدید');
      // flash alert i.e. print success message
      Session::flash('success',"اطلاعیه موفقانه اضافه گردید");

      return redirect()->route('notice.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getNoticeDatatable(){

      $notice = Notice::select(['id', 'title','description','status'])->orderBy('id','desc');
       return Datatables::of($notice)
      ->addColumn('action',function($row) {
        //to update categories records
          // return '<a class=" dark" onclick="openmodel('.$row['id'].')"> <i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
          return '<a class="dark" href='.route("notice.edit",$row["id"]).'> <i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
      })
      ->addColumn('status',function($row) {
        //to update categories records
        if($row['status']==1){
          $checked ='checked';
        }else{
        $checked='';
      }

          return "<input type='checkbox'    name='original' $checked id=".$row['id']."  >";

      })
      ->editColumn('description',function($row){
        return strip_tags($row['description']);
      })
      ->rawColumns(['action','status'])
      ->make();
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

    public function updateStatus($id,$status)
    {
        $notice=Notice ::find($id);
        if($status==1){
          $notice->status=1;
          createLog('notices',$id,'پنهان نمودن اطلاعیه');
        }else {
          $notice->status=0;
          createLog('notices',$id,'نمایش اطلاعیه');
        }
        $notice->save();

      }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice=Notice::find($id);

        return view('edit_notice')->with('notice',$notice);
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

      $this->validate($request,[
        'title'=>'required',
        'description'=>'required'
      ]);
      $notice=Notice::find($id);

      $notice->title=$request->title;
      $notice->description=$request->description;

      $notice->save();
      createLog('notices',$id,'تصحیح اطلاعیه');
      // flash alert i.e. print success message
      Session::flash('success',"تغییرات مؤفقانه اجراء گردید");

      return redirect()->route('notice.index');
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
}
