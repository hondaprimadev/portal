<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\JournalAccount;
use App\MemoCategory;
use App\UserDepartment;
use Illuminate\Http\Request;

class MemoCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        $mc = MemoCategory::create($request->all());

        return redirect()->back()->with('tab','category');
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
        $mc = MemoCategory::findOrFail($id);
        $mc->update($request->all());

        return redirect()->back()->with('tab','category');
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
        foreach ($request->input('id') as $key => $value) {
            $m = MemoCategory::findOrFail($value);
            $m->delete();
        }

        session()->flash('flash_message','Your Category has been deleted!');

        return redirect()->back()->with('tab','category');
    }
}
