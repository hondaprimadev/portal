<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingAgenda extends Model
{
	protected $fillable = ['user_id','nomor_crm','type_payment','downpayment','price_otr','price_disc','leasing_id','leasing_payment','leasing_tenor','program_marketing','motor_type','motor_color','status','note','longitude','latitude'];

	public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function crm()
    {
        return $this->belongsTo('App\Crm','nomor_crm','nomor_crm');
    }
}
