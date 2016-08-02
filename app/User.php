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
    protected $fillable = ['id','name','alias', 'email', 'password','employer_id','address','city','birthday','birthplace','phone','marrital','blood_type','zipcode','gender','bank_account','npwp','bank_branch','bank_name','job_status','job_start','job_end','branch_id','company_id','department_id','position_id','mother_name','pic_id','grade','is_user','token'
    ];

    public $incrementing = false;
    
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);

    }

    public function pictures()
    {
        return $this->hasMany('App\UserPicture');
    }


    public function isSuper()
    {
       if ($this->roles->contains('name', 'super')) {
            return true;
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->isSuper()) {
            return true;
        }
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !! $this->roles->intersect($role)->count();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        return $this->roles()->attach($role);
    }

    public function revokeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
        return $this->roles()->detach($role);
    }
}