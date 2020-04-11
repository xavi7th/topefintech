<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebitCardsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debit_cards', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('app_user_id')->unsigned();
			$table->foreign('app_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->text('pan');
			$table->text('pan_hash');
			$table->string('month')->nullable();
			$table->string('year')->nullable();
			$table->text('cvv')->nullable();
			$table->text('cvv_hash')->nullable();
			$table->boolean('is_default')->default(false);

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
		Schema::dropIfExists('debit_cards');
	}
}
