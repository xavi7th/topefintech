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
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('app_user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('savings_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->double('amount')->nullable();
      $table->string('description')->nullable();
      $table->boolean('is_user_verified')->default(false);
      $table->boolean('is_processed')->default(false);
      $table->boolean('is_charge_free');
      $table->unsignedBigInteger('processed_by')->nullable();
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
