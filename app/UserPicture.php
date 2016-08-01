<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPicture extends Model
{
    protected $fillable = ['user_id','filename','original_name','filetype','filesize'];

    public function User()
    {
    	$this->belongsTo('App\User');
    }
}
