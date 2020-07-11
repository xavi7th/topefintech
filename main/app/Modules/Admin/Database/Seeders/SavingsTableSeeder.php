<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class SavingsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('savings')->delete();

    \DB::table('savings')->insert(array(
      0 =>
      array(
        'id' => 1,
        'app_user_id' => 2,
        'type' => 'smart',
        'target_type_id' => NULL,
        'maturity_date' => NULL,
        'current_balance' => 119290.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-17 00:00:00',
        'updated_at' => '2020-04-19 10:38:12',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'id' => 2,
        'app_user_id' => 2,
        'type' => 'target',
        'target_type_id' => NULL,
        'maturity_date' => '2020-11-11 17:53:09',
        'current_balance' => 285362.5,
        'funded_at' => '2020-02-11 19:11:20',
        'created_at' => '2020-04-14 00:00:00',
        'updated_at' => '2020-04-19 10:38:12',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'id' => 3,
        'app_user_id' => 2,
        'type' => 'target',
        'target_type_id' => NULL,
        'maturity_date' => '2020-11-11 17:53:11',
        'current_balance' => 246750.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-12 00:00:00',
        'updated_at' => '2020-04-19 10:38:12',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'id' => 4,
        'app_user_id' => 1,
        'type' => 'target',
        'target_type_id' => 2,
        'maturity_date' => '2021-02-11 17:53:24',
        'current_balance' => 153000.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-10 00:00:00',
        'updated_at' => '2020-04-19 10:25:19',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'id' => 5,
        'app_user_id' => 2,
        'type' => 'target',
        'target_type_id' => 1,
        'maturity_date' => '2021-02-11 17:53:26',
        'current_balance' => 70500.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-07 00:00:00',
        'updated_at' => '2020-04-19 10:38:12',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'id' => 6,
        'app_user_id' => 3,
        'type' => 'target',
        'target_type_id' => 3,
        'maturity_date' => '2021-02-11 17:53:27',
        'current_balance' => 286000.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-05 00:00:00',
        'updated_at' => '2020-04-19 10:18:48',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'id' => 7,
        'app_user_id' => 3,
        'type' => 'smart',
        'target_type_id' => NULL,
        'maturity_date' => NULL,
        'current_balance' => 140290.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-17 00:00:00',
        'updated_at' => '2020-04-19 10:18:48',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'id' => 8,
        'app_user_id' => 1,
        'type' => 'smart',
        'target_type_id' => NULL,
        'maturity_date' => NULL,
        'current_balance' => 80290.0,
        'funded_at' => '2020-04-11 19:11:20',
        'created_at' => '2020-04-17 00:00:00',
        'updated_at' => '2020-04-19 10:25:19',
        'deleted_at' => NULL,
      ),
    ));
  }
}
