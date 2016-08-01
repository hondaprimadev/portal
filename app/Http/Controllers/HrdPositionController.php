<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserPosition;
use App\UserDepartment;

use App\Http\Requests;

class HrdPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('hrd.position.open');

        $posts = UserPosition::all();
        $depts = UserDepartment::lists('name','id')->all();
        $dept_select = [''=>'All Department'] + UserDepartment::lists('name','name')->all();

        return view('hrd.position.index', compact('posts', 'depts','dept_select'));
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
        $this->authorize('hrd.position.create');

        $this->validate($request, ['id'=>'required', 'name'=>'required', 'department_id'=>'required']);
        UserPosition::create($request->all());

        session()->flash('flash_message', 'Your Position has been created!');

        return redirect('/hrd/position/');
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
        $this->authorize('hrd.position.edit');

        $this->validate($request, ['id'=>'required', 'name'=>'required', 'department_id'=>'required']);
        $posts = UserPosition::findOrFail($id);
        $posts->update($request->all());
        session()->flash('flash_message', 'Your Position has been updated!');

        return redirect('hrd/position');
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
        $this->authorize('hrd.position.delete');

        foreach($request->input('id') as $key=>$val)
        {
            $position = UserPosition::findOrFail($val);
            $position->delete();
        }
        
        session()->flash('flash_message','Your Position has been deleted!');

        return redirect('/hrd/position');
    }
}
