<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class TargetTypesTableSeeder extends Seeder
{

  /**
   * Auto generated seed file
   *
   * @return void
   */
  public function run()
  {


    \DB::table('target_types')->delete();

    \DB::table('target_types')->insert(array(
      0 =>
      array(
        'id' => 1,
        'name' => 'Birthday',
        'created_at' => '2020-04-17 00:00:00',
        'updated_at' => '2020-04-17 00:00:00',
      ),
      1 =>
      array(
        'id' => 2,
        'name' => 'Exam Sorting',
        'created_at' => '2020-04-15 00:00:00',
        'updated_at' => '2020-04-15 00:00:00',
      ),
      2 =>
      array(
        'id' => 3,
        'name' => 'House Rent',
        'created_at' => '2020-04-13 00:00:00',
        'updated_at' => '2020-04-13 00:00:00',
      ),
      3 =>
      array(
        'id' => 4,
        'name' => 'Babe´s Birthday',
        'created_at' => '2020-04-11 00:00:00',
        'updated_at' => '2020-04-11 00:00:00',
      ),
      4 =>
      array(
        'id' => 5,
        'name' => 'Marriage',
        'created_at' => '2020-04-10 00:00:00',
        'updated_at' => '2020-04-10 00:00:00',
      ),
      5 =>
      array(
        'id' => 6,
        'name' => 'New Car',
        'created_at' => '2020-04-08 00:00:00',
        'updated_at' => '2020-04-08 00:00:00',
      ),
      6 =>
      array(
        'id' => 7,
        'name' => 'New Shoes',
        'created_at' => '2020-04-06 00:00:00',
        'updated_at' => '2020-04-06 00:00:00',
      ),
      7 =>
      array(
        'id' => 8,
        'name' => 'NYSC',
        'created_at' => '2020-04-05 00:00:00',
        'updated_at' => '2020-04-04 00:00:00',
      ),
      8 =>
      array(
        'id' => 9,
        'name' => 'School Fees',
        'created_at' => '2020-04-03 00:00:00',
        'updated_at' => '2020-04-03 00:00:00',
      ),
    ));
  }
}
