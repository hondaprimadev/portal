<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoDetail extends Model
{
    protected $fillable =['date','memo_id','category_id','description','qty','total'];

    public $timestamps = false;
}
