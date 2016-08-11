<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->string('wo_no')->index();
            $table->primary('wo_no');
            $table->string('cc_code');
            $table->integer('type_id');
            $table->string('type_remark');
            $table->datetime('wo_date');
            $table->integer('wo_km');
            $table->datetime('wo_finish');
            $table->datetime('wo_start');
            $table->datetime('wo_end');
            $table->string('stnk_no');
            $table->string('crm_no');
            $table->text('wo_condition');
            $table->text('wo_complain');
            $table->string('wo_order');
            $table->string('wo_remark');
            $table->double('wo_total');
            $table->double('wo_ppn');
            $table->string('wo_discremark');
            $table->double('wo_discvalue');
            $table->integer('wo_discpercentage');
            $table->double('wo_grandtotal');
            $table->double('wo_paid');
            $table->datetime('wo_paiddate');
            $table->double('wo_or');
            $table->double('wo_est');
            $table->tinyInteger('docflow_seq');
            $table->string('wo_followup');
            $table->string('wo_sa');
            $table->string('wo_foreman');
            $table->string('wo_mechanic');
            $table->string('gl_no');
            $table->boolean('ord_chk01');
            $table->boolean('ord_chk02');
            $table->boolean('ord_chk03');
            $table->boolean('ord_chk04');
            $table->boolean('ord_chk05');
            $table->boolean('ord_chk06');
            $table->string('user_id');
            $table->integer('tax_id');
            $table->string('tax_no');
            $table->datetime('tax_date');
            $table->integer('gend_id');
            $table->tinyInteger('vehicle_fuel');
            $table->timestamps();
        });

        Schema::create('work_order_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remark');
            $table->boolean('tax');
            //
        });

        Schema::create('work_order_charge', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wo_no');
            $table->foreign('wo_no')->references('wo_no')->on('work_orders')->onDelete('cascade');
            $table->tinyInteger('wo_subno');
            $table->string('wo_service');
            $table->integer('wo_qty');
            $table->double('price');
            $table->string('wo_discremark');
            $table->integer('wo_discpercentage');
            $table->double('wo_discvalue');
            $table->double('wo_total');
            $table->string('user_id');
        });

        Schema::create('work_order_condition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wo_no');
            $table->foreign('wo_no')->references('wo_no')->on('work_orders')->onDelete('cascade');
            $table->tinyInteger('wo_subno');
            $table->string('wo_remark');
            $table->string('wo_place');
            $table->tinyInteger('ord_x');
            $table->tinyInteger('ord_y');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('work_order_condition');
        Schema::drop('work_order_charge');
        Schema::drop('work_order_types');
        Schema::drop('work_orders');
    }
}
