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
                'amount' => 5000.0,
                'period' => 'daily',
                'date' => NULL,
                'weekday' => '',
                'time' => '12:00:00',
                'try_other_cards' => 1,
                'processed_at' => '2020-04-19 12:51:46',
                'created_at' => '2020-04-17 00:00:00',
                'updated_at' => '2020-04-19 12:51:46',
            ),
            1 => 
            array (
                'id' => 2,
                'app_user_id' => 2,
                'amount' => 25000.0,
                'period' => 'weekly',
                'date' => NULL,
                'weekday' => 'Sunday',
                'time' => NULL,
                'try_other_cards' => 0,
                'processed_at' => '2020-04-19 12:53:04',
                'created_at' => '2020-04-14 00:00:00',
                'updated_at' => '2020-04-19 12:53:04',
            ),
            2 => 
            array (
                'id' => 3,
                'app_user_id' => 3,
                'amount' => 80000.0,
                'period' => 'weekly',
                'date' => NULL,
                'weekday' => 'Sunday',
                'time' => NULL,
                'try_other_cards' => 0,
                'processed_at' => '2020-04-19 12:51:46',
                'created_at' => '2020-04-12 00:00:00',
                'updated_at' => '2020-04-19 12:51:46',
            ),
            3 => 
            array (
                'id' => 4,
                'app_user_id' => 2,
                'amount' => 75000.0,
                'period' => 'monthly',
                'date' => 19,
                'weekday' => '',
                'time' => NULL,
                'try_other_cards' => 1,
                'processed_at' => '2020-04-19 12:51:46',
                'created_at' => '2020-04-10 00:00:00',
                'updated_at' => '2020-04-19 12:51:46',
            ),
            4 => 
            array (
                'id' => 5,
                'app_user_id' => 1,
                'amount' => 40000.0,
                'period' => 'daily',
                'date' => NULL,
                'weekday' => '',
                'time' => '12:00:00',
                'try_other_cards' => 1,
                'processed_at' => '2020-04-19 12:53:04',
                'created_at' => '2020-04-08 00:00:00',
                'updated_at' => '2020-04-19 12:53:04',
            ),
        ));

        
    }
}