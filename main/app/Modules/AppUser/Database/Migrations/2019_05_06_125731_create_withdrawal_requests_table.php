<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalRequestsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('withdrawal_requests', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('app_user_id')->unsigned();
      $table->foreign('app_user_id')->references('id')->on('app_users')->onDelete('cascade')->onUpdate('cascade');
      $table->double('amount')->nullable();
      $table->string('description')->nullable();
      $table->boolean('is_processed')->default(false);
      $table->boolean('is_charge_free');
      $table->bigInteger('processed_by')->nullable();
      $table->string('processor_type')->nullable();

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
    Schema::dropIfExists('withdrawal_requests');
  }
}
