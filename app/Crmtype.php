<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Crmtype extends Model
{
    protected $fillable = ['name'];
	
    public function Crms()
    {
    	return $this->belongToMany('App\Crm');
    }
}
