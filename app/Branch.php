<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['id','name','address','phone','email'];

    public function company()
    {
    	return $this->belongsTo('App\Company');
    }

}
