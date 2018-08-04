<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Yajra\Datatables\Datatables;
use Validator;
use Session;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // vaidate Request
        $this->validate($request,[
            'category_name'=>'string|required|unique:categories,name',
            'category_description'=>'nullable|string',
            // 'category_name_en'=>'string|required|unique:categories,name_en'
        ]);

        // Create new catagory model object
        $category=new Category();

        // store data to model object from request
        $category->name=$request->category_name;

        // $category->name_en=$request->category_name_en;

        $category->description=$request->category_description;

        $category->save();

        createLog('categories',$category->id,'ایجاد نوعیت سند');

        // flash alert i.e. print success message
        Session::flash('success',"$category->name موفقانه اضافه گردید");

        return redirect()->route('categories.create');


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
       $categories=Category::findOrFail($id);
       return $categories;
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
        // vaidate Request

        $this->validate($request,[
            'category_name'=>'string|required',
            'category_description'=>'nullable|string'
        ]);

        // Create new catagory model object
       $categories=Category::findOrFail($id);

        // store data to model object from request
        $categories->name=$request->category_name;
        $categories->description=$request->category_description;

        $categories->save();

        createLog('categories',$id,'تصحیح نوعیت سند');

        Session::flash('success','تغییرات مؤفقانه اجراء گردید');

        return redirect()->route('categories.index');

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
     * Get categories Data for use in Yajrabox Datatable
     *
     * @param  void
     * @return \Illuminate\Http\Response
     */
    public function getCategoryDatatable(){

      $categories = Category::select(['id', 'name', 'description'])->orderBy('id','desc');
      return Datatables::of($categories)
      ->addColumn('action',function($row) {
        //to update categories records
          return '<a class=" dark" onclick="openmodel('.$row['id'].')"> <i style="font-size:1.3em !important;" class=" icon-note"></i></a>';
      })
      ->make();
    }

}
