<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Company;
use App\Http\Requests;
use App\LeasingGroup;
use App\MemoApproval;
use App\MemoCategory;
use App\Services\MemoManager;
use App\Supplier;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;

class MemoPrepaymentController extends Controller
{
    protected $manager;

    public function __construct(MemoManager $manager)
    {
        $this->manager = $manager;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        $apps = MemoApproval::where('prepayment', true)->get();
        $category =[];
        foreach ($apps as $app) {
            $category += MemoCategory::where('department_id', $dept_id)
                            ->where('id', $app->category_id)
                            ->lists('name', 'id')
                            ->all();
        }
        $category = [''=>'---'] + $category;

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
                $getUser = $this->manager->getApproval($approval[0], $branch_id);
                foreach ($getUser as $gu) {
                    $user_app = [$gu->id=>$gu->name];
                }
                $budget += $mp_null->budget_total;
                $approval_path = $mp_null->approval_path;
                $saldo = $this->manager->getSaldo(
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
                    $getUser = $this->manager->getApproval($approval[0], $branch_id);
                    foreach ($getUser as $gu) {
                        $user_app = [$gu->id=>$gu->name];
                    }
                    $budget += $mp_null->budget_total;
                    $approval_path = $mp_null->approval_path;
                }
            }   
        }

        return view('memo.prepayment.create', compact('company','company_id','branch','branch_id','depts','dept_id','position','category','category_id','user_app','budget','supplier','leasing','approval_path','saldo'));
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
