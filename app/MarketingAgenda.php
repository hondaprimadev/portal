<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingAgenda extends Model
{
	protected $fillable = ['user_id','branch_id',
    'name','phone','email','address','id_number','city',
    'name_stnk','phone_stnk','email_stnk','address_stnk','id_number_stnk','city_stnk',
    'type_payment','downpayment','price_otr','price_disc','leasing_id','leasing_payment','leasing_tenor','program_marketing','motor_type','motor_color','status','longitude','latitude','active'];

	public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function histories()
    {
        return $this->hasMany('App\MarketingAgendaHistory','agenda_id');
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
