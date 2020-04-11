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
                'app_user_id' => 2,
                'type' => 'core',
                'gos_type_id' => NULL,
                'maturity_date' => NULL,
                'current_balance' => 53000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
            ),
            1 => 
            array (
                'app_user_id' => 2,
                'type' => 'locked',
                'gos_type_id' => NULL,
                'maturity_date' => '2020-11-11 17:53:09',
                'current_balance' => 162500.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 25.0,
            ),
            2 => 
            array (
                'app_user_id' => 2,
                'type' => 'locked',
                'gos_type_id' => NULL,
                'maturity_date' => '2020-11-11 17:53:11',
                'current_balance' => 94500.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 15.0,
            ),
            3 => 
            array (
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 2,
                'maturity_date' => '2021-02-11 17:53:24',
                'current_balance' => 94000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 30.0,
            ),
            4 => 
            array (
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 1,
                'maturity_date' => '2021-02-11 17:53:26',
                'current_balance' => 28000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
            ),
            5 => 
            array (
                'app_user_id' => 2,
                'type' => 'gos',
                'gos_type_id' => 3,
                'maturity_date' => '2021-02-11 17:53:27',
                'current_balance' => 33000.0,
                'funded_at' => '2020-04-11 19:11:20',
                'savings_distribution' => 10.0,
            ),
        ));

        
    }
}