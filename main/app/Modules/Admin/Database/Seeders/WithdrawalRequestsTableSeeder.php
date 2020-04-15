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
        
        \DB::table('withdrawal_requests')->insert(array (
            0 => 
            array (
                'id' => 1,
                'app_user_id' => 2,
                'amount' => 36000.0,
                'is_processed' => 0,
                'created_at' => '2020-04-14 20:36:20',
                'updated_at' => '2020-04-14 20:36:20',
                'deleted_at' => NULL,
            ),
        ));

        
    }
}