<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsInterestsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('savings_interests', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('savings_id')->unsigned();
			$table->foreign('savings_id')->references('id')->on('savings')->onDelete('cascade');
			$table->double('amount');
			$table->boolean('is_cleared')->default(false);


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
		Schema::dropIfExists('savings_interests');
	}
}
