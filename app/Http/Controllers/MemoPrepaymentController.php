<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests;
use App\LeasingGroup;
use App\Memo;
use App\MemoApproval;
use App\MemoCategory;
use App\MemoFinanceSupport;
use App\MemoSent;
use App\MemoTransaction;
use App\Services\MemoManager;
use App\Supplier;
use App\User;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as Req;
use Illuminate\Support\Facades\Validator;

class MemoPrepaymentController extends Controller
{
    protected $manager;

    public function __construct(MemoManager $manager)
    {
        $this->manager = $manager;
        $this->middleware('memo.prepayment.finish')->only('create');
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
        $finish = $request->input('finish');

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
        
        if ($finish == 'true') {
            $memos = Memo::where('from_memo', auth()->user()->id)
                    ->where('prepayment_total','>',0)
                    ->where('prepayment_finish', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }else{
            $memos = Memo::where('from_memo', auth()->user()->id)
                    ->whereDate('created_at', '>=', $begin)
                    ->whereDate('created_at','<=', $end)
                    ->where('prepayment_total','>',0)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }
                    
        return view('memo.prepayment.index', compact('memos', 'begin','end'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $url = Req::fullUrl();
        $user_app = [''=>'---'];
        $budget=0;
        $approval_path='';

        $prepayment_no = '';
        $prepayment_total = '';
        $prepayment_subject = '';

        // from get response
        $bid = $request->input('branch');
        $cid = $request->input('company');
        $did = $request->input('dept');
        $duid = $request->input('dept-user');
        $eid = $request->input('category');
        $date = date('Y-m-d');

        if (Gate::check('memo.super')) {
            $duid = $request->input('dept-user');
            $dept_id_user = empty($duid) ? auth()->user()->department_id : $duid;
        }else{
            $dept_id_user = auth()->user()->department_id;
        }

        $branch_id = empty($bid) ? auth()->user()->branch_id : $bid;
        $company_id= empty($cid) ? auth()->user()->company_id : $cid;
        $dept_id = empty($did) ? auth()->user()->department_id : $did;
        $category_id = empty($eid) ? '' : $eid;

        if ($branch_id != 100) {
            $dept_user = [''=>'---','D6'=>'BRANCH', 'D7'=>'SERVICE SPARE PART'];
        }else{
            $dept_user = [''=>'---'] + UserDepartment::lists('name', 'id')->all();    
        }
        
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
                ->where('prepayment', true)
                ->whereDate('inv_date1', '<=',date('Y-m-d'))
                ->whereDate('inv_date2', '>=',date('Y-m-d'))
                ->get();
        }else{
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->where('prepayment', true)
                ->whereDate('inv_date1', '<=',date('Y-m-d'))
                ->whereDate('inv_date2', '>=',date('Y-m-d'))
                ->get();
        }
        
        if($mp->count() > 0){
            foreach ($mp as $mp_null) {
                $approval = explode("+",$mp_null->approval_path);
                $branch_choice = substr($approval[0], 0, 1);
                if ($branch_choice == 'H') {
                    $getUser = $this->getApproval($approval[0],$approval);
                }else{
                    $getUser = $this->getApproval($approval[0],$approval, $branch_id);
                }
                
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
            if (auth()->user()->can('memo.super')) {
                $mps = MemoApproval::where('category_id', $category_id)
                    ->where('branch_id', $branch_id)
                    ->where('budget', false)
                    ->where('prepayment', true)
                    ->get();
            }else{
                $mps = MemoApproval::where('category_id', $category_id)
                    ->where('branch_id', $branch_id)
                    ->where('user_approval', auth()->user()->position_id)
                    ->where('budget', false)
                    ->where('prepayment', true)
                    ->get();
            }

            if ($mps->count() > 0) {
                foreach ($mps as $mp_null) {
                    $approval = explode("+",$mp_null->approval_path);
                    $branch_choice = substr($approval[0], 0,1);

                    if ($branch_choice == 'H') {
                        $getUser = $this->getApproval($approval[0],$approval);
                    }else{
                        $getUser = $this->getApproval($approval[0],$approval, $branch_id);
                    }
                    foreach ($getUser as $gu) {
                        $user_app = [$gu->id=>$gu->name];
                    }

                    $budget += $mp_null->budget_total;
                    $approval_path = $mp_null->approval_path;
                }
            }   
        }

        return view('memo.prepayment.create', compact('url','company','company_id','branch','branch_id','dept_user','dept_id_user','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo','prepayment_subject','prepayment_no'));
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

        $validator = Validator::make($request->all(), [
            'memo_no' => 'required',
            'subject_memo'=>'required',
            'approval_memo'=>'required',
            'to_memo'=>'required',
            'category_id'=>'required',
            'department_id_approval'=>'required',
            'department_id'=>'required',
            'prepayment_total'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->except(['group_leasing','sub_total_finance','notes','total','notes_memo']));
        }


        $validator = Validator::make($request->all(), [
            'memo_no' => 'required',
            'subject_memo'=>'required',
            'approval_memo'=>'required',
            'to_memo'=>'required',
            'category_id'=>'required',
            'department_id_approval'=>'required',
            'department_id'=>'required',
            'prepayment_total'=>'required',
        ]);

        if ($request->input('budget')) {
            $getBudget = intval(str_replace(',','',$request->input('budget')));
            $getTotal = intval(str_replace(',','',$request->input('prepayment_total')));

            if ($getTotal > $getBudget) {
                return redirect()
                       ->back()
                       ->withErrors([
                        'budget'=>'Your budget get to the limit',
                        'prepayment_total'=>'Change your request'
                        ])
                       ->withInput($request->except(['group_leasing','sub_total_finance','notes','total','notes_memo']));
            }
        }

        if ($request->input('memo_no') == Memo::ofMaxno($request->input('branch_id'), $request->input('company_id'), $request->input('department_id'))) {
            $no_memo = $request->input('memo_no');
        }else{
            return redirect()->back()->withErrors(['no_memo'=>'required no memo']);
        }

        $user_memo = User::where('id', auth()->user()->id)->first();

        $memo = Memo::create($request->all());

        $memo->no_memo = $no_memo;
        $memo->status_memo = 'ON PROCESS PREPAYMENT';
        $memo->prepayment_total = intval(str_replace(',','',$request->input('prepayment_total')));
        $memo->from_memo= auth()->user()->id;
        $memo->department_id = $request->input('department_id');
        $memo->token = md5(uniqid($memo->no_memo, true));
        $memo->save();

        $memoSent = MemoSent::create([
            'memo_id'=>$memo->id,
            'no_memo'=>$memo->no_memo,
            'status_memo' => 'ON PROCESS PREPAYMENT',
            'total_memo' => intval(str_replace(',','',$request->input('prepayment_total'))),
            'from_memo' => $memo->from_memo,
            'department_id' => $memo->department_id,
            ]);
        $memoSent->update($request->all());

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

        if ($request->input('budget')) {
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'credit'=>$memo->prepayment_total,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
                'notes'=>'Bank out',
            ]);
        }else{
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'debet'=>$memo->prepayment_total,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
                'notes'=>'Piutang',
            ]);
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'credit'=>$memo->prepayment_total,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
                'notes'=>'Bank out',
            ]);
        }

        return redirect('/memo/prepayment');
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
    public function edit(Request $request, $id)
    {
        // $this->authorize('memo.edit');

        $memo = Memo::where('token', $id)->first();
        $memo_sent = MemoSent::where('memo_id', $memo->id)->get();

        $prepayment_no = '';
        $prepayment_total = '';
        $prepayment_subject = '';

        $url = Req::fullUrl();
        $user_app = [''=>'---'];
        $budget=0;
        $approval_path='';

        // from get response
        $bid = $request->input('branch');
        $cid = $request->input('company');
        $did = $request->input('dept');
        $duid = $request->input('dept-user');
        $eid = $request->input('category');
        $date = date('Y-m-d');
        
        if (Gate::check('memo.super')) {
            $duid = $request->input('dept-user');
            $dept_id_user = empty($duid) ? auth()->user()->department_id : $duid;
        }else{
            $dept_id_user = auth()->user()->department_id;
        }

        $dept_cat = MemoCategory::find($memo->category_id);
        $branch_id = empty($bid) ? $memo->branch_id : $bid;
        $dept_id_user = empty($duid) ? $memo->department_id : $duid;
        $company_id= empty($cid) ? $memo->company_id : $cid;
        $dept_id = empty($did) ? $dept_cat->department_id : $did;
        if ($dept_id == $dept_cat->department_id) {            
            $category_id = empty($eid) ? $memo->category_id : $eid;
        }else{
            $category_id = $eid;
        }

        if ($branch_id != 100) {
            $dept_user = [''=>'---','D6'=>'BRANCH', 'D7'=>'SERVICE SPARE PART'];
        }else{
            $dept_user = [''=>'---'] + UserDepartment::lists('name', 'id')->all();    
        }

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
                ->whereDate('inv_date1', '<=',date('Y-m-d'))
                ->whereDate('inv_date2', '>=',date('Y-m-d'))
                ->get();
        }else{
            $mp = MemoApproval::where('category_id', $category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->whereDate('inv_date1', '<=',date('Y-m-d'))
                ->whereDate('inv_date2', '>=',date('Y-m-d'))
                ->get();
        }

        if($mp->count() > 0){
            foreach ($mp as $mp_null) {
                $approval = explode("+",$mp_null->approval_path);
                $branch_choice = substr($approval[0], 0, 1);
                if ($branch_choice == 'H') {
                    $getUser = $this->getApproval($approval[0],$approval);
                }else{
                    $getUser = $this->getApproval($approval[0],$approval, $branch_id);
                }
                
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
            if (auth()->user()->can('memo.super')) {
                $mps = MemoApproval::where('category_id', $category_id)
                    ->where('branch_id', $branch_id)
                    ->where('budget', false)
                    ->get();
            }else{
                $mps = MemoApproval::where('category_id', $category_id)
                    ->where('branch_id', $branch_id)
                    ->where('user_approval', auth()->user()->position_id)
                    ->where('budget', false)
                    ->get();
            }

            if ($mps->count() > 0) {
                foreach ($mps as $mp_null) {
                    $approval = explode("+",$mp_null->approval_path);
                    $branch_choice = substr($approval[0], 0,1);
                    if ($branch_choice == 'H') {
                        $getUser = $this->getApproval($approval[0],$approval);
                    }else{
                        $getUser = $this->getApproval($approval[0],$approval, $branch_id);
                    }
                    foreach ($getUser as $gu) {
                        $user_app = [$gu->id=>$gu->name];
                    }
                    $budget += $mp_null->budget_total;
                    $approval_path = $mp_null->approval_path;
                }
            }   
        }

        return view('memo.prepayment.edit', compact('memo','memo_sent','url','company','company_id','branch','branch_id','dept_id_user','dept_user','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo','prepayment_total','prepayment_subject','prepayment_no'));
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
        
        $validator = Validator::make($request->all(), [
            'subject_memo'=>'required',
            'approval_memo'=>'required',
            'to_memo'=>'required',
            'category_id'=>'required',
            'department_id_approval'=>'required',
            'department_id'=>'required',
            'prepayment_total'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->except(['group_leasing','sub_total_finance','notes','total','notes_memo']));
        }

        if ($request->input('budget')) {
            $getBudget = intval(str_replace(',','',$request->input('budget')));
            $getTotal = intval(str_replace(',','',$request->input('prepayment_total')));

            if ($getTotal > $getBudget) {
                return redirect()
                       ->back()
                       ->withErrors([
                        'budget'=>'Your budget get to the limit',
                        'prepayment_total'=>'Change your request'
                        ])
                       ->withInput($request->except(['group_leasing','sub_total_finance','notes','total','notes_memo']));
            }
        }

        $user_memo = User::where('id', auth()->user()->id)->first();

        $memo = Memo::where('token', $id)->first();
        $memo->company_id = $request->company_id;
        $memo->branch_id = $request->branch_id;
        $memo->department_id = $request->department_id;
        $memo->category_id = $request->category_id;
        $memo->to_memo = $request->to_memo;
        $memo->approval_memo = $request->approval_memo;

        $subject = substr($request->subject_memo, 5,-1);
        if ($subject == 'REVISE') {
            $subject_fix = str_replace(' (REVISE)','','tes (REVISE)');
            $memo->subject_memo = $memo->subject_memo. " (REVISE)";
        }else{
            $memo->subject_memo = $memo->subject_memo. " (REVISE)";
        }
        
        $memo->prepayment_total = $request->prepayment_total;
        $memo->supplier_type = $request->supplier_type;
        $memo->supplier_id = $request->supplier_id;
        $memo->notes_memo = $request->notes_memo;

        $memo->status_memo = 'ON PROCESS PREPAYMENT (REVISE)';
        $memo->prepayment_total = intval(str_replace(',','',$request->input('prepayment_total')));
        $memo->from_memo= auth()->user()->id;
        $memo->save();

        // update on MemoSent
        $this->history($memo);

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
            'credit'=>$memo->prepayment_total,
            'branch_id'=>$request->input('branch_id'),
            'category_id'=>$request->input('category_id'),
            'department_id'=>$memo->department_id,
            'memo_finish'=>false,
        ]);

        return redirect('/memo/prepayment');
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

    public function getApproval($approval, $approval_path, $branch=100)
    {
        $this->authorize('memo.open');

        if ($approval == auth()->user()->position_id) {
            $search = array_search(auth()->user()->position_id, $approval_path);
            $key = $search + 1;

            $user = User::where('position_id', $approval_path[$key])->get();
        }else{
            if ($branch == 100) {
                $user = User::where('position_id', $approval)->get();
            }else{
                $user = User::where('position_id', $approval)
                            ->where('branch_id', $branch)
                            ->get();
            }
        }

        return $user;
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

    private function history($memo){
        $memoSent = MemoSent::create([
            'memo_id' => $memo->id,
            'no_memo' => $memo->no_memo,
            'category_id' => $memo->category_id,
            'to_memo' => $memo->to_memo,
            'from_memo' => $memo->from_memo,
            'approval_memo' => $memo->approval_memo,
            'subject_memo' => $memo->subject_memo,
            'last_approval_memo' => $memo->last_approval_memo,
            'last_revise_memo' => $memo->last_revise_memo,
            'total_memo' => $memo->total_memo,
            'notes_memo' => $memo->notes_memo,
            'branch_id' => $memo->branch_id,
            'status_memo' => $memo->status_memo,
            'supplier_id' => $memo->supplier_id,
            'company_id' => $memo->company_id,
            'department_id' => $memo->department_id,
            'prepayment_finish' => $memo->prepayment_finish,
            'prepayment_total' => $memo->prepayment_total
        ]);
    }
}