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
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('savings_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
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
