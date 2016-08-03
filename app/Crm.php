<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Crm extends Model
{
    protected $fillable =[
		'type_customer','nomor_crm','crm_date','active_crm','branch_id','name_personal','email_personal',
		'birthdate','birthplace','identity_number','address_personal','gender',
		'rt','rw','postalcode','kelurahan','kecamatan',
		'kabupaten','city','province','phone_number','ponsel_number',
		'kk_number','name_group','address_group','npwp_group','email_group'
	];

    public function vs()
    {
        return $this->hasMany('App\VehicleSales','nomor_crm', 'nomor_crm');
    }
	public function crmtypes()
    {
    	return $this->belongsToMany('App\Crmtype')->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function getTypeListAttribute()
    {
        return $this->crmtypes->lists('id')->all();
    }

    public function setActiveCrmAttribute($value)
    {
        if(empty($value)){
            $this->attributes['active_crm'] = true;
        }        
    }
    public function setBranchIdAttribute($value)
    {
        if(empty($value)){
            $this->attributes['branch_id'] = auth()->user()->branch->id;
        }
        else{
            $this->attributes['branch_id'] = $value;
        }
    }
    
    public function scopeCrmBranch($query)
    {
        return $query->where('branch_id', auth()->user()->branch->id);
    }

	public function scopeOfMaxno($query, $dealer)
    {
        $branch_id = $dealer;
        $kd_fix;
        $year=substr(date('Y'), 2);

    	$kd_max =  $query->select(DB::raw('MAX( SUBSTR(`nomor_crm` , 4, 4 ) ) AS kd_max'))
    	->where('branch_id', $branch_id)
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

    	return 'CRM'. $kd_fix.$branch_id.$year;
    }
}
