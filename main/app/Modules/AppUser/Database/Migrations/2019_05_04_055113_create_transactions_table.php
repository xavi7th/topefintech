<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('transactions', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('savings_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->enum('trans_type', ['deposit', 'withdrawal']);
      $table->double('amount');
      $table->string('description')->nullable();
      $table->timestamp('interest_processed_at')->useCurrent();
      $table->boolean('yields_interests')->default(true);

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
    Schema::dropIfExists('transactions');
  }
}
