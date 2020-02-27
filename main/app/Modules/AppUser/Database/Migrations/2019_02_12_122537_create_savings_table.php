<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('savings', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('app_user_id')->unsigned();
			$table->foreign('app_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('type')->default('core');
			$table->bigInteger('gos_type_id')->nullable()->unsigned();
			$table->foreign('gos_type_id')->references('id')->on('gos_types')->onDelete('set null');
			$table->timestamp('maturity_date')->nullable();
			$table->double('current_balance')->default(0);
			$table->timestamp('funded_at')->nullable();
			$table->double('savings_distribution')->default(0);


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
		Schema::dropIfExists('savings');
	}
}
