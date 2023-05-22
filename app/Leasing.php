<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Leasing extends Model
{
    protected $fillable = ['id','name','group_leasing','address_leasing','phone_leasing','fax_leasing','email_leasing'];

    public $incrementing = false;

    public function scopeMaxno($query)
    {
        $kd_fix;

    	$kd_max =  $query->select(DB::raw('MAX( SUBSTR(`id` , 5, 7 ) ) AS kd_max'))->get();
    	
    	if ($kd_max->count() >0) {
    		foreach ($kd_max as $k) 
    		{	
				$tmp = ((int)$k->kd_max)+1;
				$kd_fix = sprintf("%06s", $tmp);
    		}
    	}
    	else{
    		$kd_fix = '000001';
    	}

    	return 'LGS-'.$kd_fix;
    }
}
