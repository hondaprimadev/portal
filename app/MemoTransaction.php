<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoTransaction extends Model
{
    protected $fillable = ['user_id', 'memo_id','debet', 'credit', 'branch_id', 'category_id','approval_id','department_id','memo_finish'];

    public function memo()
    {
    	return $this->belongsTo('App\Memo');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    public function department()
    {
    	return $this->belongsTo('App\UserDepartment');
    }
}

