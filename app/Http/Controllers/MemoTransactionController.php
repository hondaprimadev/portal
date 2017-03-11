<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\JournalAccount;
use App\MemoCategory;
use App\MemoTransaction;
use App\UserDepartment;
use DB;
use Illuminate\Http\Request;

class MemoTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $journal_id = empty($request->input('j')) ? '' : $request->input('j');
        $branch_id = empty($request->input('b')) ? auth()->user()->branch_id : $request->input('b');
        $category_id = $request->input('c');
        $dept_id = (empty($request->input('d')) || $branch_id != 100) ? 'D6' : $request->input('d');
        $begin = $request->input('begin');
        $end = $request->input('end');
        if (empty($request->input('d'))) {
            if ($branch_id != 100) {
                $dept_id = 'D6';
            }else{
                $dept_id = auth()->user()->department_id;
            }
        }else{
            $dept_id = $request->input('d');
        }
        

        if(!$begin && !$end)
        {
            $now = date('Y-m-');
            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $begin = new \DateTime($now.'01');
            $end = new \DateTime($now.$d1);
        }else{
            $begin = new \DateTime($begin);
            $end = new \DateTime($end);
        }

        $journal = ['0'=>'--Account--'] + JournalAccount::lists('account_name','id')->all();
        $branch = ['0'=>'--Branch--'] + Branch::lists('name','id')->all();
        $category = ['0'=>'--Category--'] + MemoCategory::where('account_id',$journal_id)->lists('name','id')->all();
        $department = ['0'=>'--Department--'] + UserDepartment::lists('name','id')->all();

        $mt = MemoTransaction::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('department_id', $dept_id)
                ->whereDate('created_at', '>=', $begin)
                ->whereDate('created_at','<=', $end)
                ->get();

        return view('memo.transaction.index', compact('mt','journal','journal_id','branch','category','department','begin','end', 'branch_id','category_id','dept_id'));
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
