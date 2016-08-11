<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class VehicleSales extends Model
{
    protected $fillable = ['no_faktur', 'faktur_date','faktur_note','sales_type','nomor_crm','vehicletype_id','stock_nama','stock_warna','stock_tahun','stock_nomesin','stock_norangka','branch_id','company_id','user_id','position_id','price_otr','price_dp','price_disc','price_bbn','leasing_id','leasing_group','pic_id','active'];

    public function crm()
    {
        return $this->belongsTo('App\Crm','nomor_crm','nomor_crm');
    }
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function scopeOfSales($query, $begin, $end, $c)
    {
         $query->select('calendars.datefield as DATE',DB::raw('IFNULL(SUM(CASE WHEN company_id='.$c.' THEN active ELSE 0 END),0) as total_sales'), 'company_id')
                ->rightJoin('calendars', 'vehicle_sales.faktur_date', '=', 'calendars.datefield')
                ->whereBetween('calendars.datefield', [$begin, $end])
                ->groupBy('DATE');
    }
    public function scopeOfSalesBranch($query, $begin, $end, $b)
    {
         $query->select('calendars.datefield as DATE',DB::raw('IFNULL(SUM(CASE WHEN branch_id='.$b.' THEN active ELSE 0 END),0) as total_sales'), 'company_id')
                ->rightJoin('calendars', 'vehicle_sales.faktur_date', '=', 'calendars.datefield')
                ->whereBetween('calendars.datefield', [$begin, $end])
                ->groupBy('DATE');
    }
    public function scopeOfSalesPic($query, $begin, $end, $p)
    {
         $query->select('calendars.datefield as DATE',DB::raw('IFNULL(SUM(CASE WHEN pic_id='.$p.' THEN active ELSE 0 END),0) as total_sales'), 'company_id')
                ->rightJoin('calendars', 'vehicle_sales.faktur_date', '=', 'calendars.datefield')
                ->whereBetween('calendars.datefield', [$begin, $end])
                ->groupBy('DATE');
    }
    public function scopeOfSaleSales($query, $begin, $end, $p)
    {
         $query->select('calendars.datefield as DATE',DB::raw('IFNULL(SUM(CASE WHEN user_id='.$p.' THEN active ELSE 0 END),0) as total_sales'), 'company_id')
                ->rightJoin('calendars', 'vehicle_sales.faktur_date', '=', 'calendars.datefield')
                ->whereBetween('calendars.datefield', [$begin, $end])
                ->groupBy('DATE');
    }

    public function scopeOfTableAll($query, $begin, $b, $e,$tahun_m1, $bulan_m1)
    {
        $query->select(
            DB::raw('sum(case when faktur_date = "'.date('Y-m-d').'" then active else 0 end) as total_today'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_month'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$tahun_m1.'-'.$bulan_m1.'" then active else 0 end) as total_month_m1'),
            DB::raw('sum(case when position_id="B7CS" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cs'),
            DB::raw('sum(case when position_id="B7MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_marketing'),
            DB::raw('sum(case when position_id="B6MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_spv'),
            DB::raw('sum(case when position_id="B5MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_rh'),
            DB::raw('sum(case when position_id="B4" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_bm'),
            DB::raw('sum(case when vehicletype_id="J0001" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_low_end'),
            DB::raw('sum(case when vehicletype_id="J0002" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0003" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_high_end'),
            DB::raw('sum(case when vehicletype_id="J0004" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_low_end'),
            DB::raw('sum(case when vehicletype_id="J0005" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0006" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_high_end'),
            DB::raw('sum(case when vehicletype_id="J0007" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_low_end'),
            DB::raw('sum(case when vehicletype_id="J0008" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0009" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_high_end'),
            DB::raw('sum(case when vehicletype_id="J0010" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_city_sport'),
            DB::raw('sum(case when vehicletype_id="J0011" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cbu'),
            DB::raw('sum(case when sales_type="CASH" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cash'),
            DB::raw('sum(case when sales_type="CREDIT" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_credit'),
            DB::raw('sum(case when sales_type="TEMPO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_tempo'),
            DB::raw('sum(case when leasing_group="ADIRA" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_adira'),
            DB::raw('sum(case when leasing_group="CSF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_csf'),
            DB::raw('sum(case when leasing_group="FIF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_fif'),
            DB::raw('sum(case when leasing_group="OTO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_oto'),
            DB::raw('sum(case when leasing_group="WOM" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_wom'),
            DB::raw('sum(case when leasing_group="OTHER" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_other'),
            'branch_id',
            'branches.name as name_branch'
        )
        ->leftJoin('branches', 'vehicle_sales.branch_id', '=', 'branches.id')
        // ->whereBetween('faktur_date', [$b, $e])
        ->groupBy('branch_id')
        ->orderBy('total_month', 'desc');
    }
    public function scopeOfTableBranch($query, $begin, $b, $e, $tahun_m1, $bulan_m1, $b='')
    {
        $query->select(
            DB::raw('sum(case when faktur_date = "'.date('Y-m-d').'" then active else 0 end) as total_today'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_month'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$tahun_m1.'-'.$bulan_m1.'" then active else 0 end) as total_month_m1'),
            DB::raw('sum(case when vehicle_sales.position_id="B7CS" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cs'),
            DB::raw('sum(case when vehicle_sales.position_id="B7MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_marketing'),
            DB::raw('sum(case when vehicle_sales.position_id="B5MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_spv'),
            DB::raw('sum(case when vehicle_sales.position_id="B6MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_rh'),
            DB::raw('sum(case when vehicle_sales.position_id="B4" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_bm'),
            DB::raw('sum(case when vehicletype_id="J0001" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_low_end'),
            DB::raw('sum(case when vehicletype_id="J0002" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0003" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_high_end'),
            DB::raw('sum(case when vehicletype_id="J0004" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_low_end'),
            DB::raw('sum(case when vehicletype_id="J0005" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0006" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_high_end'),
            DB::raw('sum(case when vehicletype_id="J0007" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_low_end'),
            DB::raw('sum(case when vehicletype_id="J0008" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0009" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_high_end'),
            DB::raw('sum(case when vehicletype_id="J0010" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_city_sport'),
            DB::raw('sum(case when vehicletype_id="J0011" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cbu'),
            DB::raw('sum(case when vehicle_sales.sales_type="CASH" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cash'),
            DB::raw('sum(case when vehicle_sales.sales_type="CREDIT" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_credit'),
            DB::raw('sum(case when vehicle_sales.sales_type="TEMPO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_tempo'),
            DB::raw('sum(case when vehicle_sales.leasing_group="ADIRA" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_adira'),
            DB::raw('sum(case when vehicle_sales.leasing_group="CSF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_csf'),
            DB::raw('sum(case when vehicle_sales.leasing_group="FIF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_fif'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_oto'),
            DB::raw('sum(case when vehicle_sales.leasing_group="WOM" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_wom'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTHER" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_other'),
            'vehicle_sales.pic_id',
            'users.name'
        )
        ->leftJoin('users', 'vehicle_sales.pic_id', '=', 'users.id')
        ->where('vehicle_sales.branch_id', $b)
        ->whereBetween('faktur_date', [$b, $e])
        ->groupBy('vehicle_sales.pic_id')
        ->orderBy('total_month', 'desc');
    }

    public function scopeOfTablePic($query, $begin,$b,$e,$tahun_m1,$bulan_m1, $p='')
    {
        $query->select(
            DB::raw('sum(case when faktur_date = "'.date('Y-m-d').'" then active else 0 end) as total_today'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_month'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$tahun_m1.'-'.$bulan_m1.'" then active else 0 end) as total_month_m1'),
            DB::raw('sum(case when vehicle_sales.position_id="B7CS" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cs'),
            DB::raw('sum(case when vehicle_sales.position_id="B7MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_marketing'),
            DB::raw('sum(case when vehicle_sales.position_id="B5MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_spv'),
            DB::raw('sum(case when vehicle_sales.position_id="B4" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_bm'),
            DB::raw('sum(case when vehicletype_id="J0001" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_low_end'),
            DB::raw('sum(case when vehicletype_id="J0002" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0003" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cub_high_end'),
            DB::raw('sum(case when vehicletype_id="J0004" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_low_end'),
            DB::raw('sum(case when vehicletype_id="J0005" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0006" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_at_high_end'),
            DB::raw('sum(case when vehicletype_id="J0007" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_low_end'),
            DB::raw('sum(case when vehicletype_id="J0008" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_mid_end'),
            DB::raw('sum(case when vehicletype_id="J0009" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_sport_high_end'),
            DB::raw('sum(case when vehicletype_id="J0010" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_city_sport'),
            DB::raw('sum(case when vehicletype_id="J0011" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cbu'),
            DB::raw('sum(case when vehicle_sales.sales_type="CASH" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cash'),
            DB::raw('sum(case when vehicle_sales.sales_type="CREDIT" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_credit'),
            DB::raw('sum(case when vehicle_sales.sales_type="TEMPO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_tempo'),
            DB::raw('sum(case when vehicle_sales.leasing_group="ADIRA" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_adira'),
            DB::raw('sum(case when vehicle_sales.leasing_group="CSF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_csf'),
            DB::raw('sum(case when vehicle_sales.leasing_group="FIF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_fif'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_oto'),
            DB::raw('sum(case when vehicle_sales.leasing_group="WOM" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_wom'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTHER" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_other'),
            'vehicle_sales.user_id',
            'users.name as user_name'
        )
        ->leftJoin('users', 'vehicle_sales.user_id', '=', 'users.id')
        ->where('vehicle_sales.pic_id', $p)
        ->whereBetween('faktur_date', [$b, $e])
        ->groupBy('vehicle_sales.user_id')
        ->orderBy('total_month', 'desc');
    }

    public function scopeOfTableSales($query, $begin,$b,$e,$tahun_m1,$bulan_m1, $p='')
    {
        $query->select(
            DB::raw('sum(case when faktur_date = "'.date('Y-m-d').'" then active else 0 end) as total_today'),
            DB::raw('sum(case when vehicle_sales.branch_id="101" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_month'),
            DB::raw('sum(case when DATE_FORMAT(faktur_date,"%Y-%m")="'.$tahun_m1.'-'.$bulan_m1.'" then active else 0 end) as total_month_m1'),
            DB::raw('sum(case when vehicle_sales.position_id="B7CS" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cs'),
            DB::raw('sum(case when vehicle_sales.position_id="B7MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_marketing'),
            DB::raw('sum(case when vehicle_sales.position_id="B5MK" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_spv'),
            DB::raw('sum(case when vehicle_sales.position_id="B4" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_bm'),
            DB::raw('sum(case when vehicle_sales.sales_type="CASH" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_cash'),
            DB::raw('sum(case when vehicle_sales.sales_type="CREDIT" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_credit'),
            DB::raw('sum(case when vehicle_sales.sales_type="TEMPO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_tempo'),
            DB::raw('sum(case when vehicle_sales.leasing_group="ADIRA" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_adira'),
            DB::raw('sum(case when vehicle_sales.leasing_group="CSF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_csf'),
            DB::raw('sum(case when vehicle_sales.leasing_group="FIF" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_fif'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTO" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_oto'),
            DB::raw('sum(case when vehicle_sales.leasing_group="WOM" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_wom'),
            DB::raw('sum(case when vehicle_sales.leasing_group="OTHER" AND DATE_FORMAT(faktur_date,"%Y-%m")="'.$begin.'" then active else 0 end) as total_leasing_other'),
            'vehicle_sales.user_id',
            'users.name as user_name'
        )
        ->leftJoin('users', 'vehicle_sales.user_id', '=', 'users.id')
        ->where('vehicle_sales.user_id', $p)
        ->whereBetween('faktur_date', [$b, $e]);
    }

    public function scopeOfTotalCompany($query, $date, $c)
    {
        $query->whereRaw('DATE_FORMAT(faktur_date, "%Y-%m") = "'.$date.'"')
                ->where('company_id',$c);
    }
    public function scopeOfTotalBranch($query, $date, $b)
    {
        $query->whereRaw('DATE_FORMAT(faktur_date, "%Y-%m") = "'.$date.'"')
                ->where('branch_id',$b);
    }
    public function scopeOfTotalPic($query, $date, $p)
    {
        $query->whereRaw('DATE_FORMAT(faktur_date, "%Y-%m") = "'.$date.'"')
                ->where('pic_id',$p);
    }
    public function scopeOfTotalSales($query, $date, $p)
    {
        $query->whereRaw('DATE_FORMAT(faktur_date, "%Y-%m") = "'.$date.'"')
                ->where('user_id',$p);
    }
}
