<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\MemoSent;
use App\UserDepartment;
use Illuminate\Http\Request;

class MemoSentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $branch_id = empty($request->input('branch')) ? auth()->user()->branch_id : $request->input('branch');
        $department_id = (empty($request->input('dept')) || $branch_id != 100) ? 'D6' : $request->input('dept');
        $no_memo = empty($request->input('no')) ? 'asdfghjk' : $request->input('no');

        $memo_sent = MemoSent::where('branch_id', $branch_id)
            ->where('department_id', $department_id)
            ->where('no_memo','like','%'.$no_memo.'%')
            ->get();

        $branch = ['0'=>'--Branch--'] + Branch::lists('name','id')->all();
        $department = ['0'=>'--Department--'] + UserDepartment::lists('name','id')->all();

        return view('memo.sent.index', compact('memo_sent', 'branch','branch_id','department','department_id'));
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
        //
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
        //
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
}
