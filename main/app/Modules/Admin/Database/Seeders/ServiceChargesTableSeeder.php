<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class ServiceChargesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('service_charges')->delete();

    \DB::table('service_charges')->insert(array(
      0 =>
      array(
        'id' => 1,
        'savings_id' => 2,
        'amount' => 3322.5,
        'description' => 'Amount deducted for breaking target funds',
        'is_processed' => 0,
        'created_at' => '2020-04-16 05:03:20',
        'updated_at' => '2020-04-16 05:03:20',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'id' => 2,
        'savings_id' => 1,
        'amount' => 1000.0,
        'description' => 'Amount deducted for multiple consecutive withdrawals',
        'is_processed' => 0,
        'created_at' => '2020-04-16 05:21:12',
        'updated_at' => '2020-04-16 05:21:12',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'id' => 3,
        'savings_id' => 1,
        'amount' => 1000.0,
        'description' => 'Amount deducted for multiple consecutive withdrawals',
        'is_processed' => 0,
        'created_at' => '2020-04-16 05:25:42',
        'updated_at' => '2020-04-16 05:25:42',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'id' => 4,
        'savings_id' => 1,
        'amount' => 1500.0,
        'description' => 'Amount deducted for multiple consecutive withdrawals',
        'is_processed' => 0,
        'created_at' => '2020-04-16 05:26:05',
        'updated_at' => '2020-04-16 05:26:05',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'id' => 5,
        'savings_id' => 1,
        'amount' => 3000.0,
        'description' => 'Amount deducted for multiple consecutive withdrawals',
        'is_processed' => 0,
        'created_at' => '2020-04-16 05:26:13',
        'updated_at' => '2020-04-16 05:26:13',
        'deleted_at' => NULL,
      ),
    ));
  }
}
