<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests;
use App\User;
use App\VehicleSales;
use DB;
use Illuminate\Http\Request;

class MarketingReportController extends Controller
{
    public function getReport(Request $request)
    {
    	if(!$request->input('begin') && !$request->input('end'))
        {
            $now = date('Y-m-');
            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $begin = new \DateTime($now.'01');
            $end = new \DateTime($now.$d1);
        }else{
            $begin = new \DateTime($request->input('begin'));
            $end = new \DateTime($request->input('end'));
        }

        $ends = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$ends);

        $end = $end->modify('-1 day');

        $first_day_last_month = date('Y-m-d', strtotime($begin->format('Y-m-d')."-1 month"));
        $tahun_m1 = date("Y", strtotime($first_day_last_month));
        $bulan_m1 = date("m", strtotime($first_day_last_month));
        $day_m1 = cal_days_in_month(CAL_GREGORIAN, $bulan_m1, $tahun_m1);
        $last_day_last_month = date($tahun_m1."-".$bulan_m1."-".$day_m1);

        //PAR chart
        $vs = VehicleSales::OfSales($begin->format('Y-m-d'), $end->format('Y-m-d'), '1')->get();
        $vs_m1 = VehicleSales::OfSales($first_day_last_month, $last_day_last_month, '1')->get();
        $vs_total = VehicleSales::OfTotalCompany($begin->format('Y-m'),'1')->count();
        $vs_total_m1 = VehicleSales::OfTotalCompany(date($tahun_m1."-".$bulan_m1),'1')->count();

        //PMA chart
        $vspma = VehicleSales::OfSales($begin->format('Y-m-d'), $end->format('Y-m-d'), '2')->get();
        $vspma_m1 = VehicleSales::OfSales($first_day_last_month, $last_day_last_month, '2')->get();
        $vspma_total = VehicleSales::OfTotalCompany($begin->format('Y-m'),'2')->count();
        $vspma_total_m1 = VehicleSales::OfTotalCompany(date($tahun_m1."-".$bulan_m1),'2')->count();

        // Table
        $tableSales = VehicleSales::OfTableAll($begin->format('Y-m'), $tahun_m1, $bulan_m1)->get();

