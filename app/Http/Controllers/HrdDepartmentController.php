<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserDepartment;

use App\Http\Requests;

class HrdDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('hrd.department.open');
        
        $depts = UserDepartment::all();

        return view('hrd.department.index', compact('depts'));
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
        $this->authorize('hrd.department.create');

        $this->validate($request, ['name'=>'required', 'id'=>'required']);
        UserDepartment::create($request->all());

        session()->flash('flash_message', 'Your Department has been created!');

        return redirect('/hrd/department');
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
        $this->authorize('hrd.department.edit'); 

        $this->validate($request,['name'=>'required', 'id'=>'required']);
        $dept = UserDepartment::findOrFail($id);

        $dept->update($request->all());

        session()->flash('flash_message', 'Your Department has been updated!');

        return redirect('/hrd/department');
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
        $this->authorize('hrd.department.delete');

        foreach($request->input('id') as $key=>$val)
        {
            $brand = UserDepartment::findOrFail($val);
            $brand->delete();
        }
        
        session()->flash('flash_message','Your Department has been deleted!');

        return redirect('/hrd/department');
    }
}
