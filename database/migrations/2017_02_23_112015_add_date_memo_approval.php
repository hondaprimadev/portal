<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateMemoApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memo_approvals', function (Blueprint $table) {
            $table->date('inv_date1');
            $table->date('inv_date2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memo_approvals', function (Blueprint $table) {
            $table->dropColumn('inv_date1');
            $table->dropColumn('inv_date2');
        });
    }
}
