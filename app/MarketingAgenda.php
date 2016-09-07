<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketingAgenda extends Model
{
	protected $fillable = ['user_id','name','address','email','phone','type_motor','status','id_number','note','longitude','latitude'];
}
