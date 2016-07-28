<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','name', 'email', 'password','employer_id','address','city','birthday','birthplace','phone','marrital','blood_type','zipcode','gender','bank_account','npwp','bank_branch','bank_name','job_status','job_start','job_end','branch_id','company_id','department_id','position_id','mother_name','pic_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
}