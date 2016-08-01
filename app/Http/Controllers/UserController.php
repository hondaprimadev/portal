<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('user.open');

        $users = User::where('is_user', true)->get();
        $branch = Branch::lists('name','id');
        $roles = Role::lists('name','id');
        $branches = [''=>'All Branch'] + Branch::lists('name','name')->all();

        return view('user.user.index', compact('users', 'branch','branches','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('user.create');

        User::create($request->all());

        return redirect('/admin/user/');
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
        $this->authorize('user.edit');

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect('/admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('user.delete');

        foreach ($request->input('id') as $key => $value) {
            $user = User::findOrFail($value);
            $user->delete();
        }
        session()->flash('flash_message','Your Department has been deleted!');

        return redirect('/admin/user');
    }
}
