<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('role.open');

        $roles = Role::all();
        
        return view('user.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('role.create');

        Role::create($request->all());

        return redirect('admin/user/role');
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
        $this->authorize('role.edit');

        $role = Role::findOrFail($id);
        $role->update($request->all());

        return redirect('admin/user/role');
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
        $this->authorize('role.delete');
        foreach ($request->input('id') as $key => $value) {
            $role = Role::findOrFail($value);
            $role->delete();
        }

        return redirect('/admin/user/role');
    }

    public function setPermission(Request $request)
    {
        $this->authorize('role.super');

        $r = $request->input('r');
        if (!$r) {
            $r = 'super';
        }

        $role = Role::where('name', $r)->first();
        $roles = Role::lists('name','name')->all();

        $permissions = Permission::orderBy('name','asc')->lists('name','id');
        $permission_role = $role->permissions()->orderBy('name','asc')->lists('id');
        $permissions = Permission::whereNotIn('id', $permission_role)->orderBy('name','asc')->lists('name','id');
        $permission_role = $role->permissions()->orderBy('name','asc')->lists('name','id');
        
        return view('user.role.setpermission', compact('r','roles','permissions','permission_role'));
    }

    public function postPermission(Request $request)
    {
        $this->authorize('role.super');

        $permi = $request->input('permission_role');
        $role_id = $request->input('role_id');
        $role = Role::where('name',$role_id)->first();
        
        $permission_roles = $role->permissions()->sync($permi);

        return back();
    }
}