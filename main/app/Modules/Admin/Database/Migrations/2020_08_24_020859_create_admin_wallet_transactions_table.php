<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminWalletTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admin_wallet_transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('admin_id')->constrained('ythfg')->onDelete('cascade');
      $table->double('amount');
      $table->string('trans_type');
      $table->string('description');

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
    Schema::dropIfExists('admin_wallet_transactions');
  }
}
