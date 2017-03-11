<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoApproval extends Model
{
    protected $fillable = ['category_id','approval_path','budget','budget_total','branch_id','user_approval','prepayment','inv_date1', 'inv_date2','user_grade','department_id'];

    public function category()
    {
    	return $this->belongsTo('App\MemoCategory', 'category_id', 'id');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Branch');
    }

    public function position()
    {
    	return $this->belongsTo('App\UserPosition','user_approval','id');
    }

    public function transactions()
    {
        return $this->hasMany('App\MemoTransaction');
    }

    public function department()
    {
        return $this->belongsTo('App\UserDepartment');
    }
}
