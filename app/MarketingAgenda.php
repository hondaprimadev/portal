<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingAgenda extends Model
{
	protected $fillable = ['user_id','branch_id','name','phone','email','address','id_number','type_payment','downpayment','price_otr','price_disc','leasing_id','leasing_payment','leasing_tenor','program_marketing','motor_type','motor_color','status','note','longitude','latitude','active'];

	public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function setActiveAttribute($value)
    {
    	if (empty($value)) {
    		$this->attributes['active'] = true;
    	}else{
    		$this->attributes['active'] = $value;
    	}
    }
}
