<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use Yajra\Datatables\Datatables;
use Auth;
use Session;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_departments');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request,[
            'department_name'=>'string|required|unique:departments,name',
            'department_description'=>'nullable'
        ]);

        // create object of department model
        $department = new Department();

        // store form data to model object
        $department->name = $request->department_name;
        $department->description = $request->department_description;

        if($department->save()){
            $request->session()->flash('success', 'Form Submitted Successfully!');
        }
        else{
            $request->session()->flash('failure', 'Form Submission Problem!');
        }

        createLog('departments',$department->id,'ایجاد مرجع جدید');

        // flash alert i.e. print success message
        Session::flash('success',"$department->name موفقانه اضافه گردید");

        return redirect()->route('departments.create');
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
        // get department model object of specific id from request and return back to the edit view
        $department = Department::findOrFail($id);

        return $department;
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
        // validate request
        $this->validate($request,[
            'department_name'=>'string|required',
            'department_description'=>'string|nullable'
        ]);

        // find department model object for the specified id
        $department = Department::findOrFail($id);

        // update department model form form data
        $department->name = $request->department_name;
        $department->description = $request->department_description;

        $department->save();
        createLog('departments',$id,'تصحیح مرجع');
        // flash alert i.e. print success message
        Session::flash('success','تغییرات مؤفقانه اجراء گردید');

        return redirect()->route('departments.index');
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

    /**
     * Get Department Data for use in Yajrabox Datatable
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentDatatable()
    {

      $departments = Department::select(['id', 'name', 'description'])->orderBy('id','desc');
      return Datatables::of($departments)

      ->addColumn('action',function($row) {
         return '<a class="dark" onclick="openmodel('.$row['id'].')"> <i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
      })
      ->make();
        //
    }
}
