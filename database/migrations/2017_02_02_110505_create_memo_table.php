<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_memo')->unique();
            $table->integer('category_id');
            $table->string('to_memo');
            $table->string('from_memo');
            $table->string('approval_memo');
            $table->text('subject_memo');
            $table->integer('last_approval_memo');
            $table->integer('last_revise_memo');
            $table->double('total_memo');
            $table->text('notes_memo');
            $table->string('status_memo');
            $table->integer('supplier_id');
            $table->integer('branch_id');
            $table->integer('company_id');
            $table->string('department_id');

            $table->boolean('prepayment_finish');
            $table->double('prepayment_total');
            $table->timestamps();
        });

        Schema::create('memo_sents', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('memo_id')->unsigned();
            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');
            
            $table->string('no_memo');
            $table->integer('category_id');
            $table->string('to_memo');
            $table->string('from_memo');
            $table->string('approval_memo');
            $table->text('subject_memo');
            $table->string('last_approval_memo');
            $table->string('last_revise_memo');
            $table->double('total_memo');
            $table->text('notes_memo');
            $table->string('status_memo');
            $table->integer('supplier_id');
            $table->integer('branch_id');
            $table->integer('company_id');
            $table->string('department_id');
            $table->boolean('prepayment_finish');
            $table->double('prepayment_total');
            $table->timestamps();
        });

        Schema::create('memo_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('department_id');
            $table->string('account_id');
            $table->timestamps();
        });

        Schema::create('memo_approvals', function (Blueprint $table) {
            $table->increments('id');
            // relation memo_categories
            $table->integer('category_id');
            $table->string('approval_path');
            $table->boolean('budget');
            $table->double('budget_total');
            $table->integer('branch_id');
            $table->string('user_approval');
            $table->boolean('prepayment');
            $table->timestamps();
        });

        Schema::create('memo_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('memo_id');
            $table->double('debet');
            $table->double('credit');
            $table->integer('branch_id');
            $table->integer('category_id');
            $table->integer('approval_id');
            $table->timestamps();
        });

        Schema::create('memo_details', function (Blueprint $table){
            $table->increments('id');

            $table->integer('memo_id')->unsigned();
            $table->foreign('memo_id')->references('id')->on('memos')->onDelete('cascade');

            $table->integer('category_id');
            $table->text('description');
            $table->integer('qty');
            $table->double('total');
            $table->date('date');
        });

        Schema::create('journal_accounts', function (Blueprint $table) {
            $table->string('id');
            $table->string('account_name');
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
        Schema::table('memos', function (Blueprint $table) {
            Schema::drop('journal_accounts');
            Schema::drop('memo_details');
            Schema::drop('memo_transactions');
            Schema::drop('memo_approvals');
            Schema::drop('memo_categories');
            Schema::drop('memo_sents');
            Schema::drop('memos');
        });
    }
}
