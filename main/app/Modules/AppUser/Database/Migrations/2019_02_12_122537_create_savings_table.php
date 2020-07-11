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
      $table->foreign('app_user_id')->references('id')->on('app_users')->onDelete('cascade')->onUpdate('cascade');
      $table->string('type')->default('smart');
      $table->bigInteger('target_type_id')->nullable()->unsigned();
      $table->foreign('target_type_id')->references('id')->on('target_types')->onDelete('no action')->onUpdate('cascade');
      $table->timestamp('maturity_date')->nullable();
      $table->double('current_balance')->default(0);
      $table->timestamp('funded_at')->nullable();


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
