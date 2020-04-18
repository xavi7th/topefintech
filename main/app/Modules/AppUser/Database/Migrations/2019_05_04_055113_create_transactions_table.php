<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('savings_id')->unsigned();
			$table->foreign('savings_id')->references('id')->on('savings')->onDelete('cascade');
			$table->enum('trans_type', ['deposit', 'withdrawal']);
			$table->double('amount');
			$table->string('description')->nullable();
			$table->timestamp('interest_processed_at')->useCurrent();

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
		Schema::dropIfExists('transactions');
	}
}
