<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    protected $fillable = ['id','name','department_id'];
    public $incrementing = false;

    public function department()
    {
    	return $this->belongsTo('App\UserDepartment');
    }

    public function crm()
    {
    	return $this->belongsTo('App\Crm');
    }
}
