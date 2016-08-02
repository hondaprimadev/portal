<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now();
        
        // calendar loop
        $begin = new DateTime('2016-01-01');
        $end = new DateTime('2016-12-31');
        $end = $end->modify('+1 day'); 
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);

        foreach($daterange as $date){
            App\Calendar::insert([
                ['datefield'=> $date->format("Y-m-d")],
            ]);
        }
        //department data
        App\UserDepartment::insert([
             ['id'=>'D1','name' => 'MANAGER','created_at' => $now, 'updated_at' => $now],
             ['id'=>'D2','name' => 'MARKETING','created_at' => $now, 'updated_at' => $now],
             ['id'=>'D3','name' => 'OPERATION','created_at' => $now, 'updated_at' => $now],
             ['id'=>'D4','name' => 'BUSSINESS SUPPORT','created_at' => $now, 'updated_at' => $now],
             ['id'=>'D5','name' => 'AFTER SALES','created_at' => $now, 'updated_at' => $now],
             ['id'=>'D6','name' => 'BRANCH','created_at' => $now, 'updated_at' => $now]
        ]);

        App\UserPosition::insert([
            // HO
            ['id'=>'H1','name'=>'Director','department_id'=>'D1','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H2MK','name'=>'GM MARKETING','department_id'=>'D2','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H2OP','name'=>'GM OPERATION','department_id'=>'D3','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H3MK','name'=>'DEPT. HEAD MARKETING','department_id'=>'D2','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H3OP','name'=>'DEPT. HEAD OPERATION','department_id'=>'D3','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H3BS','name'=>'DEPT. HEAD BUSSINESS SUPPORT','department_id'=>'D4','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H3AS','name'=>'DEPT. HEAD AFTER SALES','department_id'=>'D5','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H4FI','name'=>'SUB. DEPT. HEAD FINANCE','department_id'=>'D3','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H4IT','name'=>'SUB. DEPT. HEAD IT','department_id'=>'D4','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H4AS','name'=>'SUB. DEPT. AFTER SALES','department_id'=>'D5','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H6MK','name'=>'STAFF MARKETING','department_id'=>'D2','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H6OP','name'=>'STAFF OPERATION','department_id'=>'D3','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H6FI','name'=>'STAFF FINANCE','department_id'=>'D3','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H6BS','name'=>'STAFF BUSSINESS SUPPORT','department_id'=>'D4','created_at' => $now, 'updated_at' => $now],
            ['id'=>'H6AS','name'=>'STAFF AFTER SALES','department_id'=>'D5','created_at' => $now, 'updated_at' => $now],

            // BRANCH
            ['id'=>'B4','name'=>'BRANCH MANAGER','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B5','name'=>'ADMIN HEAD','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B5AS','name'=>'SERVICE AND SPAREPART HEAD','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B5MK','name'=>'REP. HEAD','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B6MK','name'=>'SUPERVISOR','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B6OP','name'=>'STAFF ADMIN','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B7CS','name'=>'COUNTER SALES','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
            ['id'=>'B7MK','name'=>'SALES','department_id'=>'D6','created_at' => $now, 'updated_at' => $now],
        ]);

        // user data
    	// App\User::insert([
	    //     [
     //            'id'=>'1111',
     //            'name' => 'ARDIANA KUSUMA DEWI',
     //            'email'=>'dina@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B7CS',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
	    //     [
     //            'id'=>'1112',
     //            'name' => 'IDA ARYANI',
     //            'email'=>'ida@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B7CS',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
	    //     [
     //            'id'=>'1113',
     //            'name' => 'DIAH AYU SEPTIANA ANGGRAINI',
     //            'email'=>'diah@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B7CS',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
	    //     [
     //            'id'=>'1114',
     //            'name' => 'SADENI',
     //            'email'=>'sadeni@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B7MK',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
     //        [
     //            'id'=>'1115',
     //            'name' => 'HARMINTOYO',
     //            'email'=>'harmintoyo@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B5MK',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
     //        [
     //            'id'=>'1116',
     //            'name' => 'MARTIN NATA MANALU',
     //            'email'=>'martin@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B5',
     //            'pic_id'=>'',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
     //        [
     //            'id'=>'1117',
     //            'name' => 'ATIQUR ROHMAN',
     //            'email'=>'atiqur@gmail.com',
     //            'branch_id'=>'101',
     //            'company_id'=>'1',
     //            'department_id'=>'D6',
     //            'position_id'=>'B7MK',
     //            'pic_id'=>'1115',
     //            'created_at' => $now, 
     //            'updated_at' => $now
     //        ],
    	// ]);

        App\Role::insert([
            ['name'=>'super', 'created_at'=> $now, 'updated_at'=> $now],
            ['name'=>'admin', 'created_at'=> $now, 'updated_at'=> $now],
            ['name'=>'operator', 'created_at'=> $now, 'updated_at'=> $now],
            ['name'=>'hrd', 'created_at'=> $now, 'updated_at'=> $now],
            ['name'=>'marketing', 'created_at'=> $now, 'updated_at'=> $now],
        ]);

        App\Permission::insert([
            ['name' => 'user.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.delete','created_at' => $now, 'updated_at' => $now],
            ['name' => 'user.super','created_at' => $now, 'updated_at' => $now],

            ['name' => 'role.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'role.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'role.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'role.delete','created_at' => $now, 'updated_at' => $now],
            ['name' => 'role.super','created_at' => $now, 'updated_at' => $now],

            ['name' => 'permission.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'permission.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'permission.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'permission.delete','created_at' => $now, 'updated_at' => $now],
            ['name' => 'permission.super','created_at' => $now, 'updated_at' => $now],

            // UPLOAD DataController
            ['name' =>'upload.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'upload.sales','created_at' => $now, 'updated_at' => $now],
            ['name' => 'upload.hrd','created_at' => $now, 'updated_at' => $now],

            ['name' => 'marketing.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'marketing.report.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'marketing.team.open','created_at' => $now, 'updated_at' => $now],

            ['name' => 'marketing.report.admin','created_at' => $now, 'updated_at' => $now],
            ['name' => 'marketing.report.branch','created_at' => $now, 'updated_at' => $now],
            ['name' => 'marketing.report.pic','created_at' => $now, 'updated_at' => $now],
            ['name' => 'marketing.team','created_at' => $now, 'updated_at' => $now],

            ['name' => 'hrd.department.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.department.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.department.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.department.delete','created_at' => $now, 'updated_at' => $now],
            
            ['name' => 'hrd.employee.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.employee.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.employee.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.employee.delete','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.employee.add.user','created_at' => $now, 'updated_at' => $now],

            ['name' => 'hrd.position.open','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.position.create','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.position.edit','created_at' => $now, 'updated_at' => $now],
            ['name' => 'hrd.position.delete','created_at' => $now, 'updated_at' => $now],

        ]);

        $super = App\User::create([
                'id'=>'1283',
                'name'=>'PRAMANDA TIRTA MULYA',
                'email'=>'tmulya@gmail.com',
                'password'=>bcrypt('1234567890'),
                'branch_id'=>'100',
                'company_id'=>'1',
                'department_id'=>'D4',
                'position_id'=>'H4IT',
                'pic_id'=>'',
                'is_user'=>true,
                'token'=>md5(uniqid('1283', true)),
        ]);
        $super->assignRole('super');

        App\Crmtype::insert([
            ['name'=>'Customer', 'created_at'=>$now, 'updated_at'=>$now],
            ['name'=>'Stnk', 'created_at'=>$now, 'updated_at'=>$now],
        ]);
        
        App\Company::insert([
            ['name'=>'PT Prima Anaga Raina','alias'=>'PAR', 'created_at'=>$now,'updated_at'=>$now],
            ['name'=>'PT Prima Mustika Abadi','alias'=>'PMA', 'created_at'=>$now,'updated_at'=>$now]
        ]);

        App\Branch::insert([
            ['id'=>100,'name'=>'HO','address'=>'Jl Habiproyo','phone'=>'0298323567','email'=>'customer_kendal@hondaprima.co.id','company_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>101,'name'=>'Kendal','address'=>'Jl Habiproyo','phone'=>'0298323567','email'=>'customer_kendal@hondaprima.co.id','company_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>102,'name'=>'Batang','address'=>'Jl Sudirman','phone'=>'0298323567','email'=>'customer_batang@hondaprima.co.id','company_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>103,'name'=>'Pemalang','address'=>'Jl Sudirman','phone'=>'0298323567','email'=>'customer_batang@hondaprima.co.id','company_id'=>1,'created_at'=>$now,'updated_at'=>$now],
            ['id'=>201,'name'=>'Palembang','address'=>'Jl Parameswara','phone'=>'0298323567','email'=>'customer_palembang@hondaprima.co.id','company_id'=>2,'created_at'=>$now,'updated_at'=>$now],
        ]);

    	// leasing data
    	App\Leasing::insert([
    		[
                'id' => 'LSG-000002',
    			'name' => 'ADIRA KENDAL',
                'group_leasing'=>'ADIRA',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000005',
    			'name' => 'ADIRA PEKALONGAN',
                'group_leasing'=>'ADIRA',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000006',
    			'name' => 'ADIRA PEMALANG',
                'group_leasing'=>'ADIRA',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000007',
    			'name' => 'ADIRA SEMARANG',
                'group_leasing'=>'ADIRA',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000008',
    			'name' => 'CSF PEKALONGAN',
                'group_leasing'=>'CSF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000009',
    			'name' => 'CSF SEMARANG',
                'group_leasing'=>'CSF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000010',
    			'name' => 'FIF BATANG',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000012',
    			'name' => 'FIF DEMAK',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000013',
    			'name' => 'FIF KENDAL',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000015',
    			'name' => 'FIF PEKALONGAN',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000016',
    			'name' => 'FIF PEMALANG',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000017',
    			'name' => 'FIF SEMARANG',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000018',
    			'name' => 'FIF UNGARAN',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000019',
    			'name' => 'FIF WELERI',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000023',
    			'name' => 'OTO KENDAL',
                'group_leasing'=>'OTO',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000025',
    			'name' => 'OTO PEKALONGAN',
                'group_leasing'=>'OTO',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[ 
                'id' => 'LSG-000026',
    			'name' => 'OTO PEMALANG',
                'group_leasing'=>'OTO',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000027',
    			'name' => 'OTO SEMARANG',
                'group_leasing'=>'OTO',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000032',
    			'name' => 'WOM PEKALONGAN',
                'group_leasing'=>'WOM',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000033',
    			'name' => 'WOM PEMALANG',
                'group_leasing'=>'WOM',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000034',
    			'name' => 'WOM SEMARANG',
                'group_leasing'=>'WOM',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000035',
    			'name' => 'WOM WELERI',
                'group_leasing'=>'WOM',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000036',
    			'name' => 'CSF PEKALONGAN - KSM',
                'group_leasing'=>'CSF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000037',
    			'name' => 'KDS KENDAL',
                'group_leasing'=>'OTHER',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000038',
    			'name' => 'ARTHA KENDAL',
                'group_leasing'=>'OTHER',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000039',
    			'name' => 'PRIMKOVERI PEMALANG',
                'group_leasing'=>'OTHER',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000040',
    			'name' => 'PT. MANDIRI UTAMA FINANCE',
                'group_leasing'=>'OTHER',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000043',
    			'name' => 'FIFGROUP PALEMBANG',
                'group_leasing'=>'FIF',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
    		[
                'id' => 'LSG-000044',
    			'name' => 'OTO PALEMBANG',
                'group_leasing' => 'OTO',
    			'created_at' => $now, 
    			'updated_at' => $now
    		],
            [
                'id' => 'LSG-000045',
                'name' => 'ADIRA PALEMBANG 1',
                'group_leasing' => 'ADIRA',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000046',
                'name' => 'ADIRA PALEMBANG 3',
                'group_leasing' => 'ADIRA',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000047',
                'name' => 'CSF PALEMBANG',
                'group_leasing' => 'CSF',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000048',
                'name' => 'WOM PALEMBANG',
                'group_leasing' => 'WOM',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000049',
                'name' => 'MCF PALEMBANG',
                'group_leasing' => 'MCF',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000050',
                'name' => 'RADANA PALEMBANG',
                'group_leasing' => 'RADANA',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000051',
                'name' => 'KSM BCA',
                'group_leasing' => 'OTHER',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000052',
                'name' => 'MANDIRI BMRI',
                'group_leasing' => 'OTHER',
                'created_at' => $now, 
                'updated_at' => $now
            ],
            [
                'id' => 'LSG-000053',
                'name' => 'ARTHA PEMALANG',
                'group_leasing'=>'OTHER',
                'created_at' => $now, 
                'updated_at' => $now
            ],

    	]);
 
    }
}
