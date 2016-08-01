<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('permission.open');
        
        $permissions = Permission::orderBy('name','asc')->get();
        $roles = Role::lists('name','id');

        return view('user.permission.index', compact('permissions','roles'));
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
        $this->authorize('permission.create');

        $permission = Permission::create($request->all());
        if ($request->input('role')) {
            $permission->roles()->sync($request->input('role'));
        }

        return redirect('/admin/user/permission');
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
        //
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
        $this->authorize('permission.edit');

        $permission = Permission::findOrFail($id);
        $permission->update($request->all());

        if (!empty($request->input('role'))) {
            $permission->roles()->sync($request->input('role'));   
        }

        return redirect('/admin/user/permission');
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

    public function delete(Request $request)
    {
        $this->authorize('permission.delete');
        
        foreach ($request->input('id') as $key => $value) {
            $permission = Permission::findOrFail($value);
            $permission->delete();
        }

        return redirect('admin/user/permission');
    }

}
