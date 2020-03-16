<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loan_transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('loan_request_id');
			$table->foreign('loan_request_id')->references('id')->on('loan_requests')->onDelete('cascade');
			$table->double('amount');
			$table->enum('trans_type', ['loan', 'repayment']);

			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('loan_transactions');
	}
}
