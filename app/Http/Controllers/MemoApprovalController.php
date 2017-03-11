<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\MemoApproval;
use App\MemoCategory;
use App\MemoTransaction;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;

class MemoApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $begin = $request->input('begin');
        $end  = $request->input('end');
        $budget = empty($request->input('budget')) ? '0' : $request->input('budget');
        $bid = empty($request->input('branch')) ? auth()->user()->branch_id : $request->input('branch');
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
    
        if ($budget > 0) {
            $memos = MemoApproval::where('budget',$budget)
                ->where('inv_date1', $begin->format('Y-m-d'))
                ->where('inv_date2', $end->format('Y-m-d'))
                ->where('branch_id', $bid)
                ->get();
        }else{
            $memos = MemoApproval::where('budget',$budget)->where('branch_id', $bid)->get();
        }

        $userPosition = [''=>'---'] + UserPosition::lists('name', 'id')->all();
        $branch = [''=>'--Branch--'] + Branch::lists('name', 'id')->all();
        $category = [''=>'---'] + MemoCategory::lists('name', 'id')->all();
        $department = [''=>'---'] + UserDepartment::lists('name', 'id')->all();

        return view('memo.approval.index', compact('memos','begin','end','budget','userPosition','branch','bid','category','department'));
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
        $budget = empty($request->input('budget_total')) ? false : true;
        $prepayment = empty($request->input('prepayment')) ? false : true;
        $department = UserPosition::where('id', $request->input('user_approval'))->first();

        $mp = MemoApproval::create([
            'category_id'=>$request->input('category_id'),
            'approval_path'=>$request->input('approval_path'),
            'branch_id'=>$request->input('branch_id'),
            'user_approval'=>$request->input('user_approval'),
            'budget'=> $budget,
            'budget_total'=>$request->input('budget_total'),
            'prepayment'=>$prepayment,
            'inv_date1'=>$request->input('inv_date1'),
            'inv_date2'=>$request->input('inv_date2'),
            'department_id'=>$department->department_id,
        ]);
        if ($mp->budget) {
            $mt = MemoTransaction::create([
                'user_id'=>auth()->user()->id,
                'memo_id'=>'',
                'debet'=>$mp->budget_total,
                'branch_id'=>$mp->branch_id,
                'category_id'=>$mp->category_id,
                'approval_id'=>$mp->id,
                'department_id'=>$department->department_id,
            ]);
        }

        return redirect('memo/approval');
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
        $budget = empty($request->input('budget_total')) ? false : true;
        $prepayment = empty($request->input('prepayment')) ? false : true;
        $department = UserPosition::where('id', $request->input('user_approval'))->first();

        $mp = MemoApproval::find($id);
        $mp->update([
            'category_id'=>$request->input('category_id'),
            'approval_path'=>$request->input('approval_path'),
            'branch_id'=>$request->input('branch_id'),
            'user_approval'=>$request->input('user_approval'),
            'budget'=> $budget,
            'budget_total'=>$request->input('budget_total'),
            'prepayment'=>$prepayment,
            'inv_date1'=>$request->input('inv_date1'),
            'inv_date2'=>$request->input('inv_date2'),
            'department_id'=>$department->department_id,
        ]);
        $mt = MemoTransaction::where('approval_id', $mp->id)->first();
        
        $mt->user_id = auth()->user()->id;
        $mt->memo_id = '';
        $mt->debet = $mp->budget_total;
        $mt->branch_id = $mp->branch_id;
        $mt->category_id = $mp->category_id;
        $mt->department_id = $mp->department_id;
        $mt->save();

        return redirect('memo/approval');    }

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
