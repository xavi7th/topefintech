<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSavingsInterestsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('savings_interests', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->bigInteger('savings_id')->unsigned();
      $table->foreign('savings_id')->references('id')->on('savings')->onDelete('cascade')->onUpdate('cascade');
      $table->double('amount');
      $table->string('description')->nullable();
      $table->timestamp('processed_at')->nullable();
      $table->enum('process_type', ['withdrawn', 'compounded', 'liquidated'])->nullable();
      $table->boolean('is_locked')->default(true);


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
    Schema::dropIfExists('savings_interests');
  }
}
