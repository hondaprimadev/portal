<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoFinanceSupportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memo_finance_supports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('memo_id')->unsigned();
            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');
            $table->string('group_leasing');
            $table->double('total');
            $table->text('notes');
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
        Schema::drop('memo_finance_supports');
    }
}
