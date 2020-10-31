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
    Schema::create('app_users', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->id();
      $table->string('full_name');
      $table->string('email')->nullable()->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('phone')->nullable();
      $table->string('address')->nullable();
      $table->string('city')->nullable();
      $table->string('country')->default('Nigeria');
      $table->date('date_of_birth')->nullable();
      $table->string('gender')->nullable();
      $table->string('acc_num')->nullable();
      $table->string('acc_name')->nullable();
      $table->string('acc_bank')->nullable();
      $table->string('acc_type')->nullable();
      $table->string('paystack_nuban')->nullable();
      $table->string('paystack_nuban_name')->nullable();
      $table->string('paystack_nuban_bank')->nullable();
      $table->string('bvn')->nullable();
      $table->string('bvn_name')->nullable();
      $table->boolean('is_bvn_verified')->default(false);
      $table->boolean('is_bank_verified')->default(false);
      $table->string('id_card')->nullable();
      $table->timestamp('verified_at')->nullable();
      $table->boolean('can_withdraw')->default(false);
      $table->boolean('is_active')->default(true);
      $table->foreignId('agent_id')->nullable()->constrained()->onDelete('cascade');

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
    Schema::dropIfExists('app_users');
  }
}
