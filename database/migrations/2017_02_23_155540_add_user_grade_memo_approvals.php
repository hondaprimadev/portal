<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserGradeMemoApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memo_approvals', function (Blueprint $table) {
            $table->string('user_grade');
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
            $table->dropColumn('user_grade');
        });
    }
}
