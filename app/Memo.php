<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Memo extends Model
{
    protected $fillable = ['id','no_memo','category_id','to_memo','from_memo','approval_memo','subject_memo','last_approval_memo','last_revise_memo','total_memo','notes_memo','branch_id','status_memo','supplier_id','company_id','department_id','prepayment_finish','prepayment_total','supplier_type'
    ];

    public static $rules = [
        'memo_no' => 'required',
        'subject_memo'=>'required',
        'approval_memo'=>'required',
        'to_memo'=>'required',
        'category_id'=>'required',
        'department_id_approval'=>'required'
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    public function department()
    {
        return $this->belongsTo('App\UserDepartment');
    }
    public function userTo()
    {
        return $this->belongsTo('App\User','to_memo', 'id');
    }

    public function userFrom()
    {
        return $this->belongsTo('App\User','from_memo','id');
    }

    public function userApproval()
    {
        return $this->belongsTo('App\User', 'last_approval_memo', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\MemoCategory', 'category_id','id');
    }

    public function details()
    {
        return $this->hasMany('App\MemoDetail');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function supplierUser()
    {
        return $this->belongsTo('App\User', 'supplier_id', 'id');
    }

    public function finances()
    {
        return $this->hasMany('App\MemoFinanceSupport');
    }

    public function sents()
    {
        return $this->hasMany('App\MemoSent');
    }

    public function upload()
    {
        return $this->hasMany('App\MemoUpload', 'no_memo','no_memo');
    }
    public function scopeofMaxno($query, $branch_id, $company_id)
    {
        $kd_fix;
        $year=substr(date('Y'), 2);
        $month=$this->romanNumerals(date('m'));

        $company = Company::where('id', $company_id)->first();

        if ($branch_id != 100) {
            $dept = Branch::where('id', $branch_id)->first()->name;
        	$kd_max =  $query->select(DB::raw('MAX( SUBSTR(`no_memo` , 1, 4 ) ) AS kd_max'))
            ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
            ->where('branch_id',$branch_id)
            ->where('company_id', $company_id)
        	->get();
        }else{
            $dept = auth()->user()->department->name;
            $kd_max =  $query->select(DB::raw('MAX( SUBSTR(`no_memo` , 1, 4 ) ) AS kd_max'))
            ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
            ->where('branch_id',$branch_id)
            ->where('company_id', $company_id)
            ->where('department_id', auth()->user()->department_id)
            ->get();
        }
    	
    	if ($kd_max->count() >0) {
    		foreach ($kd_max as $k) 
    		{
				$tmp = ((int)$k->kd_max)+1;
				$kd_fix = sprintf("%04s", $tmp);
    		}
    	}
    	else{
    		$kd_fix = '0001';
    	}

    	return $kd_fix.'/'.
                $company->alias.'/'.
    			$branch_id.'-'.
    			$dept.'/'.
    			$month.'/'.$year;
    }

    public function romanNumerals($num) 
    {
        $n = intval($num);
        $res = '';
 
        /*** roman_numerals array  ***/
        $roman_numerals = array(
                'M'  => 1000,
                'CM' => 900,
                'D'  => 500,
                'CD' => 400,
                'C'  => 100,
                'XC' => 90,
                'L'  => 50,
                'XL' => 40,
                'X'  => 10,
                'IX' => 9,
                'V'  => 5,
                'IV' => 4,
                'I'  => 1
        );
 
        foreach ($roman_numerals as $roman => $number) 
        {
            /*** divide to get  matches ***/
            $matches = intval($n / $number);
    
            /*** assign the roman char * $matches ***/
            $res .= str_repeat($roman, $matches);
    
            /*** substract from the number ***/
            $n = $n % $number;
        }
 
        /*** return the res ***/
        return $res;
    }
}
