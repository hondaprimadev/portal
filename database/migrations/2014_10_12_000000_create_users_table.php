<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('password_default');
            $table->text('address');
            $table->string('city');
            $table->date('birthday');
            $table->string('birthplace');
            $table->string('phone');
            $table->string('marrital');
            $table->enum('blood_type',['A', 'AB','B','0']);
            $table->string('zipcode');
            $table->enum('gender',['male', 'female']);
            $table->string('bank_account')->nullable();
            $table->string('npwp');
            $table->string('bank_branch');
            $table->string('bank_name')->nullable();
            $table->enum('job_status',['Active', 'Skorsing', 'Move', 'Retired', 'Fired']);
            $table->date('job_start');
            $table->date('job_end')->nullable();
            $table->integer('branch_id')->unsigned();
            $table->integer('company_id')->unsigned();
            $table->string('department_id');
            $table->string('position_id')->nullable();
            $table->string('grade')->nullable();
            $table->string('mother_name');
            $table->string('pic_id')->nullable();
            $table->boolean('is_user');
            $table->string('token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('user_departments', function(Blueprint $table){
            $table->string('id')->index();
            $table->primary('id');

            $table->string('name');
            $table->timestamps(); 
        });
        Schema::create('user_positions', function(Blueprint $table){
            $table->string('id')->index();
            $table->primary('id');
            
            $table->string('name');
            $table->string('department_id');
            $table->foreign('department_id')->references('id')->on('user_departments')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('user_families', function(Blueprint $table){
            $table->increments('id');
            $table->integer('employer_id');          
            $table->string('name');
            $table->date('birthday');
            $table->string('birthplace');
            $table->enum('gender', ['male', 'female']);
            $table->string('occupation');
            $table->enum('blood_type',['A', 'AB','B','0']);
            $table->timestamps();
        });
        // Schema::create('user_pictures', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('user_id');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        //     $table->string('filename');
        //     $table->string('original_name');
        //     $table->string('filetype');
        //     $table->string('filesize');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_positions');
        Schema::drop('user_departments');
        Schema::drop('user_families');
        // Schema::drop('user_pictures');
        Schema::drop('users');
    }
}
