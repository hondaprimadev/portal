<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoFinanceSupport extends Model
{
	protected $fillable = ['memo_id', 'group_leasing','total','notes'];
}
