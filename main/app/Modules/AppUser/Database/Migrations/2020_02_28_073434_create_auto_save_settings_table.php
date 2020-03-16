<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoSaveSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('auto_save_settings', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('app_user_id')->unsigned();
			$table->foreign('app_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->double('amount');
			$table->enum('period', ['daily', 'weekly', 'monthly', 'quarterly']);
			$table->integer('date')->nullable();
			$table->string('weekday')->nullable();
			$table->time('time')->nullable();
			$table->boolean('try_other_cards')->default(false);

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
		Schema::dropIfExists('auto_save_settings');
	}
}