<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRequestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('loan_requests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('app_user_id');
			$table->foreign('app_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->double('amount');

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
		Schema::dropIfExists('loan_requests');
	}
}