        return view('marketing.report.index', compact(
        	'branches', 
        	'daterange',
        	'vs',
        	'vs_m1',
        	'vs_total',
        	'vs_total_m1',
        	'vspma',
        	'vspma_m1',
        	'vspma_total',
			'vspma_total_m1',
        	'begin', 
        	'end',
        	'tableSales'));
    }

    public function getBranchReport(Request $request)
    {
    	$branch = $request->input('b');
    	$begin = $request->input('begin');
    	$end  =$request->input('end');

    	$branches = Branch::where('name', ucfirst($branch))->first();
    	if ($branches==false) {
    		abort(403, 'Unauthorized action.');
    	}
    	else{
    		$branch_id = $branches->id;
    		$company_id = $branches->company_id;
    		$company_alias = $branches->company->alias;
    	}
    	
    	// validation get request
    	if (!$branch) {
    		abort(403, 'Unauthorized action.');
    	}
    	else{
    		if(!$request->input('begin') && !$request->input('end'))
        	{
	            $now = date('Y-m-');
	            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
	            $begin = new \DateTime($now.'01');
	            $end = new \DateTime($now.$d1);
        	}else{
            	$begin = new \DateTime($request->input('begin'));
            	$end = new \DateTime($request->input('end'));
        	}
    	}

    	$ends = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$ends);

        $end = $end->modify('-1 day');

        $first_day_last_month = date('Y-m-d', strtotime($begin->format('Y-m-d')."-1 month"));
        $tahun_m1 = date("Y", strtotime($first_day_last_month));
        $bulan_m1 = date("m", strtotime($first_day_last_month));
        $day_m1 = cal_days_in_month(CAL_GREGORIAN, $bulan_m1, $tahun_m1);
        $last_day_last_month = date($tahun_m1."-".$bulan_m1."-".$day_m1);
        $begin_m1 = new \DateTime($first_day_last_month);
        $end_m1 = new \DateTime($last_day_last_month);
        $daterange_m1 = new \DatePeriod($begin_m1, $interval, $end_m1->modify('+1 day'));
        $end_m1 = $end_m1->modify('-1 day');

        // Table Branch
        $vs = VehicleSales::OfSalesBranch($begin->format('Y-m-d'), $end->format('Y-m-d'), $branch_id)->get();
        $vs_total = VehicleSales::OfTotalBranch($begin->format('Y-m'), $branch_id)->count();
        $vs_m1 = VehicleSales::OfSalesBranch($first_day_last_month, $last_day_last_month, $branch_id)->get();
        $vs_total_m1 = VehicleSales::OfTotalBranch(date($tahun_m1."-".$bulan_m1),$branch_id)->count();

        // Company
        $vs_total_par = VehicleSales::OfTotalCompany($begin->format('Y-m'),'1')->count();
        $vs_total_par_m1 = VehicleSales::OfTotalCompany(date($tahun_m1."-".$bulan_m1),'1')->count();

        // Table
        $tableSales = VehicleSales::OfTableBranch($begin->format('Y-m'), $tahun_m1, $bulan_m1, $branch_id)->get();
        // return $tableSales;
        return view('marketing.report.branch.index', compact(
        	'branch',
        	'company_alias',
        	'daterange',
        	'daterange_m1',
        	'begin',
        	'end',
        	'vs', 
        	'vs_total',
        	'begin_m1',
        	'end_m1',
        	'vs_m1',
        	'vs_total_m1',
        	'vs_total_par',
        	'vs_total_par_m1',
        	'tableSales'
        	));

    }
    public function getSpvReport(Request $request)
    {
    	$spv = $request->input('s');
    	$begin = $request->input('begin');
    	$end  =$request->input('end');

    	$picid = User::where('id', $spv)->first();
    	if ($picid==false) {
    		abort(403, 'Unauthorized action.');
    	}
    	else{
    		$pic_id = $picid->id;
    		$branch_id = $picid->branch_id;
    		$branch_name = $picid->branch->name;
    		$pic_name = $picid->name;
    	}

    	// validation get request
    	if (!$spv) {
    		abort(403, 'Unauthorized action.');
    	}
    	else{
    		if(!$request->input('begin') && !$request->input('end'))
        	{
	            $now = date('Y-m-');
	            $d1 = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
	            $begin = new \DateTime($now.'01');
	            $end = new \DateTime($now.$d1);
        	}else{
            	$begin = new \DateTime($request->input('begin'));
            	$end = new \DateTime($request->input('end'));
        	}
    	}

    	$ends = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$ends);

        $end = $end->modify('-1 day');

        $first_day_last_month = date('Y-m-d', strtotime($begin->format('Y-m-d')."-1 month"));
        $tahun_m1 = date("Y", strtotime($first_day_last_month));
        $bulan_m1 = date("m", strtotime($first_day_last_month));
        $day_m1 = cal_days_in_month(CAL_GREGORIAN, $bulan_m1, $tahun_m1);
        $last_day_last_month = date($tahun_m1."-".$bulan_m1."-".$day_m1);
        $begin_m1 = new \DateTime($first_day_last_month);
        $end_m1 = new \DateTime($last_day_last_month);
        $daterange_m1 = new \DatePeriod($begin_m1, $interval, $end_m1->modify('+1 day'));
        $end_m1 = $end_m1->modify('-1 day');

        // Table PIC
        $vs = VehicleSales::OfSalesPic($begin->format('Y-m-d'), $end->format('Y-m-d'), $pic_id)->get();
        $vs_total = VehicleSales::OfTotalPic($begin->format('Y-m'), $pic_id)->count();
        $vs_m1 = VehicleSales::OfSalesPic($first_day_last_month, $last_day_last_month, $pic_id)->get();
        $vs_total_m1 = VehicleSales::OfTotalPic(date($tahun_m1."-".$bulan_m1),$pic_id)->count();

        // Branch
        $vs_total_branch = VehicleSales::OfTotalBranch($begin->format('Y-m'),$branch_id)->count();
        $vs_total_branch_m1 = VehicleSales::OfTotalBranch(date($tahun_m1."-".$bulan_m1),$branch_id)->count();

        // Table
        $tableSales = VehicleSales::OfTablePic($begin->format('Y-m'), $tahun_m1, $bulan_m1, $pic_id)->get();
        // return $tableSales;
        return view('marketing.report.spv.index', compact(
        	'spv',
        	'branch_name',
        	'pic_name',
        	'daterange',
        	'daterange_m1',
        	'begin',
        	'end',
        	'vs', 
        	'vs_total',
        	'begin_m1',
        	'end_m1',
        	'vs_m1',
        	'vs_total_m1',
        	'vs_total_branch',
        	'vs_total_branch_m1',
        	'tableSales'
        	));

    }
}
