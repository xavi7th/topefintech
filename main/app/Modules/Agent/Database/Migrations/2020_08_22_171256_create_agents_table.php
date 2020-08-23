<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('agents', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('ref_code')->nullable();
      $table->string('full_name');
      $table->string('email')->unique();
      $table->string('password');
      $table->string('phone')->unique()->nullable();
      $table->string('bvn')->nullable()->unique();
      $table->string('avatar')->nullable();
      $table->string('gender')->enum(['male', 'female'])->nullable();
      $table->string('address')->nullable();
      $table->date('dob')->nullable();
      $table->timestamp('verified_at')->nullable();

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
    Schema::dropIfExists('agents');
  }
}
