<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Supplier extends Model
{
	protected $fillable = ['no_supplier','branch_id','category_id','name','npwp','pkp','address','business_field','phone','fax','pic_supplier','phone_pic','name_pic','account_number','account_name','bank_id','bank_branch','active'];

	public function branch()
	{
		return $this->belongsTo('App\Branch');
	}

	public function category()
	{
		return $this->belongsTo('App\SupplierCategory','category_id','id');
	}

    public function bank()
    {
        return $this->belongsTo('App\BankGroup','bank_id', 'id');
    }

	public function scopeofMaxno($query, $branch_id, $category_id)
    {
        $kd_fix;
        $year=substr(date('Y'), 2);

    	$kd_max =  $query->select(DB::raw('MAX( SUBSTR(`no_supplier` , 5, 4 ) ) AS kd_max'))
    	->where('branch_id', $branch_id)
    	->where('category_id', $category_id)
        ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
    	->get();
    	
    	if ($kd_max->count() >0) {
    		foreach ($kd_max as $k) 
    		{
				$tmp = ((int)$k->kd_max)+1;
				$kd_fix = sprintf("%04s", $tmp);
    		}
    	}
    	else{
    		$kd_fix = '0001';
    	}

    	return 'SUP-'. $kd_fix.'-'.$branch_id.'-'.$category_id.'-'.$year;
    }
}
