<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $fillable = ['id','name'];

    public $incrementing = false;

    public function hrms()
    {
    	return $this->hasMany('App\User');
    }
}
