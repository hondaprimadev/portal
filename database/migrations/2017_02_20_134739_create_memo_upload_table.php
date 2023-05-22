<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_memo');
            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('file_size');
            $table->integer('branch_id');
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
        Schema::drop('memo_uploads');
    }
}
