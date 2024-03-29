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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request as Req;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MemoController extends Controller
{
    public function __construct()
    {
        $this->middleware('memo.revise')->only('edit','update');

        $this->middleware('memo.open')->only('show');
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
                    ->where('prepayment_total','=',0)
                    ->orderBy('created_at', 'desc')
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
        $prepayment = Memo::where('token', $request->input('prepayment'))->first();

        // from get response
        if ($prepayment) {
            $did = MemoCategory::where('id', $prepayment->category_id)->first()->department_id;
            $eid = $prepayment->category_id;
            $prepayment_no = $prepayment->no_memo;
            $prepayment_total = $prepayment->prepayment_total;
            $prepayment_subject = $prepayment->subject_memo;
        }else{
            $did = $request->input('dept');
            $eid = $request->input('category');
            $prepayment_no = '';
            $prepayment_total = '';
            $prepayment_subject = '';
        }

        $bid = $request->input('branch');
        $cid = $request->input('company');
        $duid = $request->input('dept-user');
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

        return view('memo.create', compact('url','company','company_id','branch','branch_id','dept_user','dept_id_user','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo','prepayment_total','prepayment_no','prepayment_subject'));
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
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo','all_total_detail']));
        }

        if ($request->input('memo_no') == Memo::ofMaxno($request->input('branch_id'), $request->input('company_id'), $request->input('department_id'))) {
            $no_memo = $request->input('memo_no');
        }else{
            return redirect()
            ->back()
            ->withErrors(['no_memo'=>'required no memo'])
            ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
        }

        // $user_memo = User::where('id', auth()->user()->id)->first();

        // if ($request->input('branch_id') != 100) {
        //     if ($user_memo->department_id != 'D6') {
        //         $department_id = 'D7'; //AHASS
        //     }else{
        //         $department_id = 'D6'; // H1
        //     }
        // }else{
        //     $department_id = $user_memo->department_id;
        // }

        $memoPrepayment = Memo::where('no_memo', $request->prepayment_no)->first();
        
        if ($memoPrepayment) {
            if ($memoPrepayment->prepayment_no != null) {
                return redirect()
                ->back()
                ->withErrors(['no_memo'=>'prepayment has been created'])
                ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }

            $total_memo_check = 0;
            foreach($request->input('date_detail') as $key=>$val)
            {
                $total_memo_check = $total_memo_check + intval(str_replace(',','',$request->input('sub_total_memo')[$key]));
            }

            $transaction = $memoPrepayment->prepayment_total - $total_memo_check;
            
            if ($transaction < 0) {
                return redirect()
                ->back()
                ->withErrors(['prepayment_total'=>'Check your budget prepayment'])
                ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }
        }else{
            if ($request->input('budget')) {
                $getBudget = intval(str_replace(',','',$request->input('budget')));
                $getTotal = intval(str_replace(',','',$request->input('all_total_detail')));

                if ($getTotal > $getBudget) {
                    return redirect()
                    ->back()
                    ->withErrors(['budget'=>'Your budget get to the limit'])
                    ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
                }
            }
        }

        $memo = Memo::create([
            'no_memo' => $no_memo,
            'category_id' => $request->category_id,
            'to_memo' => $request->input('to_memo'),
            'from_memo' => auth()->user()->id,
            'approval_memo' => $request->approval_memo,
            'subject_memo' => $request->subject_memo,
            // 'last_approval_memo' => $request->,
            // 'last_revise_memo',
            'notes_memo' => $request->notes_memo,
            'branch_id' => $request->branch_id,
            'status_memo' => 'ON PROCESS',
            'supplier_id' => $request->supplier_id,
            'company_id' => $request->company_id,
            'department_id' => $request->input('department_id'),
            'token' => md5(uniqid($no_memo, true)),
            'supplier_type'=> $request->supplier_type,
        ]);

        // $detail = [];
        $total_memo = 0;
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
            $total_memo = $total_memo + ($request->input('qty')[$key] * intval(str_replace(',','',$request->input('sub_total_memo')[$key])));
            if($val !='')
            {
                MemoDetail::create($detail);
            }
        }

        // save all memo
        $memo->total_memo = $total_memo;
        if($request->prepayment_no){
            $memo->prepayment_no = $memoPrepayment->no_memo;
            $memoPrepayment->prepayment_no = $memo->no_memo;
            $memoPrepayment->save();
        }
        
        $memo->save();

        $memoSent = MemoSent::create([
            'memo_id'=>$memo->id,
            'no_memo'=>$memo->no_memo,
            'status_memo' => 'ON PROCESS',
            'total_memo' => intval(str_replace(',','',$request->input('all_total_detail'))),
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

        if ($memoPrepayment) {
            $transaction = $memoPrepayment->prepayment_total - $total_memo;
            if ($transaction < 0) {
                return redirect()
                    ->back()
                    ->withErrors(['prepayment_total'=>'Check your budget prepayment'])
                    ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }elseif ($transaction > 0) {
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$transaction,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Bank In'
                ]);
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$total_memo,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Biaya'
                ]);
                if ($request->input('budget')) {
                    MemoTransaction::create([
                        'user_id'=>$memo->from_memo,
                        'memo_id'=>$memo->id,
                        'credit'=>$total_memo,
                        'branch_id'=>$request->input('branch_id'),
                        'category_id'=>$request->input('category_id'),
                        'department_id'=>$memo->department_id,
                        'memo_finish'=>false,
                        'notes'=>'Piutang'
                    ]);
                }else{
                    MemoTransaction::create([
                        'user_id'=>$memo->from_memo,
                        'memo_id'=>$memo->id,
                        'credit'=>$memoPrepayment->prepayment_total,
                        'branch_id'=>$request->input('branch_id'),
                        'category_id'=>$request->input('category_id'),
                        'department_id'=>$memo->department_id,
                        'memo_finish'=>false,
                        'notes'=>'Piutang'
                    ]);
                }
            }else{
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$memoPrepayment->prepayment_total,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Piutang'
                ]);
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'credit'=>$total_memo,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Biaya'
                ]);
            }
        }else{
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'debet'=>$total_memo,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
            ]);
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'credit'=>$total_memo,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
            ]);
        }

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
            $user_app = $this->getApproval($approval_path[$key], $approval_path);
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
        $memo_prepayment = '';
        if ($memo->prepayment_no) {
            $memo_prepayment = Memo::where('prepayment_no', $memo->no_memo)->first();

            $remaining = $memo_prepayment->prepayment_total - $memo->total_memo;
        }

        return view('memo.show', compact('memo','memo_sent','company','branch','depts','position','category','supplier','leasing','user_app','memo_prepayment','remaining'));
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
        
        if ($memo->prepayment_no) {
            $memo_prepayment = Memo::where('no_memo', $memo->prepayment_no)->first();
        }else{
            $memo_prepayment = '';
        }
        
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
        $category_id = empty($eid) ? $memo->category_id : $eid;

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

        return view('memo.edit', compact('memo','memo_sent','url','company','company_id','branch','branch_id','dept_id_user','dept_user','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo','memo_prepayment'));
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
            'memo_no' => 'required',
            'subject_memo'=>'required',
            'approval_memo'=>'required',
            'to_memo'=>'required',
            'category_id'=>'required',
            'department_id_approval'=>'required',
            'department_id'=>'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            return redirect()
                        ->back()
                        ->withErrors($validator)
                        ->withInput($request->except(['date_detail','id_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
        }

        $memoPrepayment = Memo::where('no_memo', $request->prepayment_no)->first();

        if ($memoPrepayment) {
            if ($memoPrepayment->prepayment_no != null) {
                return redirect()
                ->back()
                ->withErrors(['no_memo'=>'prepayment has been created'])
                ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }
            
            $total_memo_check = 0;
            foreach($request->input('date_detail') as $key=>$val)
            {
                $total_memo_check = $total_memo_check + intval(str_replace(',','',$request->input('sub_total_memo')[$key]));
            }
            
            $transaction = $memoPrepayment->prepayment_total - $total_memo_check;
            
            if ($transaction < 0) {
                return redirect()
                ->back()
                ->withErrors(['prepayment_total'=>'Check your budget prepayment'])
                ->withInput($request->except(['date_detail','id_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }
        }else{
            if ($request->input('budget')) {
                $getBudget = intval(str_replace(',','',$request->input('budget')));
                $getTotal = intval(str_replace(',','',$request->input('all_total_detail')));

                if ($getTotal > $getBudget) {
                    return redirect()
                    ->back()
                    ->withErrors(['budget'=>'Your budget get to the limit'])
                    ->withInput($request->except(['date_detail','id_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
                }
            }
        }

        $memo = Memo::where('token',$id)->first();
        $memo->category_id = $request->category_id;
        $memo->to_memo = $request->input('to_memo');
        $memo->from_memo = auth()->user()->id;
        $memo->approval_memo = $request->approval_memo;
        $memo->subject_memo = $request->subject_memo;
        // 'last_approval_memo' => $request->,
        // 'last_revise_memo',
        $memo->notes_memo = $request->notes_memo;
        $memo->branch_id = $request->branch_id;
        $memo->status_memo = 'ON PROCESS (REVISE)';
        $memo->supplier_id = $request->supplier_id;
        $memo->company_id = $request->company_id;
        $memo->department_id = $request->input('department_id');
        $memo->token = md5(uniqid($memo->no_memo, true));
        $memo->supplier_type = $request->supplier_type;
        // $memo->prepayment_no = $memoPrepayment->no_memo;
        $memo->save();

        

        $memoSent = MemoSent::create([
            'memo_id'=>$memo->id,
            'no_memo'=>$memo->no_memo,
            'subject_memo'=>$memo->subject_memo. " (REVISE)",
            'status_memo' => 'ON PROCESS (REVISE)',
            'total_memo' => intval(str_replace(',','',$request->input('all_total_detail'))),
            'department_id' => $memo->department_id,
        ]);

        $memoSent->update($request->all());

        $total_memo = 0;
        if (empty($request->input('id_detail'))) {
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
                $total_memo = $total_memo + intval(str_replace(',','',$request->input('sub_total_memo')[$key]));
                if($val !='')
                {
                    MemoDetail::create($detail);
                }
            }
        }else{
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
                $total_memo = $total_memo + intval(str_replace(',','',$request->input('sub_total_memo')[$key]));
            }
        }

        // save all memo
        $memo->total_memo = $total_memo;
        $memo->save();

        // $memoPrepayment->prepayment_no = $memo->no_memo;
        // $memoPrepayment->save();

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

        // MemoTransaction::create([
        //     'user_id'=>$memo->from_memo,
        //     'memo_id'=>$memo->id,
        //     'credit'=>$memo->total_memo,
        //     'branch_id'=>$request->input('branch_id'),
        //     'category_id'=>$request->input('category_id'),
        //     'department_id'=>$memo->department_id,
        //     'memo_finish'=>false,
        // ]);

        if ($memoPrepayment) {
            $transaction = $memoPrepayment->prepayment_total - $total_memo;
            if ($transaction < 0) {
                return redirect()
                    ->back()
                    ->withErrors(['prepayment_total'=>'Check your budget prepayment'])
                    ->withInput($request->except(['date_detail','description','qty','sub_total_memo','subtotal','group_leasing','sub_total_finance','notes','total','notes_memo']));
            }elseif ($transaction > 0) {
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$transaction,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Bank In'
                ]);
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$total_memo,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Biaya'
                ]);
                if ($request->input('budget')) {
                    MemoTransaction::create([
                        'user_id'=>$memo->from_memo,
                        'memo_id'=>$memo->id,
                        'credit'=>$total_memo,
                        'branch_id'=>$request->input('branch_id'),
                        'category_id'=>$request->input('category_id'),
                        'department_id'=>$memo->department_id,
                        'memo_finish'=>false,
                        'notes'=>'Piutang'
                    ]);
                }else{
                    MemoTransaction::create([
                        'user_id'=>$memo->from_memo,
                        'memo_id'=>$memo->id,
                        'credit'=>$memoPrepayment->prepayment_total,
                        'branch_id'=>$request->input('branch_id'),
                        'category_id'=>$request->input('category_id'),
                        'department_id'=>$memo->department_id,
                        'memo_finish'=>false,
                        'notes'=>'Piutang'
                    ]);
                }
            }else{
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'debet'=>$memoPrepayment->prepayment_total,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Piutang'
                ]);
                MemoTransaction::create([
                    'user_id'=>$memo->from_memo,
                    'memo_id'=>$memo->id,
                    'credit'=>$total_memo,
                    'branch_id'=>$request->input('branch_id'),
                    'category_id'=>$request->input('category_id'),
                    'department_id'=>$memo->department_id,
                    'memo_finish'=>false,
                    'notes'=>'Biaya'
                ]);
            }
        }else{
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'debet'=>$total_memo,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
            ]);
            MemoTransaction::create([
                'user_id'=>$memo->from_memo,
                'memo_id'=>$memo->id,
                'credit'=>$total_memo,
                'branch_id'=>$request->input('branch_id'),
                'category_id'=>$request->input('category_id'),
                'department_id'=>$memo->department_id,
                'memo_finish'=>false,
            ]);
        }
        return redirect('/memo')->with('success', 'Successfully Revise Memo');
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

    public function deleteDetail($id)
    {
        $detail = MemoDetail::find($id);
        $detail->delete();

        if(!$detail){
            return response()->json([ 
                'error'=> true,
                'message' => 'Server error while deleting Detail',
                'code' => 500
            ], 500);
        }else{
            return response()->json([
                'error' => false,
                'message' => 'Success delete Detail',
                'code' => 200
            ], 200);
        }
    }

    public function deleteFinance($id)
    {
        $finance = MemoFinanceSupport::find($id);
        $finance->delete();

        if (!$finance) {
            return response()->json([
                'error' => true,
                'message' => 'Server error while deleting Finance Support',
                'code' => 500
            ], 500);
        }else{
            return response()->json([
                'error' => false,
                'message' => 'Success delete Finance',
                'code'=> 200
            ],200);
        }
    }
    public function administrator(Request $request)
    {
        $branch_id = empty($request->input('branch')) ? 0 : $request->input('branch');
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

        $branch = Branch::lists('name','name')->all();

        if ($branch_id!=0) {
            $memos = Memo::where('branch_id', $branch_id)
                        ->whereDate('created_at', '>=', $begin)
                        ->whereDate('created_at','<=', $end)
                        ->get();
        }else
        {
            $memos = Memo::whereDate('created_at', '>=', $begin)
                    ->whereDate('created_at','<=', $end)
                    ->get();
        }

        return view('memo.administrator', compact('memos', 'branch_id', 'branch','begin','end'));
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
//            if ($branch_id=='100') {
                $supp = User::where('job_status', 'Active')
                            ->lists('name', 'id')
                            ->all();
//            }else{
//                $supp = User::where('branch_id', $branch_id)
//                            ->where('job_status', 'Active')
//                            ->lists('name', 'id')
//                            ->all();
//            }
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
