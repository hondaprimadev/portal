<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_faktur')->unique();
            $table->date('faktur_date');
            $table->text('faktur_note')->nullable();
            $table->enum('sales_type',['CASH', 'CREDIT','TEMPO']);
            $table->string('nomor_crm');
            $table->string('vehicletype_id');
            $table->string('stock_nama');
            $table->string('stock_warna');
            $table->string('stock_tahun');
            $table->string('stock_nomesin');
            $table->string('stock_norangka');
            $table->integer('branch_id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('position_id');
            $table->double('price_otr');
            $table->double('price_dp');
            $table->double('price_disc');
            $table->double('price_bbn');
            $table->string('leasing_id');
            $table->string('leasing_group');
            $table->string('pic_id')->nullable();
            $table->string('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vehicle_sales');
    }
}
