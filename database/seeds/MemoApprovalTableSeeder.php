<?php

use Illuminate\Database\Seeder;

class MemoApprovalTableSeeder extends Seeder
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
        ]);
    }
}
