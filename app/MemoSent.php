<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemoSent extends Model
{
    protected $fillable = ['memo_id','no_memo','category_id','to_memo','from_memo','approval_memo','subject_memo','last_approval_memo','last_revise_memo','total_memo','notes_memo','branch_id','status_memo','supplier_id','company_id','department_id','prepayment_finish','prepayment_total'
    ];

    public function userTo()
    {
        return $this->belongsTo('App\User','to_memo', 'id');
    }

    public function userFrom()
    {
        return $this->belongsTo('App\User','from_memo', 'id');
    }
}
