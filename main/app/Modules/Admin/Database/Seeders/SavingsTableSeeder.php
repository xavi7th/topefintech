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
        
        \DB::table('savings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'app_user_id' => 2,
                'type' => 'core',
                'gos_type_id' => NULL,
                'maturity_date' => NULL,
                'current_balance' => 60290.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
                'created_at' => NULL,
                'updated_at' => '2020-04-16 05:26:10',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'app_user_id' => 2,
                'type' => 'locked',
                'gos_type_id' => NULL,
                'maturity_date' => '2020-11-11 17:53:09',
                'current_balance' => 211612.5,
                'funded_at' => '2020-02-11 19:11:20',
                'savings_distribution' => 25.0,
                'created_at' => NULL,
                'updated_at' => '2020-04-16 05:03:20',
                'deleted_at' => '2020-04-16 05:03:20',
            ),
            2 => 
            array (
                'id' => 3,
                'app_user_id' => 2,
                'type' => 'locked',
                'gos_type_id' => NULL,
                'maturity_date' => '2020-11-11 17:53:11',
                'current_balance' => 114000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 15.0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 2,
                'maturity_date' => '2021-02-11 17:53:24',
                'current_balance' => 133000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 30.0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 1,
                'maturity_date' => '2021-02-11 17:53:26',
                'current_balance' => 41000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 3,
                'maturity_date' => '2021-02-11 17:53:27',
                'current_balance' => 46000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));

        
    }
}