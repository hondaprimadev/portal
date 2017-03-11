<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name','branch','account_number',
    'address','phone_number','fax_number','active','group_id'];

    public function group()
    {
    	return $this->belongsTo('App\BankGroup', 'group_id', 'id');
    }
}
