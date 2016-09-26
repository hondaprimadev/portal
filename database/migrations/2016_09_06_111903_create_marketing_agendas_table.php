<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_agendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nomor_crm');
            
            $table->enum('type_payment', ['Cash','Credit']);
            $table->double('downpayment');
            $table->double('price_otr');
            $table->double('price_disc');
            $table->string('leasing_id');
            $table->double('leasing_payment');
            $table->integer('leasing_tenor');
            $table->text('program_marketing');

            $table->string('motor_type');
            $table->string('motor_color');

            $table->enum('status',['Hot Prospect', 'Prospect']);
            $table->text('note');
            $table->text('longitude');
            $table->text('latitude');
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
        Schema::drop('marketing_agendas');
    }
}
