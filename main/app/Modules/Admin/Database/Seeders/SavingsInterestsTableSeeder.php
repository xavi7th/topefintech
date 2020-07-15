<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class SavingsInterestsTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('savings_interests')->delete();

    \DB::table('savings_interests')->insert(array(
      0 =>
      array(
        'id' => 1,
        'savings_id' => 1,
        'amount' => 105.0,
        'is_locked' => 1,
        'created_at' => '2020-04-17 00:00:00',
        'updated_at' => '2020-04-17 00:00:00',
        'deleted_at' => NULL,
      ),
      1 =>
      array(
        'id' => 2,
        'savings_id' => 2,
        'amount' => 1725.0,
        'is_locked' => 1,
        'created_at' => '2020-04-15 00:00:00',
        'updated_at' => '2020-04-14 00:00:00',
        'deleted_at' => NULL,
      ),
      2 =>
      array(
        'id' => 3,
        'savings_id' => 3,
        'amount' => 990.0,
        'is_locked' => 1,
        'created_at' => '2020-04-14 00:00:00',
        'updated_at' => '2020-04-12 00:00:00',
        'deleted_at' => NULL,
      ),
      3 =>
      array(
        'id' => 4,
        'savings_id' => 4,
        'amount' => 217.5,
        'is_locked' => 1,
        'created_at' => '2020-04-13 00:00:00',
        'updated_at' => '2020-04-09 00:00:00',
        'deleted_at' => NULL,
      ),
      4 =>
      array(
        'id' => 5,
        'savings_id' => 5,
        'amount' => 67.5,
        'is_locked' => 1,
        'created_at' => '2020-04-12 00:00:00',
        'updated_at' => '2020-04-07 00:00:00',
        'deleted_at' => NULL,
      ),
      5 =>
      array(
        'id' => 6,
        'savings_id' => 6,
        'amount' => 210.0,
        'is_locked' => 1,
        'created_at' => '2020-04-11 00:00:00',
        'updated_at' => '2020-04-05 00:00:00',
        'deleted_at' => NULL,
      ),
      6 =>
      array(
        'id' => 7,
        'savings_id' => 1,
        'amount' => 105.0,
        'is_locked' => 1,
        'created_at' => '2020-04-09 00:00:00',
        'updated_at' => '2020-04-02 00:00:00',
        'deleted_at' => NULL,
      ),
      7 =>
      array(
        'id' => 8,
        'savings_id' => 2,
        'amount' => 1725.0,
        'is_locked' => 1,
        'created_at' => '2020-04-08 00:00:00',
        'updated_at' => '2020-03-31 00:00:00',
        'deleted_at' => NULL,
      ),
      8 =>
      array(
        'id' => 9,
        'savings_id' => 3,
        'amount' => 990.0,
        'is_locked' => 1,
        'created_at' => '2020-04-07 00:00:00',
        'updated_at' => '2020-03-28 00:00:00',
        'deleted_at' => NULL,
      ),
      9 =>
      array(
        'id' => 10,
        'savings_id' => 4,
        'amount' => 217.5,
        'is_locked' => 1,
        'created_at' => '2020-04-06 00:00:00',
        'updated_at' => '2020-03-26 00:00:00',
        'deleted_at' => NULL,
      ),
      10 =>
      array(
        'id' => 11,
        'savings_id' => 5,
        'amount' => 67.5,
        'is_locked' => 1,
        'created_at' => '2020-04-05 00:00:00',
        'updated_at' => '2020-03-24 00:00:00',
        'deleted_at' => NULL,
      ),
      11 =>
      array(
        'id' => 12,
        'savings_id' => 6,
        'amount' => 210.0,
        'is_locked' => 1,
        'created_at' => '2020-04-04 00:00:00',
        'updated_at' => '2020-03-21 00:00:00',
        'deleted_at' => NULL,
      ),
      12 =>
      array(
        'id' => 13,
        'savings_id' => 1,
        'amount' => 105.0,
        'is_locked' => 1,
        'created_at' => '2020-04-02 00:00:00',
        'updated_at' => '2020-03-19 00:00:00',
        'deleted_at' => NULL,
      ),
      13 =>
      array(
        'id' => 14,
        'savings_id' => 2,
        'amount' => 1725.0,
        'is_locked' => 1,
        'created_at' => '2020-04-01 00:00:00',
        'updated_at' => '2020-03-17 00:00:00',
        'deleted_at' => NULL,
      ),
      14 =>
      array(
        'id' => 15,
        'savings_id' => 3,
        'amount' => 990.0,
        'is_locked' => 1,
        'created_at' => '2020-03-31 00:00:00',
        'updated_at' => '2020-03-14 00:00:00',
        'deleted_at' => NULL,
      ),
      15 =>
      array(
        'id' => 16,
        'savings_id' => 4,
        'amount' => 217.5,
        'is_locked' => 1,
        'created_at' => '2020-03-30 00:00:00',
        'updated_at' => '2020-03-12 00:00:00',
        'deleted_at' => NULL,
      ),
      16 =>
      array(
        'id' => 17,
        'savings_id' => 5,
        'amount' => 67.5,
        'is_locked' => 1,
        'created_at' => '2020-03-29 00:00:00',
        'updated_at' => '2020-03-09 00:00:00',
        'deleted_at' => NULL,
      ),
      17 =>
      array(
        'id' => 18,
        'savings_id' => 6,
        'amount' => 210.0,
        'is_locked' => 1,
        'created_at' => '2020-03-28 00:00:00',
        'updated_at' => '2020-03-07 00:00:00',
        'deleted_at' => NULL,
      ),
      18 =>
      array(
        'id' => 19,
        'savings_id' => 1,
        'amount' => 180.0,
        'is_locked' => 1,
        'created_at' => '2020-03-26 00:00:00',
        'updated_at' => '2020-03-05 00:00:00',
        'deleted_at' => NULL,
      ),
      19 =>
      array(
        'id' => 20,
        'savings_id' => 2,
        'amount' => 1912.5,
        'is_locked' => 1,
        'created_at' => '2020-03-25 00:00:00',
        'updated_at' => '2020-03-02 00:00:00',
        'deleted_at' => NULL,
      ),
      20 =>
      array(
        'id' => 21,
        'savings_id' => 3,
        'amount' => 1102.5,
        'is_locked' => 1,
        'created_at' => '2020-03-24 00:00:00',
        'updated_at' => '2020-02-29 00:00:00',
        'deleted_at' => NULL,
      ),
      21 =>
      array(
        'id' => 22,
        'savings_id' => 4,
        'amount' => 442.5,
        'is_locked' => 1,
        'created_at' => '2020-03-23 00:00:00',
        'updated_at' => '2020-02-27 00:00:00',
        'deleted_at' => NULL,
      ),
      22 =>
      array(
        'id' => 23,
        'savings_id' => 5,
        'amount' => 142.5,
        'is_locked' => 1,
        'created_at' => '2020-03-22 00:00:00',
        'updated_at' => '2020-02-24 00:00:00',
        'deleted_at' => NULL,
      ),
      23 =>
      array(
        'id' => 24,
        'savings_id' => 6,
        'amount' => 285.0,
        'is_locked' => 1,
        'created_at' => '2020-03-21 00:00:00',
        'updated_at' => '2020-02-22 00:00:00',
        'deleted_at' => NULL,
      ),
      24 =>
      array(
        'id' => 25,
        'savings_id' => 1,
        'amount' => 330.0,
        'is_locked' => 1,
        'created_at' => '2020-03-19 00:00:00',
        'updated_at' => '2020-02-19 00:00:00',
        'deleted_at' => NULL,
      ),
      25 =>
      array(
        'id' => 26,
        'savings_id' => 2,
        'amount' => 2287.5,
        'is_locked' => 1,
        'created_at' => '2020-03-18 00:00:00',
        'updated_at' => '2020-02-17 00:00:00',
        'deleted_at' => NULL,
      ),
      26 =>
      array(
        'id' => 27,
        'savings_id' => 3,
        'amount' => 1327.5,
        'is_locked' => 1,
        'created_at' => '2020-03-17 00:00:00',
        'updated_at' => '2020-02-15 00:00:00',
        'deleted_at' => NULL,
      ),
      27 =>
      array(
        'id' => 28,
        'savings_id' => 4,
        'amount' => 892.5,
        'is_locked' => 1,
        'created_at' => '2020-03-16 00:00:00',
        'updated_at' => '2020-02-12 00:00:00',
        'deleted_at' => NULL,
      ),
      28 =>
      array(
        'id' => 29,
        'savings_id' => 5,
        'amount' => 292.5,
        'is_locked' => 1,
        'created_at' => '2020-03-15 00:00:00',
        'updated_at' => '2020-02-10 00:00:00',
        'deleted_at' => NULL,
      ),
      29 =>
      array(
        'id' => 30,
        'savings_id' => 6,
        'amount' => 435.0,
        'is_locked' => 1,
        'created_at' => '2020-03-13 00:00:00',
        'updated_at' => '2020-02-08 00:00:00',
        'deleted_at' => NULL,
      ),
      30 =>
      array(
        'id' => 31,
        'savings_id' => 1,
        'amount' => 360.0,
        'is_locked' => 1,
        'created_at' => '2020-03-12 00:00:00',
        'updated_at' => '2020-02-05 00:00:00',
        'deleted_at' => NULL,
      ),
      31 =>
      array(
        'id' => 32,
        'savings_id' => 2,
        'amount' => 2362.5,
        'is_locked' => 1,
        'created_at' => '2020-03-11 00:00:00',
        'updated_at' => '2020-02-03 00:00:00',
        'deleted_at' => NULL,
      ),
      32 =>
      array(
        'id' => 33,
        'savings_id' => 3,
        'amount' => 1372.5,
        'is_locked' => 1,
        'created_at' => '2020-03-10 00:00:00',
        'updated_at' => '2020-01-31 00:00:00',
        'deleted_at' => NULL,
      ),
      33 =>
      array(
        'id' => 34,
        'savings_id' => 4,
        'amount' => 982.5,
        'is_locked' => 1,
        'created_at' => '2020-03-09 00:00:00',
        'updated_at' => '2020-01-29 00:00:00',
        'deleted_at' => NULL,
      ),
      34 =>
      array(
        'id' => 35,
        'savings_id' => 5,
        'amount' => 322.5,
        'is_locked' => 1,
        'created_at' => '2020-03-08 00:00:00',
        'updated_at' => '2020-01-27 00:00:00',
        'deleted_at' => NULL,
      ),
      35 =>
      array(
        'id' => 36,
        'savings_id' => 6,
        'amount' => 465.0,
        'is_locked' => 1,
        'created_at' => '2020-03-06 00:00:00',
        'updated_at' => '2020-01-24 00:00:00',
        'deleted_at' => NULL,
      ),
      36 =>
      array(
        'id' => 37,
        'savings_id' => 1,
        'amount' => 390.0,
        'is_locked' => 1,
        'created_at' => '2020-03-05 00:00:00',
        'updated_at' => '2020-01-22 00:00:00',
        'deleted_at' => NULL,
      ),
      37 =>
      array(
        'id' => 38,
        'savings_id' => 2,
        'amount' => 2437.5,
        'is_locked' => 1,
        'created_at' => '2020-03-04 00:00:00',
        'updated_at' => '2020-01-20 00:00:00',
        'deleted_at' => NULL,
      ),
      38 =>
      array(
        'id' => 39,
        'savings_id' => 3,
        'amount' => 1417.5,
        'is_locked' => 1,
        'created_at' => '2020-03-03 00:00:00',
        'updated_at' => '2020-01-17 00:00:00',
        'deleted_at' => NULL,
      ),
      39 =>
      array(
        'id' => 40,
        'savings_id' => 4,
        'amount' => 1072.5,
        'is_locked' => 1,
        'created_at' => '2020-03-02 00:00:00',
        'updated_at' => '2020-01-15 00:00:00',
        'deleted_at' => NULL,
      ),
      40 =>
      array(
        'id' => 41,
        'savings_id' => 5,
        'amount' => 352.5,
        'is_locked' => 1,
        'created_at' => '2020-03-01 00:00:00',
        'updated_at' => '2020-01-12 00:00:00',
        'deleted_at' => NULL,
      ),
      41 =>
      array(
        'id' => 42,
        'savings_id' => 6,
        'amount' => 495.0,
        'is_locked' => 1,
        'created_at' => '2020-02-28 00:00:00',
        'updated_at' => '2020-01-10 00:00:00',
        'deleted_at' => NULL,
      ),
      42 =>
      array(
        'id' => 43,
        'savings_id' => 1,
        'amount' => 390.0,
        'is_locked' => 1,
        'created_at' => '2020-02-27 00:00:00',
        'updated_at' => '2020-01-08 00:00:00',
        'deleted_at' => NULL,
      ),
      43 =>
      array(
        'id' => 44,
        'savings_id' => 2,
        'amount' => 2437.5,
        'is_locked' => 1,
        'created_at' => '2020-02-26 00:00:00',
        'updated_at' => '2020-01-05 00:00:00',
        'deleted_at' => NULL,
      ),
      44 =>
      array(
        'id' => 45,
        'savings_id' => 3,
        'amount' => 1417.5,
        'is_locked' => 1,
        'created_at' => '2020-02-25 00:00:00',
        'updated_at' => '2020-01-03 00:00:00',
        'deleted_at' => NULL,
      ),
      45 =>
      array(
        'id' => 46,
        'savings_id' => 4,
        'amount' => 1072.5,
        'is_locked' => 1,
        'created_at' => '2020-02-24 00:00:00',
        'updated_at' => '2019-12-31 00:00:00',
        'deleted_at' => NULL,
      ),
      46 =>
      array(
        'id' => 47,
        'savings_id' => 5,
        'amount' => 352.5,
        'is_locked' => 1,
        'created_at' => '2020-02-23 00:00:00',
        'updated_at' => '2019-12-29 00:00:00',
        'deleted_at' => NULL,
      ),
      47 =>
      array(
        'id' => 48,
        'savings_id' => 6,
        'amount' => 495.0,
        'is_locked' => 1,
        'created_at' => '2020-02-21 00:00:00',
        'updated_at' => '2019-12-27 00:00:00',
        'deleted_at' => NULL,
      ),
    ));
  }
}
