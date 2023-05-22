<?php
namespace App\Services;

use App\MemoTransaction;
use App\Supplier;
use App\User;
use Illuminate\Support\Facades\Request;
use DB;

class MemoManager{
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

    public function getSupplier(Request $request)
    {
        $id = $request->input('id');
        return Supplier::with('bank')->find($id);
    }

    public function getSaldo($branch, $category, $date1, $date2)
    {
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