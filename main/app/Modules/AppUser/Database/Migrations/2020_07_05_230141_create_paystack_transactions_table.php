<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystackTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('paystack_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('app_user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
      $table->double('amount');
      $table->string('description');
      $table->string('transaction_reference');
      $table->longText('paystack_response')->nullable();

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
    Schema::dropIfExists('paystack_transactions');
  }
}
