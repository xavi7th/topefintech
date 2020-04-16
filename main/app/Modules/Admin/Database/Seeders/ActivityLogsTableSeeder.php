<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class ActivityLogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activity_logs')->delete();
        
        \DB::table('activity_logs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com logged into the super admin dashboard',
                'created_at' => '2020-04-16 05:08:09',
                'updated_at' => '2020-04-16 05:08:09',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com declined xavi7th@gmail.com\'s withdrawal request of ₦36,000.00',
                'created_at' => '2020-04-16 05:08:25',
                'updated_at' => '2020-04-16 05:08:25',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦30,000.00',
                'created_at' => '2020-04-16 05:09:43',
                'updated_at' => '2020-04-16 05:09:43',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com declined xavi7th@gmail.com\'s withdrawal request of ₦30,000.00',
                'created_at' => '2020-04-16 05:09:51',
                'updated_at' => '2020-04-16 05:09:51',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦70,000.00',
                'created_at' => '2020-04-16 05:10:07',
                'updated_at' => '2020-04-16 05:10:07',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 70000',
                'created_at' => '2020-04-16 05:10:51',
                'updated_at' => '2020-04-16 05:10:51',
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦50,000.00',
                'created_at' => '2020-04-16 05:11:46',
                'updated_at' => '2020-04-16 05:11:46',
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:11:51',
                'updated_at' => '2020-04-16 05:11:51',
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:12:03',
                'updated_at' => '2020-04-16 05:12:03',
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:12:06',
                'updated_at' => '2020-04-16 05:12:06',
            ),
            10 => 
            array (
                'id' => 11,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 50000',
                'created_at' => '2020-04-16 05:12:08',
                'updated_at' => '2020-04-16 05:12:08',
            ),
            11 => 
            array (
                'id' => 12,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦20,000.00',
                'created_at' => '2020-04-16 05:20:57',
                'updated_at' => '2020-04-16 05:20:57',
            ),
            12 => 
            array (
                'id' => 13,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:21:03',
                'updated_at' => '2020-04-16 05:21:03',
            ),
            13 => 
            array (
                'id' => 14,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 4',
                'created_at' => '2020-04-16 05:21:06',
                'updated_at' => '2020-04-16 05:21:06',
            ),
            14 => 
            array (
                'id' => 15,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:21:07',
                'updated_at' => '2020-04-16 05:21:07',
            ),
            15 => 
            array (
                'id' => 16,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 3',
                'created_at' => '2020-04-16 05:21:10',
                'updated_at' => '2020-04-16 05:21:10',
            ),
            16 => 
            array (
                'id' => 17,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 20000',
                'created_at' => '2020-04-16 05:21:12',
                'updated_at' => '2020-04-16 05:21:12',
            ),
            17 => 
            array (
                'id' => 18,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦20,000.00',
                'created_at' => '2020-04-16 05:25:29',
                'updated_at' => '2020-04-16 05:25:29',
            ),
            18 => 
            array (
                'id' => 19,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com attempted to approve an already processed request: 4',
                'created_at' => '2020-04-16 05:25:33',
                'updated_at' => '2020-04-16 05:25:33',
            ),
            19 => 
            array (
                'id' => 20,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 20000',
                'created_at' => '2020-04-16 05:25:42',
                'updated_at' => '2020-04-16 05:25:42',
            ),
            20 => 
            array (
                'id' => 21,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦30,000.00',
                'created_at' => '2020-04-16 05:25:55',
                'updated_at' => '2020-04-16 05:25:55',
            ),
            21 => 
            array (
                'id' => 22,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 30000',
                'created_at' => '2020-04-16 05:26:05',
                'updated_at' => '2020-04-16 05:26:05',
            ),
            22 => 
            array (
                'id' => 23,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'xavi7th@gmail.com requested a withdrawal request of ₦60,000.00',
                'created_at' => '2020-04-16 05:26:10',
                'updated_at' => '2020-04-16 05:26:10',
            ),
            23 => 
            array (
                'id' => 24,
                'user_id' => 1,
                'user_type' => 'App\\Modules\\Admin\\Models\\Admin',
                'activity' => 'grant@amju.com processed Mariane Rempel Sr.\'s withdrawal request of 60000',
                'created_at' => '2020-04-16 05:26:13',
                'updated_at' => '2020-04-16 05:26:13',
            ),
        ));

        
    }
}