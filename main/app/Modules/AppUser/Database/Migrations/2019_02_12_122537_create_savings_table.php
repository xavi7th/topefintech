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
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('app_user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->string('type')->default('smart');
      $table->unsignedBigInteger('portfolio_id')->nullable();
      $table->string('portfolio_type')->nullable();
      $table->timestamp('maturity_date')->nullable();
      $table->double('current_balance')->default(0);
      $table->timestamp('funded_at')->nullable();
      $table->boolean('is_liquidated')->default(false);
      $table->boolean('interests_withdrawable')->default(false);
      $table->timestamp('interests_unlocked_at')->nullable();
      $table->timestamp('interests_compounded_at')->nullable();
      $table->timestamp('withdrawn_at')->nullable();


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
