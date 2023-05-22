<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoCategory extends Model
{
    protected $fillable = ['name','department_id','account_id'];
    
    public function memos()
    {
	return $this->hasMany('App\Memo', 'category_id', 'id');
    }

    public function journal()
    {
    	return $this->belongsTo('App\JournalAccount','account_id', 'id');
    }

    public function department()
    {
    	return $this->belongsTo('App\UserDepartment');
    }

    public function approvals()
    {
    	return $this->hasMany('App\MemoApproval','category_id','id');
    }
}
