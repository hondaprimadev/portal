<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Crm;
use App\Http\Requests;
use App\Leasing;
use App\User;
use App\VehicleSales;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class DataController extends Controller
{
    public function getSales(Request $request)
    {
        $this->authorize('upload.sales');
        $branches = Branch::lists('name', 'id');

    	return view('data.sales', compact('branches'));
    }

    public function postSales(Request $request)
    {	
        $this->authorize('upload.sales');

        $branch = $request->input('branch_id');

    	if (Input::hasFile('import_sales')) {
    		$path = Input::file('import_sales')->getRealPath();
    		$data = Excel::load($path, function($reader){})->get();
    		if (!empty($data) && $data->count()) {
    			foreach ($data as $key => $value) 
                {
                    //set pt
                    $company = Branch::where('id', $branch)->first()->company_id;
                    // set Branch Manager
                    $bm = User::where('branch_id',$branch)
                            ->where('position_id', 'B4')
                            ->where('job_status', 'Active')
                            ->first()->id;
                            
                    // set telphone
                    $telp_crm = preg_replace("/^0/", "+62",$value->telp);
                    $telp_stnk = preg_replace("/^0/", "+62",$value->stnktelp);
                    if (!$telp_crm || !$telp_stnk) {
                        $telp_crm = substr_replace($value->telp,"+62",0,0);
                        $telp_stnk = substr_replace($value->stnktelp,"+62",0,0);
                    }

                    // get user id
    				$user = User::where('name', $value->sales)->first();
                    //validation sales id
                    if (!$user) 
                    {
                        $user = '';
                        $pic = $bm;
                        $position = 'B7MK';
                    }
                    else
                    {
                        if ($user->pic_id && $user->position_id) {
                            $pic = $user->pic_id;
                            $position = $user->position_id;
                            $user = $user->id;
                        }
                        else{
                            $pic = $bm;
                            $position = $user->position_id;
                            $user = $user->id;
                        }
                    }

                    // get crm id
                    $crm = Crm::where('name_personal', $value->nama)
                            ->where('branch_id', $branch)
                            ->first();
                    $stnk = Crm::where('name_personal', $value->stnknama)
                            ->where('branch_id', $branch)
                            ->first();

                    if ($value->name == $value->stnkname) 
                    {
                        if (!$crm || !$stnk) 
                        {
                            $crm = Crm::create([
                                'nomor_crm'=> $this->MaxNo($branch),
                                'name_personal'=>$value->nama,
                                'address_personal'=>$value->alamat,
                                'ponsel_number'=>$telp_crm,
                                'branch_id'=>$branch,
                                'crm_date'=>date('Y-m-d', strtotime($value->tanggal)),
                            ]);
                            $crm->crmtypes()->sync(['1','2']);
                        }
                    }
                    else
                    {
                        if (!$crm) 
                        {
                            $crm = Crm::create([
                                'nomor_crm'=> $this->MaxNo($branch),
                                'name_personal'=>$value->nama,
                                'address_personal'=>$value->alamat,
                                'ponsel_number'=>$telp_crm,
                                'branch_id'=>$branch,
                                'crm_date'=>date('Y-m-d', strtotime($value->tanggal)),
                            ]);
                            $crm->crmtypes()->sync('1');
                        }

                        if (!$stnk) 
                        {
                            $stnk = Crm::create([
                                'nomor_crm'=> $this->MaxNo($branch),
                                'name_personal'=>$value->nama,
                                'address_personal'=>$value->alamat,
                                'ponsel_number'=>$telp_stnk,
                                'branch_id'=>$branch,
                                'crm_date'=>date('Y-m-d', strtotime($value->tanggal)),
                            ]);
                            $stnk->crmtypes()->sync('2');
                        }
                    }

                    // get sales type
                    
                    if ($value->leasing == 'CASH') 
                    {
                        $cash = $value->leasing;
                        $leasing = '';
                        $leasing_group ='';
                    }
                    elseif ($value->leasing == 'TEMPO') 
                    {
                        $cash = $value->leasing;
                        $leasing ='';
                        $leasing_group='';

                    }
                    else
                    {
                        $cash = 'CREDIT';
                        $leasings = Leasing::where('name', $value->leasing)->first();
                        $leasing = $leasings->id;
                        $leasing_group = $leasings->group_leasing;
                    }

                    $sales = VehicleSales::where('no_faktur', $value->jlfkt)->first();
                    if (!$sales) {
                        $sale=[
                            'no_faktur'=>$value->jlfkt,
                            'faktur_date'=>date('Y-m-d', strtotime($value->tanggal)),
                            'faktur_note'=>$value->ketjualxx,
                            'sales_type'=>$cash,
                            'nomor_crm'=>$crm->nomor_crm,
                            'stock_nama' =>$value->brnama,
                            'stock_warna'=> $value->brwarna,
                            'stock_tahun' => $value->tahun,
                            'stock_nomesin'=>$value->nomesin,
                            'stock_norangka'=> $value->norangka,
                            'branch_id'=>$branch,
                            'company_id'=>$company,
                            'user_id'=>$user,
                            'position_id'=>$position,
                            'price_otr'=>$value->ttlotr,
                            'price_dp'=>$value->ttlmuka,
                            'price_disc'=>$value->potdeal2,
                            'price_bbn'=>$value->bbn,
                            'leasing_id'=>$leasing,
                            'leasing_group'=>$leasing_group,
                            'pic_id'=>$pic,
                            'active'=>true,
                        ];

        				VehicleSales::create($sale);
                    }
    			}
                // return response()->json($sale);
    		}

    	}

        return back();

    }

    public function getHr()
    {
        $this->authorize('upload.hrd');
        $branches = Branch::lists('name', 'id');

        return view('data.hr', compact('branches'));     
    }
    public function postHr(Request $request)
    {
        $this->authorize('upload.hrd');

        $faker = \Faker\Factory::create();

        if (Input::hasFile('import_hr')) {
            $path = Input::file('import_hr')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) 
                {
                    $user_id = User::where('id', $value->npk)->first();
                    if(!$user_id){
                        $user = [
                            'id'=>$value->npk,
                            'name'=>$value->nama,
                            'email'=>$faker->email,
                            'branch_id'=>$value->cabang,
                            'gender'=>$value->gender,
                            'bank_name'=>$value->bank,
                            'bank_account'=>$value->rekening,
                            'job_start'=>$value->tanggal,
                            'job_end'=>$value->tanggalkeluar,
                            'job_status'=>($value->tanggalkeluar) ? 'Retired' : 'Active',
                            'position_id'=>$value->jabatan,
                            'company_id'=>$value->pt,
                            'grade'=>$value->grade,
                            'is_user'=>false,
                        ];
                        User::create($user);
                    }
                    
                }
                return back();
            }
        }
    }

    public function MaxNo($dealer)
    {
        $branch_id = $dealer;
        $kd_fix;
        $year=substr(date('Y'), 2);

        $kd_max =  Crm::select(DB::raw('MAX( SUBSTR(`nomor_crm` , 4, 4 ) ) AS kd_max'))
        ->where('branch_id', $branch_id)
        ->where(DB::raw('YEAR(created_at)'), '=', date('Y'))
        ->get();
        
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

        return 'CRM'. $kd_fix.$branch_id.$year;
    }
}
