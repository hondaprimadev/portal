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
use App\MemoTransaction;
use App\Supplier;
use App\User;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;

class MemoProcessController extends Controller
{
	/**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('memo.approve')->only('process');
    }

    public function process($id)
    {
    	$memo = Memo::findOrFail($id);
        $memo_sent = MemoSent::where('memo_id', $memo->id)->get();

        $company = Company::where('id',$memo->company_id)->lists('name', 'id')->all();

        $branch = Branch::where('id',$memo->branch_id)->lists('name', 'id')->all();
        $branch_id = Branch::where('company_id', $memo->company_id)->first()->id;
        
        $cat_id = MemoCategory::where('id', $memo->category_id)->first();
        $depts = UserDepartment::where('id', $cat_id->department_id)->lists('name', 'id')->all();
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
            $user_app = ['0'=>'FINISH'];
        }

        $mp = MemoApproval::where('category_id', $memo->category_id)
                ->where('branch_id', $branch_id)
                ->where('user_approval', auth()->user()->position_id)
                ->where('budget', true)
                ->get();

        return view('memo.inbox.process', compact('memo','memo_sent','company','branch','depts','position','category','supplier','leasing','user_app'));
    }

    public function all($id)
    {
            
    }

    public function approve(Request $request, $id)
    {
    	$stat = 'approve';
    	$to_memo = $request->input('to_memo');
    	$notes = $request->input('notes_memo');

        $this->getProcess($id, $stat, $to_memo, $notes);

        return redirect('memo/inbox');
    }

    public function reject(Request $request, $id)
    {
    	$stat = 'reject';
    	$to_memo = '';
    	$notes = $request->input('notes_memo');

        $this->getProcess($id, $stat, $to_memo, $notes);

        $mt = MemoTransaction::where('memo_id', $id)->first();
    	$mt->delete();

        return redirect('memo/inbox');	
    }

    public function revise(Request $request, $id)
    {
    	$stat = 'revise';
    	$to_memo = 'revise';
    	$notes = $request->input('notes_memo');

        $this->getProcess($id, $stat, $to_memo, $notes);
        
        $mt = MemoTransaction::where('memo_id', $id)->first();
    	$mt->delete();

        return redirect('memo/inbox');	
    }

    public function getApproval($approval, $branch_id)
    {
        if ($branch_id == 100) {
            $user = User::where('position_id', $approval)->get();
        }else{
            $user = User::where('position_id', $approval)
                    ->where('branch_id', $branch_id)
                    ->get();
        }

        return $user;
    }

    public function getProcess($id, $stat, $to_memo, $notes)
    {
        $user='';
        $memo = Memo::where('id', $id)->first();

        if ($memo->to_memo == auth()->user()->id) {
            if ($to_memo == 0) {
                $user = User::where('id', auth()->user()->id)->first();
            }else{
                $user = User::where('id', $memo->to_memo)->first();
            }
            $status_ext = '';
        }
        else{
            $user = User::where('id', auth()->user()->id)->first();
            $status_ext = '(System Administrator)';
        }
        
        if ($stat == 'approve') {
        	if ($user->position_id == 'H1') {
	            $status = 'APPROVED BY '.$user->name.' '.$status_ext;
	        }
	        elseif ($user->position_id == 'H4FI') {
	            $status = 'FINISHED BY '.$user->name.' '.$status_ext;
                
                $mt = MemoTransaction::where('memo_id', $memo->id)->first();
                $mt->memo_finish = true;
                $mt->save();
	        }
	        else{
	            $status = 'ON PROCESS BY '.$user->name.' '.$status_ext;
	        }	
        }elseif ($stat == 'revise') {
        	$status = 'REVISE BY '.$user->name.' '.$status_ext;
            $to_memo = $memo->from_memo;
        }elseif ($stat == 'reject'){
        	$status = 'REJECT BY '.$user->name.' '.$status_ext;
            $to_memo = '';
        }

        $ms = MemoSent::create([
            "memo_id"=> $memo->id,
            "no_memo"=>$memo->no_memo,
            "category_id"=>$memo->category_id,
            "to_memo"=> $to_memo,
            "from_memo"=> $memo->from_memo,
            "approval_memo"=> $memo->approval_memo,
            "subject_memo"=> $memo->subject_memo,
            "last_approval_memo"=> ($stat=='revise') ? '':$user->id,
            "last_revise_memo"=> ($stat=='revise') ? $user->id:'',
            "total_memo"=> $memo->total_memo,
            "notes_memo"=> $notes,
            "status_memo"=> $status,
            "supplier_id"=> $memo->supplier_id,
            "branch_id"=> $memo->branch_id,
            "company_id"=>$memo->company_id,
            "department_id"=> $memo->department_id,
            "prepayment_finish"=> $memo->prepayment_finish,
            "prepayment_total"=>$memo->prepayment_total,
        ]);

        $memo->to_memo = $to_memo;
        $memo->last_approval_memo = $user->id;
        $memo->status_memo = $status;
        $memo->notes_memo = $notes;
        $memo->save();

        return redirect('/memo/inbox');
    }
}
