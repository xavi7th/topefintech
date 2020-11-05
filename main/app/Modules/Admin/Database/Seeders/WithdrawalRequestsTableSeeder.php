<?php

namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class WithdrawalRequestsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('withdrawal_requests')->delete();

    \DB::table('withdrawal_requests')->insert(array(
      0 =>
      array(
        'id' => 1,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 36000.0,
        'is_processed' => 0,
        'is_charge_free' => 1,
        'processed_by' => NULL,
        'processor_type' => NULL,
        'created_at' => '2020-04-14 20:36:20',
        'updated_at' => '2020-04-16 05:08:25',
        'deleted_at' => '2020-04-16 05:08:25',
      ),
      1 =>
      array(
        'id' => 2,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 30000.0,
        'is_processed' => 0,
        'is_charge_free' => 1,
        'processed_by' => NULL,
        'processor_type' => NULL,
        'created_at' => '2020-04-16 05:09:43',
        'updated_at' => '2020-04-16 05:09:51',
        'deleted_at' => '2020-04-16 05:09:51',
      ),
      2 =>
      array(
        'id' => 3,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 70000.0,
        'is_processed' => 1,
        'is_charge_free' => 1,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:10:07',
        'updated_at' => '2020-04-16 05:10:51',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'id' => 4,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 50000.0,
        'is_processed' => 1,
        'is_charge_free' => 0,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:11:46',
        'updated_at' => '2020-04-16 05:12:08',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'id' => 5,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 20000.0,
        'is_processed' => 1,
        'is_charge_free' => 0,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:20:57',
        'updated_at' => '2020-04-16 05:21:12',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'id' => 6,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 20000.0,
        'is_processed' => 1,
        'is_charge_free' => 0,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:25:29',
        'updated_at' => '2020-04-16 05:25:42',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'id' => 7,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 30000.0,
        'is_processed' => 1,
        'is_charge_free' => 0,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:25:55',
        'updated_at' => '2020-04-16 05:26:05',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'id' => 8,
        'app_user_id' => 2,
        'savings_id' => random_int(1, 8),
        'amount' => 60000.0,
        'is_processed' => 1,
        'is_charge_free' => 0,
        'processed_by' => 1,
        'processor_type' => 'App\\Modules\\Admin\\Models\\Admin',
        'created_at' => '2020-04-16 05:26:10',
        'updated_at' => '2020-04-16 05:26:13',
        'deleted_at' => NULL,
      ),
    ));
  }
}
