<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['id','name','address','phone','email'];

    public function users()
    {
    	return $this->hasMany('App\User');
    }
    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function vs()
    {
    	return $this->hasMany('App\VehicleSales');
    }

    public function crms()
    {
        return $this->hasMany('App\Crm');
    }
}
