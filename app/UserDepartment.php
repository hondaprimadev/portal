<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDepartment extends Model
{
    protected $fillable = ['name'];
    public $incrementing = false;
}
