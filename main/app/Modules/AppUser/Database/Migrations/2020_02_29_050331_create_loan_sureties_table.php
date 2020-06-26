<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanSuretiesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('loan_sureties', function (Blueprint $table) {
      $table->id();
      $table->foreignId('lender_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('surety_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
      $table->foreignId('loan_request_id')->constrained('loan_requests')->onDelete('cascade')->onUpdate('cascade');
      $table->boolean('is_surety_accepted')->nullable();

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
    Schema::dropIfExists('loan_sureties');
  }
}
