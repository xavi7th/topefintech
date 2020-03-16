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
			$table->string('loan_ref')->unique();
			$table->unsignedBigInteger('app_user_id');
			$table->foreign('app_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->double('amount');
			$table->datetime('expires_at');
			$table->double('interest_rate');
			$table->string('repayment_installation_duration');
			$table->boolean('auto_debit')->default(false);
			$table->boolean('is_approved')->default(false);
			$table->boolean('is_disbursed')->default(false);
			$table->boolean('is_paid')->default(false);

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
		Schema::dropIfExists('loan_requests');
	}
}
