<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class AutoSaveSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('auto_save_settings')->delete();
        
        \DB::table('auto_save_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'app_user_id' => 2,
                'amount' => 90000.0,
                'period' => 'daily',
                'date' => 15,
                'weekday' => 'Monday',
                'time' => '18:00:00',
                'try_other_cards' => 1,
                'created_at' => '2020-04-17 00:00:00',
                'updated_at' => '2020-04-17 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'app_user_id' => 2,
                'amount' => 90000.0,
                'period' => 'weekly',
                'date' => 9,
                'weekday' => 'Saturday',
                'time' => '01:00:00',
                'try_other_cards' => 0,
                'created_at' => '2020-04-14 00:00:00',
                'updated_at' => '2020-04-15 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'app_user_id' => 2,
                'amount' => 80000.0,
                'period' => 'weekly',
                'date' => 20,
                'weekday' => 'Friday',
                'time' => '23:00:00',
                'try_other_cards' => 0,
                'created_at' => '2020-04-12 00:00:00',
                'updated_at' => '2020-04-14 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'app_user_id' => 2,
                'amount' => 90000.0,
                'period' => 'monthly',
                'date' => 11,
                'weekday' => 'Monday',
                'time' => '01:00:00',
                'try_other_cards' => 0,
                'created_at' => '2020-04-10 00:00:00',
                'updated_at' => '2020-04-13 00:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'app_user_id' => 2,
                'amount' => 40000.0,
                'period' => 'daily',
                'date' => 1,
                'weekday' => 'Thursday',
                'time' => '22:00:00',
                'try_other_cards' => 0,
                'created_at' => '2020-04-08 00:00:00',
                'updated_at' => '2020-04-11 00:00:00',
            ),
        ));

        
    }
}