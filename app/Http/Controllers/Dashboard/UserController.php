<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('destroy');

    }// end of construct

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Method (1)
        // if($request->search){
        //     $users = User::where('first_name', 'like', '%' . $request->search . '%')
        //     ->orWhere('last_name', 'like', '%' . $request->search . '%')
        //     ->get();
        // }else {
        //     $users = User::whereRoleIs('admin')->get();
        // }
        // return view('dashboard.users.index', compact('users'));

        // Method (2)
        $users = User::whereRoleIs('admin')->when($request->search, function($query) use ($request){

            return $query->where('first_name', 'like', '%' . $request->search . '%')
                 ->orWhere('last_name', 'like', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.users.index', compact('users'));

    }// end of index

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('dashboard.users.create');

    }// end of create

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);

        $user = User::create($request_data);

        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.added_successfully'));        
        return redirect()->route('dashboard.users.index');

    }// end of store

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        return view('dashboard.users.edit', compact('user'));

    }// end of edit

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $request_data = $request->except(['password', 'password_confirmation', 'permissions']);
        $request_data['password'] = bcrypt($request->password);

        $user->update($request_data);

        $user->syncPermissions($request->permissions);

        session()->flash('success', __('site.updated_successfully'));        
        return redirect()->route('dashboard.users.index');

    }// end of update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        session()->flash('success', __('site.deleted_successfully'));        
        return redirect()->route('dashboard.users.index');

    }// end of destroy
}
