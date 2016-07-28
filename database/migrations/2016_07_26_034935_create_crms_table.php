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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('crm_crmtype');
        Schema::drop('crmtypes');
        Schema::drop('crms');
    }
}
