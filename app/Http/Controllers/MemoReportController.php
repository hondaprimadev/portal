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
            $now = date('Y-m-');
            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $begin = new \DateTime($now.'01');
            $end = new \DateTime($now.$d1);
        }else{
            $begin = new \DateTime($begin);
            $end = new \DateTime($end);
        }

        $branch = [''=>'--Branch--'] + Branch::lists('name', 'id')->all();
        if ($branch_id) {
            $memo = Memo::where('to_memo', 0)
            ->where('status_memo','LIKE', '%FINISH%')
            ->where('branch_id', $branch_id)
            ->whereDate('created_at', '>=', $begin)
            ->whereDate('created_at','<=', $end)
            ->orderBy('updated_at', 'desc')
            ->get();
        }else{
            $memo = Memo::where('to_memo', 0)
            ->where('status_memo','LIKE', '%FINISH%')
            ->whereDate('created_at', '>=', $begin)
            ->whereDate('created_at','<=', $end)
            ->orderBy('updated_at', 'desc')
            ->get();
        }
    	

    	return view('memo.report.index',compact('memo', 'begin','end','branch','branch_id'));
    }

    public function getPrint($id)
    {
    	$memo = Memo::where('token',$id)->first();

    	$mc = MemoCategory::where('id', $memo->category_id)->first();

		$pdf = PDF::loadView('memo.report.print', compact('memo','mc'));
		return $pdf->stream($memo->no_memo.'.pdf');
    }
}
