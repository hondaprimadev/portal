<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_supplier')->unique();
            $table->integer('branch_id');
            $table->integer('category_id');
            
            $table->string('name');
            $table->string('npwp');
            $table->boolean('pkp');
            $table->text('address');
            $table->string('business_field');
            $table->string('phone');
            $table->string('fax');

            $table->string('pic_supplier');
            $table->string('phone_pic');
            $table->string('name_pic');

            $table->string('account_number');
            $table->string('account_name');
            $table->integer('bank_id');
            $table->string('bank_branch');

            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('supplier_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();            
        });

        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('branch');
            $table->string('account_number');
            $table->text('address');
            $table->string('phone_number');
            $table->string('fax_number');
            $table->boolean('active');
            $table->integer('group_id');
            $table->timestamps();
        });

        Schema::create('bank_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
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
        Schema::drop('bank_groups');
        Schema::drop('banks');
        Schema::drop('supplier_categories');
        Schema::drop('suppliers');
    }
}
