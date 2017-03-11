<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalAccount extends Model
{
    protected $fillable = ['id','account_name'];

    public $incrementing = false;

    public function categories()
    {
    	return $this->hasMany('App\MemoCategory','account_id','id');
    }
}
