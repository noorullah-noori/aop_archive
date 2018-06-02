<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class UserController extends Controller {

    public function __construct() {
        $this->middleware(['auth']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        //Get all users and pass it to the view
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
        $users = User::orderBy('id','desc')->get();
        return view('users.index')->with('users', $users);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    //Get all roles and pass it to the view
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
        $roles = Role::get();
        return view('users.create', ['roles'=>$roles]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
      if(!Auth::user()->hasRole('admin')){
        abort(401);
      }
    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = User::create($request->only('email', 'name', 'password')); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
    //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();
            $user->assignRole($role_r); //Assigning role to user
            }
        }
        createLog('users',$user->id,'ایجاد کاربر جدید');
    //Redirect to the users.index view and display message
        return redirect()->route('users.index')
            ->with('success',
             "کاربر $user->name موفقانه ایجاد گردید");
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
        return redirect('users');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        if(!Auth::user()->hasRole('admin') && $id!=Auth::user()->id){
          abort(401);
        }
        $user = User::findOrFail($id); //Get user with specified id
        // $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user')); //pass user and roles data to view

    }


    /**
    * Show the form for editing the specified resource i.e (user roles).
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function editUserRole($id) {
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
        $user = User::findOrFail($id); //Get user with specified id
        $roles = Role::get(); //Get all roles
        return view('users.edit_role', compact('user', 'roles')); //pass user and roles data to view
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        if(!Auth::user()->hasRole('admin') && $id!=Auth::user()->id){
          abort(401);
        }
    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'confirmed'
        ]);

        $user = User::findOrFail($id); //Get role specified by id
        if($request->password!=null) {
          $input = $request->only(['name', 'email', 'password']); //Retreive the name, email and password fields
        }
        else{
          $input = $request->only(['name', 'email']); //Retreive the name, email and password fields
          // $user->name = $request->name;
          // $user->name = $request->email;
          // $user->password = Hash::make($request->password);
          // $user->save();
        }
        $user->fill($input)->save();
        createLog('users',$id,'تصحیح کاربر');
        return redirect()->back()
            ->with('success',
             "کاربر $user->name موفقانه تصحیح گردید");

        if(auth()->user()->hasRole('admin')) {
          return redirect()->route('users.index');
        }
        else {
          return redirect()->route('dashboard')
          ->with('success',
          "کاربر $user->name موفقانه تصحیح گردید");
        }
    }

    /**
    * Update the specified resource in storage i.e(user roles).
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function updateUserRole(Request $request, $id) {
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
        $user = User::findOrFail($id); //Get role specified by id

        $roles = $request['roles']; //Retreive all roles

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        createLog('users',$id,'دادن صلاحیت به نقش');
        return redirect()->route('users.index')
            ->with('success',
             "کاربر $user->name موفقانه تصحیح گردید");
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
        if(!Auth::user()->hasRole('admin')){
          abort(401);
        }
    //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success',
             'کاربر موفقانه حذف گردید.');
    }

    public function updateUserStatus($id,$status)
    {
        $user=User::find($id);
        if($status==1){
          $user->type='1';
          createLog('users',$id,'کاربر موفقانه فعال گردید');
        }else {
          $user->type='0';
          createLog('users',$id,'کاربر موفقانه غیر فعال گردید');
        }
        $user->save();
      }
}
