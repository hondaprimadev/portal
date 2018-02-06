<?php

namespace App\Http\Controllers;

use App;
use App\Branch;
use App\Http\Requests;
use App\Memo;
use App\MemoCategory;
use Illuminate\Http\Request;
use PDF;

class MemoReportController extends Controller
{
    
    public function index(Request $request)
    {
        $branch_id = $request->input('branch') ? $request->input('branch'): '';

    	$begin = $request->input('begin');
        $end = $request->input('end');

        if(!$begin && !$end)
        {
            $now = date('Y-m-d');
            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $begin = new \DateTime($now);
            $end = new \DateTime($now);
        }else{
            $begin = new \DateTime($begin);
            $end = new \DateTime($end);
        }

        $branch = [''=>'--Branch--'] + Branch::lists('name', 'id')->all();

        if ($branch_id) {
            $memo = Memo::where('to_memo', 0)
            ->where('status_memo','LIKE', '%FINISHED%')
            ->where('branch_id', $branch_id)
            ->whereDate('updated_at', '>=', $begin)
            ->whereDate('updated_at','<=', $end)
            ->orderBy('updated_at', 'desc')
            ->get();
        }else{
            $memo = Memo::where('to_memo', 0)
            ->where('status_memo','LIKE', '%FINISHED%')
            ->whereDate('updated_at', '>=', $begin)
            ->whereDate('updated_at','<=', $end)
            ->orderBy('updated_at', 'desc')
            ->get();
        }

    	return view('memo.report.index',compact('memo', 'begin','end','branch','branch_id'));
    }

    public function getPrint($id)
    {
    	$memo = Memo::where('token',$id)->first();

    	$mc = MemoCategory::where('id', $memo->category_id)->first();

        if ($memo->prepayment_total > 0){
            $pdf = PDF::loadView('memo.report.prepayment', compact('memo','mc'));
        }else{
            $pdf = PDF::loadView('memo.report.print', compact('memo','mc'));
        }
		return $pdf->stream($memo->no_memo.'.pdf');
    }
}
