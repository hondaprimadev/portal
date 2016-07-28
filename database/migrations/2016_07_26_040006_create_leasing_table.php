<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leasings', function (Blueprint $table) {
            $table->string('id')->index();
            $table->primary('id');
            
            $table->string('name');
            $table->string('group_leasing');
            $table->text('address_leasing');
            $table->string('phone_leasing');
            $table->string('fax_leasing');
            $table->string('email_leasing');
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
        Schema::drop('leasings');
    }
}
