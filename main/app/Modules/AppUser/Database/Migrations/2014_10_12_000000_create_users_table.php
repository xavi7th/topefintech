<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('full_name');
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('country')->default('Nigeria');
			$table->string('acc_num')->nullable();
			$table->string('acc_bank')->nullable();
			$table->string('acc_type')->nullable();
			$table->string('bvn')->nullable();
			$table->boolean('is_bvn_verified')->default(false);
			$table->string('id_card')->nullable();
			$table->timestamp('verified_at')->nullable();
			$table->boolean('can_withdraw')->default(false);
			$table->boolean('is_active')->default(true);

			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
