<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceChargesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('service_charges', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('savings_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
			$table->double('amount');
			$table->string('description');
			$table->boolean('is_processed')->default(false);


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
		Schema::dropIfExists('service_charges');
	}
}
