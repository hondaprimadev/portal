<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crms', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type_customer',['Personal', 'Group']);
            $table->string('nomor_crm')->unique();
            $table->date('crm_date');
            $table->boolean('active_crm');
            $table->integer('branch_id');
            $table->string('name_personal');
            $table->string('email_personal');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('identity_number');
            $table->text('address_personal');
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('rt');
            $table->integer('rw');
            $table->integer('postalcode');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('city');
            $table->string('province');
            $table->string('phone_number');
            $table->string('ponsel_number');
            $table->string('kk_number');
            $table->string('name_group');
            $table->text('address_group');
            $table->string('npwp_group');
            $table->string('email_group');
            // data vehicle customer
            $table->string('stnk_no');
            $table->datetime('stnk_valid');
            $table->string('bpkb_no');
            $table->string('vehicle_brand');
            $table->string('vehicle_type');
            $table->text('vehicle_desc');
            $table->string('vehicle_year');
            $table->string('vehicle_cc');
            $table->string('vehicle_color');
            $table->string('vehicle_frameno');
            $table->string('vehicle_machno');
            $table->datetime('vehicle_lastservice');
            $table->double('insurance_or');
            $table->datetime('insurance_date');
            $table->string('user_id');
            $table->timestamps();
        });

        Schema::create('crmtypes', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('crm_crmtype', function(Blueprint $table){
            $table->integer('crm_id')->unsigned()->index();
            $table->foreign('crm_id')->references('id')->on('crms')->onDelete('cascade');

            $table->integer('crmtype_id')->unsigned()->index();
            $table->foreign('crmtype_id')->references('id')->on('crmtypes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('crm_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stnk_no');
            $table->datetime('history_date');
            $table->integer('history_km');
            $table->string('history_service');
            $table->string('history_part');
            $table->string('history_mech');
            $table->string('wo_no');
            $table->string('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crm_histories');
        Schema::drop('crm_crmtype');
        Schema::drop('crmtypes');
        Schema::drop('crms');
    }
}
