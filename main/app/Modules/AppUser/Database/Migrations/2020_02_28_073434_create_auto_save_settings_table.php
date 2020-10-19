<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoSaveSettingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('auto_save_settings', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->id();
      $table->foreignId('app_user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
      $table->double('amount');
      $table->enum('period', ['daily', 'weekly', 'monthly', 'quarterly']);
      $table->integer('date')->nullable();
      $table->string('weekday')->nullable();
      $table->time('time')->nullable();
      $table->boolean('try_other_cards')->default(false);
      $table->timestamp('processed_at')->useCurrent();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('auto_save_settings');
  }
}
