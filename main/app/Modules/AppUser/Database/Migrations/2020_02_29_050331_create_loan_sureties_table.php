<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSuretiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loan_sureties', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('lender_id');
			$table->foreign('lender_id')->references('id')->on('users')->onDelete('cascade');
			$table->unsignedBigInteger('surety_id');
			$table->foreign('surety_id')->references('id')->on('users')->onDelete('cascade');
			$table->unsignedBigInteger('loan_request_id');
			$table->foreign('loan_request_id')->references('id')->on('loan_requests')->onDelete('cascade');
			$table->boolean('is_surety_accepted')->nullable();

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
		Schema::dropIfExists('loan_sureties');
	}
}
