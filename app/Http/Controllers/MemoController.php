<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests;
use App\LeasingGroup;
use App\Memo;
use App\MemoApproval;
use App\MemoCategory;
use App\MemoDetail;
use App\MemoFinanceSupport;
use App\MemoSent;
use App\MemoTransaction;
use App\Supplier;
use App\User;
use App\UserDepartment;
use App\UserPosition;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as Req;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('memo.revise')->only('edit','update','show');
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
        
        $memos = Memo::where('from_memo', auth()->user()->id)
                    ->whereDate('created_at', '>=', $begin)
                    ->whereDate('created_at','<=', $end)
                    ->get();
        
        return view('memo.index', compact('memos', 'begin','end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('memo.create');

        $url = Req::fullUrl();
        $user_app = [''=>'---'];
        $budget=0;
        $approval_path='';

        // from get response
        $bid = $request->input('branch');
        $cid = $request->input('company');
        $did = $request->input('dept');
        $eid = $request->input('category');
        $date = date('Y-m-d');

        $branch_id = empty($bid) ? auth()->user()->branch_id : $bid;
        $company_id= empty($cid) ? auth()->user()->company_id : $cid;
        $dept_id = empty($did) ? auth()->user()->department_id : $did;
        $category_id = empty($eid) ? '' : $eid;
        
        $company = [''=>'---'] + Company::lists('name', 'id')->all();
        $branch = [''=>'---'] + Branch::where('company_id',$company_id)->lists('name', 'id')->all();
        $depts = [''=>'---'] + UserDepartment::lists('name', 'id')->all();
        $position = [''=>'---'] + UserPosition::lists('name', 'id')->all();
        $category = [''=>'---'] + MemoCategory::where('department_id', $dept_id)->orderBy('name', 'asc')->lists('name', 'id')->all();
        $supplier = [''=>'--get supplier--'] + Supplier::where('branch_id', $branch_id)
                    ->where('active', true)
                    ->lists('name','id')
                    ->all();
        $leasing = [''=>'---'] + LeasingGroup::lists('name','name')->all();

        if (auth()->user()->can('memo.super')) {
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('budget', true)
                ->get();
        }else{
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->get();
        }

        if($mp->count() > 0){
            foreach ($mp as $mp_null) {
                $approval = explode("+",$mp_null->approval_path);
                $getUser = $this->getApproval($approval[0], $branch_id);
                foreach ($getUser as $gu) {
                    $user_app = [$gu->id=>$gu->name];
                }
                $budget += $mp_null->budget_total;
                $approval_path = $mp_null->approval_path;
                $saldo = $this->getSaldo(
                    $branch_id, 
                    $category_id,
                    $mp_null->inv_date1, 
                    $mp_null->inv_date2
                );
            }
        }else{
             $mps = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', false)
                ->get();

            if ($mps->count() > 0) {
                foreach ($mps as $mp_null) {
                    $approval = explode("+",$mp_null->approval_path);
                    $getUser = $this->getApproval($approval[0], $branch_id);
                    foreach ($getUser as $gu) {
                        $user_app = [$gu->id=>$gu->name];
                    }
                    $budget += $mp_null->budget_total;
                    $approval_path = $mp_null->approval_path;
                }
            }   
        }

        return view('memo.create', compact('url','company','company_id','branch','branch_id','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo'));
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

        $validator = Validator::make($request->all(), Memo::$rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($validator);
        }

        if ($request->input('budget')) {
            $getBudget = intval(str_replace(',','',$request->input('budget')));
            $getTotal = intval(str_replace(',','',$request->input('all_total_detail')));

            if ($getTotal > $getBudget) {
                return redirect()->back()->withErrors(['budget'=>'Your budget get to the limit']);
            }
        }

        if ($request->input('memo_no') == Memo::ofMaxno($request->input('branch_id'), $request->input('company_id'))) {
            $no_memo = $request->input('memo_no');
        }else{
            return redirect()->back()->withErrors(['no_memo'=>'required no memo']);
        }

        $user_memo = User::where('id', auth()->user()->id)->first();
        $department_id = $request->input('branch_id') != 100 ? 'D6' : $user_memo->department_id;

        $memo = Memo::create($request->all());

        $memo->no_memo = $no_memo;
        $memo->status_memo = 'ON PROCESS';
        $memo->total_memo = intval(str_replace(',','',$request->input('all_total_detail')));
        $memo->from_memo= auth()->user()->id;
        $memo->department_id = $department_id;
        $memo->token = md5(uniqid($memo->no_memo, true));
        $memo->save();

        $memoSent = MemoSent::create([
            'memo_id'=>$memo->id,
            'no_memo'=>$memo->no_memo,
            'status_memo' => 'ON PROCESS',
            'total_memo' => intval(str_replace(',','',$request->input('all_total_detail'))),
            'from_memo' => $memo->from_memo,
            'department_id' => $department_id,
            ]);
        $memoSent->update($request->all());

        $detail = [];
        foreach($request->input('date_detail') as $key=>$val)
        {
            $detail = [
                'date'=> $val,
                'memo_id'=>$memo->id,
                'category_id'=>$memo->category_id,
                'description'=> $request->input('description')[$key],
                'qty'=>$request->input('qty')[$key],
                'total'=>intval(str_replace(',','',$request->input('sub_total_memo')[$key])),
            ];
            if($val !='')
            {
                MemoDetail::create($detail);
            }
        }

        $leasing = [];
        foreach ($request->input('group_leasing') as $key => $value) {
            $leasing = [
                'memo_id'=>$memo->id,
                'group_leasing'=>$value,
                'total'=>intval(str_replace(',','',$request->input('sub_total_finance')[$key])),
                'notes'=>$request->input("notes")[$key],
            ];
            if ($value != '') {
                MemoFinanceSupport::create($leasing);
            }
        }

        MemoTransaction::create([
            'user_id'=>$memo->from_memo,
            'memo_id'=>$memo->id,
            'credit'=>$memo->total_memo,
            'branch_id'=>$request->input('branch_id'),
            'category_id'=>$request->input('category_id'),
            'department_id'=>$department_id
        ]);

        return redirect('/memo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('memo.open');

        $memo = Memo::where('token', $id)->first();

        $memo_sent = MemoSent::where('memo_id', $memo->id)->get();

        $company = Company::where('id',$memo->company_id)->lists('name', 'id')->all();

        $branch = Branch::where('id',$memo->branch_id)->lists('name', 'id')->all();
        $branch_id = Branch::where('company_id', $memo->company_id)->first()->id;
        
        $depts = UserDepartment::where('id', $memo->department_id)->lists('name', 'id')->all();
        $position = UserPosition::lists('name', 'id')->all();

        $category = MemoCategory::where('id', $memo->category_id)->lists('name','id')->all();

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

        return view('memo.show', compact('memo','memo_sent','company','branch','depts','position','category','supplier','leasing','user_app'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('memo.edit');

        $memo = Memo::where('token', $id)->first();
        $memo_sent = MemoSent::where('memo_id', $memo->id)->get();

        $url = Req::fullUrl();
        $user_app = [''=>'---'];
        $budget=0;
        $approval_path='';

        // from get response
        $bid = $request->input('branch');
        $cid = $request->input('company');
        $did = $request->input('dept');
        $eid = $request->input('category');
        $date = date('Y-m-d');

        $branch_id = empty($bid) ? $memo->branch_id : $bid;
        $company_id= empty($cid) ? $memo->company_id : $cid;
        $dept_id = empty($did) ? $memo->department_id : $did;
        $category_id = empty($eid) ? $memo->category_id : $eid;
        
        $company = [''=>'---'] + Company::lists('name', 'id')->all();
        $branch = [''=>'---'] + Branch::where('company_id',$company_id)->lists('name', 'id')->all();
        $depts = [''=>'---'] + UserDepartment::lists('name', 'id')->all();
        $position = [''=>'---'] + UserPosition::lists('name', 'id')->all();
        $category = [''=>'---'] + MemoCategory::where('department_id', $dept_id)->lists('name', 'id')->all();
        $supplier = ['0'=>'--get supplier--'] + Supplier::where('branch_id', $branch_id)
                    ->where('active', true)
                    ->lists('name','id')
                    ->all();
        $leasing = [''=>'---'] + LeasingGroup::lists('name','name')->all();

        if (auth()->user()->can('memo.super')) {
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('budget', true)
                ->get();
        }else{
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->get();
        }

        if($mp->count() > 0){
            foreach ($mp as $mp_null) {
                $approval = explode("+",$mp_null->approval_path);
                $getUser = $this->getApproval($approval[0], $branch_id);
                foreach ($getUser as $gu) {
                    $user_app = [$gu->id=>$gu->name];
                }
                $budget += $mp_null->budget_total;
                $approval_path = $mp_null->approval_path;
                $saldo = $this->getSaldo(
                    $branch_id, 
                    $category_id,
                    $mp_null->inv_date1, 
                    $mp_null->inv_date2
                );
            }
        }else{
             $mps = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', false)
                ->get();

            if ($mps->count() > 0) {
                foreach ($mps as $mp_null) {
                    $approval = explode("+",$mp_null->approval_path);
                    $getUser = $this->getApproval($approval[0], $branch_id);
                    foreach ($getUser as $gu) {
                        $user_app = [$gu->id=>$gu->name];
                    }
                    $budget += $mp_null->budget_total;
                    $approval_path = $mp_null->approval_path;
                }
            }   
        }

        return view('memo.edit', compact('memo','memo_sent','url','company','company_id','branch','branch_id','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo'));
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
        $this->authorize('memo.edit');

        $validator = Validator::make($request->all(), Memo::$rules);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()->back()->withErrors($validator);
        }

        if ($request->input('budget')) {
            $getBudget = intval(str_replace(',','',$request->input('budget')));
            $getTotal = intval(str_replace(',','',$request->input('all_total_detail')));

            if ($getTotal > $getBudget) {
                return redirect()->back()->withErrors(['budget'=>'Your budget get to the limit']);
            }
        }
        
        $user_memo = User::where('id', auth()->user()->id)->first();
        $department_id = $request->input('branch_id') != 100 ? 'D6' : $user_memo->department_id;

        $memo = Memo::where('token',$id)->first();
        $memo->update($request->all());

        $memo->status_memo = 'ON PROCESS (REVISE)';
        $memo->total_memo = intval(str_replace(',','',$request->input('all_total_detail')));
        $memo->department_id = $department_id;
        $memo->save();

        

        $memoSent = MemoSent::create([
            'memo_id'=>$memo->id,
            'no_memo'=>$memo->no_memo,
            'subject_memo'=>$memo->subject_memo. " (REVISE)",
            'status_memo' => 'ON PROCESS (REVISE)',
            'total_memo' => intval(str_replace(',','',$request->input('all_total_detail'))),
            'department_id' => $department_id,
        ]);

        $memoSent->update($request->all());


        // Detail Memo
        foreach ($request->input('id_detail') as $key => $value) {
            if (empty($value)) {
                MemoDetail::create([
                    'memo_id' => $memo->id,
                    'category_id'=>$memo->category_id,
                    'description'=>$request->input('description')[$key],
                    'qty'=>$request->input('qty')[$key],
                    'total'=>intval(str_replace(',','',$request->input('sub_total_memo')[$key])),
                    'date'=>$request->input('date_detail')[$key],
                ]);
            }else{
                $memoDetail = MemoDetail::find($value);
                $memoDetail->qty = $request->input('qty')[$key];
                $memoDetail->description = $request->input('description')[$key];
                $memoDetail->total = intval(str_replace(',','',$request->input('sub_total_memo')[$key]));
                $memoDetail->date = $request->input('date_detail')[$key];
                $memoDetail->save();
            }
        }

        if (!empty($request->input('id_leasing'))) {
            foreach ($request->input('id_leasing') as $key => $value) {
                if (empty($value)) {
                    MemoFinanceSupport::create([
                        'memo_id' => $memo->id,
                        'group_leasing'=>$request->input('group_leasing')[$key],
                        'total'=>intval(str_replace(',','',$request->input('sub_total_finance')[$key])),
                        'notes'=>$request->input('notes')[$key]
                    ]);
                }else{
                    $memoFin = MemoFinanceSupport::find($value);
                    $memoFin->group_leasing = $request->input('group_leasing')[$key];
                    $memoFin->total = intval(str_replace(',','',$request->input('sub_total_finance')[$key]));
                    $memoFin->notes = $request->input('notes')[$key];
                    $memoFin->save();
                }
            }
        }

        MemoTransaction::create([
            'user_id'=>$memo->from_memo,
            'memo_id'=>$memo->id,
            'credit'=>$memo->total_memo,
            'branch_id'=>$request->input('branch_id'),
            'category_id'=>$request->input('category_id'),
            'department_id'=>$department_id
        ]);

        return redirect('/memo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('memo.delete');
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

    public function getSupplierId(Request $request)
    {
        $this->authorize('memo.open');

        $id = $request->input('id');
        $type = $request->input('type');
        if ($type=='employee') {
            return array_add(User::find($id), 'type', 'employee');
        }else{
            return array_add(Supplier::with('bank')->find($id), 'type', 'supplier');
        }
    }

    public function getSupplier(Request $request)
    {
        $this->authorize('memo.open');

        $supplier = $request->input('s');
        $branch_id = $request->input('b');

        if ($supplier=='supplier') {
            $supp = Supplier::where('branch_id', $branch_id)
                    ->where('active', true)
                    ->lists('name','id')
                    ->all();
        }else{
            if ($branch_id=='100') {
                $supp = User::where('job_status', 'Active')
                            ->lists('name', 'id')
                            ->all();
            }else{
                $supp = User::where('branch_id', $branch_id)
                            ->where('job_status', 'Active')
                            ->lists('name', 'id')
                            ->all();
            }
        }   
        return $supp;
    }

    public function getSaldo($branch, $category, $date1, $date2)
    {
        $this->authorize('memo.open');
        
        if ($branch == 100) {
            $mt = MemoTransaction::select(DB::raw('(SUM(debet)-SUM(credit)) as saldo'))
                ->where('category_id', $category)
                ->where('branch_id', $branch)
                ->where('department_id', auth()->user()->department_id)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at','<=', $date2)
                ->first();
        }else{
            $mt = MemoTransaction::select(DB::raw('(SUM(debet)-SUM(credit)) as saldo'))
                ->where('category_id', $category)
                ->where('branch_id', $branch)
                ->whereDate('created_at', '>=', $date1)
                ->whereDate('created_at','<=', $date2)
                ->first();
        }
        return $mt->saldo;
    }
}