<?php

use Illuminate\Database\Seeder;

class MemoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon\Carbon::now();
        
        App\JournalAccount::insert([
            ['id'=>'515.000.100','account_name' => 'OPERASIONAL UMUM','created_at' => $now, 'updated_at' => $now],
            ['id'=>'520.000.100','account_name' => 'ADMINISTRASI KANTOR','created_at' => $now, 'updated_at' => $now],
            ['id'=>'522.000.100','account_name' => 'PEMASARAN','created_at' => $now, 'updated_at' => $now],
            ['id'=>'524.000.100','account_name' => 'JASA BANK','created_at' => $now, 'updated_at' => $now],
            ['id'=>'518.000.100','account_name' => 'PERIJINAN','created_at' => $now, 'updated_at' => $now],
            ['id'=>'514.000.100','account_name' => 'PERJALANAN DINAS','created_at' => $now, 'updated_at' => $now],
            ['id'=>'521.000.100','account_name' => 'RESEARCH & DEVELOPMENT','created_at' => $now, 'updated_at' => $now],
            ['id'=>'523.000.100','account_name' => 'SUMBANGAN','created_at' => $now, 'updated_at' => $now],
            ['id'=>'517.000.100','account_name' => 'PERBAIKAN & PERAWATAN','created_at' => $now, 'updated_at' => $now],
            ['id'=>'550.000.100','account_name' => 'BIAYA LAIN-LAIN','created_at' => $now, 'updated_at' => $now],
            ['id'=>'516.000.100','account_name' => 'BIAYA KEPERLUAN BENGKEL','created_at' => $now, 'updated_at' => $now],
            ['id'=>'525.000.100','account_name' => 'BIAYA PAJAK','created_at' => $now, 'updated_at' => $now],
            ['id'=>'511.000.100','account_name' => 'GAJI KARYAWAN UNIT','created_at' => $now, 'updated_at' => $now],
            ['id'=>'512.000.100','account_name' => 'TUNJANGAN KARYAWAN','created_at' => $now, 'updated_at' => $now],
        ]);

        App\MemoCategory::insert([
        	//OPERASIONAL UMUM
        	['name'=>'KAS KECIL','department_id' => 'D3','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'BULANAN','department_id' => 'D4','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'EKSPEDISI','department_id' => 'D3','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PERLENGKAPAN | OPERASIONAL UMUM','department_id' => 'D4','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'CONSUMABLE| OPERASIONAL UMUM','department_id' => 'D4','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'AUDIT','department_id' => 'D3','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'SEWA | OPERASIONAL UMUM','department_id' => 'D4','account_id'=>'515.000.100','created_at' => $now, 'updated_at' => $now],
        	
        	// ADMINISTRASI KANTOR
        	['name'=>'LEGAL','department_id' => 'D3','account_id'=>'520.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'SEWA | ADMINISTRASI KANTOR','department_id' => 'D4','account_id'=>'520.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'ATK','department_id' => 'D4','account_id'=>'520.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'FORM','department_id' => 'D4','account_id'=>'520.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PERLENGKAPAN | ADMINISTRASI KANTOR','department_id' => 'D4','account_id'=>'520.000.100','created_at' => $now, 'updated_at' => $now],
        	
        	//PEMASARAN
        	['name'=>'ATL','department_id' => 'D2','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'ATL','department_id' => 'D5','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'BTL','department_id' => 'D2','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'BTL','department_id' => 'D5','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'ENTERTAIN','department_id' => 'D2','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'ENTERTAIN','department_id' => 'D5','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'HADIAH','department_id' => 'D2','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'HADIAH','department_id' => 'D5','account_id'=>'522.000.100','created_at' => $now, 'updated_at' => $now],

        	//JASA BANK
        	['name'=>'ADMINISTRASI','department_id' => 'D3','account_id'=>'524.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'BUNGA','department_id' => 'D3','account_id'=>'524.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PROVISI','department_id' => 'D3','account_id'=>'524.000.100','created_at' => $now, 'updated_at' => $now],

        	//PERIJINAN
        	['name'=>'KENDARAAN | PERIJINAN','department_id' => 'D4','account_id'=>'518.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PAJAK','department_id' => 'D4','account_id'=>'518.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'JUAL BELI','department_id' => 'D4','account_id'=>'518.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'USAHA','department_id' => 'D4','account_id'=>'518.000.100','created_at' => $now, 'updated_at' => $now],

        	// PERJALANAN DINAS
        	['name'=>'DINAS','department_id' => 'D4','account_id'=>'514.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'MEETING','department_id' => 'D4','account_id'=>'514.000.100','created_at' => $now, 'updated_at' => $now],

        	// RESEARCH & DEVELOPMENT
        	['name'=>'TRAINING','department_id' => 'D4','account_id'=>'521.000.100','created_at' => $now, 'updated_at' => $now],

        	// SUMBANGAN
        	['name'=>'HARI RAYA','department_id' => 'D4','account_id'=>'523.000.100','created_at' => $now, 'updated_at' => $now],

        	// PERBAIKAN & PERAWATAN
        	['name'=>'GEDUNG','department_id' => 'D4','account_id'=>'517.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'KENDARAAN | PERAWATAN','department_id' => 'D4','account_id'=>'517.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PERALATAN','department_id' => 'D4','account_id'=>'517.000.100','created_at' => $now, 'updated_at' => $now],

        	// BIAYA LAIN-LAIN
        	['name'=>'OTHER','department_id' => 'D1','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D2','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D3','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D4','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D5','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D6','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D7','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'OTHER','department_id' => 'D8','account_id'=>'550.000.100','created_at' => $now, 'updated_at' => $now],

        	// BIAYA KEPERLUAN BENGKEL
        	['name'=>'CONSUMABLE | AHASS','department_id' => 'D7','account_id'=>'516.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'TOOLS','department_id' => 'D7','account_id'=>'516.000.100','created_at' => $now, 'updated_at' => $now],
        	['name'=>'PERAWATAN','department_id' => 'D7','account_id'=>'516.000.100','created_at' => $now, 'updated_at' => $now],

        	// BIAYA PAJAK
        	['name'=>'BIAYA PAJAK','department_id' => 'D3','account_id'=>'525.000.100','created_at' => $now, 'updated_at' => $now],

        	// GAJI KARYAWAN UNIT
			['name'=>'GAJI','department_id' => 'D4','account_id'=>'511.000.100','created_at' => $now, 'updated_at' => $now],
			['name'=>'INSENTIF','department_id' => 'D4','account_id'=>'511.000.100','created_at' => $now, 'updated_at' => $now],
			['name'=>'POTONGAN','department_id' => 'D4','account_id'=>'511.000.100','created_at' => $now, 'updated_at' => $now],

			// TUNJANGAN KARYAWAN
			['name'=>'KESEHATAN','department_id' => 'D4','account_id'=>'512.000.100','created_at' => $now, 'updated_at' => $now],
			['name'=>'THR','department_id' => 'D4','account_id'=>'512.000.100','created_at' => $now, 'updated_at' => $now],
        ]);
    }
}


