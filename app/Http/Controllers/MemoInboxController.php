<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests;
use App\LeasingGroup;
use App\Memo;
use App\MemoApproval;
use App\MemoCategory;
use App\MemoSent;
use App\Supplier;
use App\User;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;

class MemoInboxController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('approve.memo')->only('edit');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('memo.open');

        $begin = $request->input('begin');
        $end = $request->input('end');

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

        $memos = Memo::where('to_memo', auth()->user()->id)
                ->where('status_memo','NOT LIKE','%REVISE BY%')
                ->orderBy('updated_at', 'desc')
                ->get();
        return view('memo.inbox.index', compact('memos', 'begin','end'));
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
        $this->authorize('memo.create');

        $no_memo = $request->input('memo_no');
        $user='';

        $memo = Memo::where('no_memo', $no_memo)->first();

        if ($memo->to_memo == auth()->user()->id) {
            if ($request->input('to_memo') == 0) {
                $user = User::where('id', auth()->user()->id)->first();
            }else{
                $user = User::where('id', $request->input('to_memo'))->first();
            }
            $status_ext = '';
        }
        else{
            $user = User::where('id', auth()->user()->id)->first();
            $status_ext = '(System Administrator)';
        }
        
        if ($user->position_id == 'H1') {
            $status = 'APPROVED BY '.$user->name.' '.$status_ext;
        }
        elseif ($user->position_id == 'H4FI') {
            $status = 'FINISHED BY '.$user->name.' '.$status_ext;
        }
        else{
            $status = 'ON PROCESS BY '.$user->name.' '.$status_ext;
        }

        $ms = MemoSent::create([
            "memo_id"=> $memo->id,
            "no_memo"=>$memo->no_memo,
            "category_id"=>$memo->category_id,
            "to_memo"=> $request->input('to_memo'),
            "from_memo"=> $memo->from_memo,
            "approval_memo"=> $memo->approval_memo,
            "subject_memo"=> $memo->subject_memo,
            "last_approval_memo"=> $user->id,
            "last_revise_memo"=> "",
            "total_memo"=> $memo->total_memo,
            "notes_memo"=> $request->input('notes_memo'),
            "status_memo"=> $status,
            "supplier_id"=> $memo->supplier_id,
            "branch_id"=> $memo->branch_id,
            "company_id"=>$memo->company_id,
            "department_id"=> $memo->department_id,
            "prepayment_finish"=> $memo->prepayment_finish,
            "prepayment_total"=>$memo->prepayment_total,
        ]);

        $memo->to_memo = $request->input('to_memo');
        $memo->last_approval_memo = $user->id;
        $memo->status_memo = $status;
        $memo->save();

        return redirect('/memo/inbox');
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
        $this->authorize('memo.edit');

        $memo = Memo::findOrFail($id);
        $memo_sent = MemoSent::where('memo_id', $memo->id)->get();
        
        $company = Company::where('id',$memo->company_id)->lists('name', 'id')->all();

        $branch = Branch::where('id',$memo->branch_id)->lists('name', 'id')->all();
        $branch_id = Branch::where('company_id', $memo->company_id)->first()->id;
        
        $depts = UserDepartment::where('id', $memo->department_id)->lists('name', 'id')->all();
        $position = UserPosition::lists('name', 'id')->all();

        $category = MemoCategory::where('id', $memo->category_id)->lists('name','id')->all();
        // $category = $category->lists('name', 'id')->all();

        $supplier = ['0'=>'--get supplier--'] + Supplier::where('branch_id', $memo->branch_id)
                    ->where('active', true)
                    ->lists('name','id')
                    ->all();
        $leasing = LeasingGroup::lists('name','name')->all();

        // get user next approval
        $approval_path = explode("+", $memo->approval_memo);
        $search = array_search(auth()->user()->position_id, $approval_path);
        $key = $search + 1;

        if (isset($approval_path[$key])) {
            $user_app = $this->getApproval($approval_path[$key], $branch_id);
            $user_app = $user_app->lists('name','id')->all();
        }else{
            // $user_app = $this->getApproval($approval_path[$search], $branch_id);
            // $user_app = $user_app->lists('name','id')->all();
            $user_app = ['0'=>'FINISH'];
        }

        $mp = MemoApproval::where('category_id', $memo->category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->get();

        return view('memo.inbox.process', compact('memo','memo_sent','company','branch','depts','position','category','supplier','leasing','user_app'));
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

    public function getApproval($approval, $branch_id)
    {
        $this->authorize('memo.open');
        
        if ($branch_id == 100) {
            $user = User::where('position_id', $approval)->get();
        }else{
            $user = User::where('position_id', $approval)
                    ->where('branch_id', $branch_id)
                    ->get();
        }

        return $user;
    }
}
