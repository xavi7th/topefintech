<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentWalletTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('agent_wallet_transactions', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('agent_id')->constrained()->onDelete('cascade');
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
    Schema::dropIfExists('agent_wallet_transactions');
  }
}
