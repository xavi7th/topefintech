<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMessagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('messages', function (Blueprint $table) {
      $table->dropColumn('subject');
      $table->string('first_name')->nullable()->after('id');
      $table->string('last_name')->nullable()->after('first_name');
      $table->string('address')->nullable()->after('email');
      $table->text('message')->after('address');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('messages', function (Blueprint $table) {
      $table->string('subject');
      $table->dropColumn('address');
      $table->dropColumn('first_name');
      $table->dropColumn('last_name');
      $table->dropColumn('message');
    });
  }
}
