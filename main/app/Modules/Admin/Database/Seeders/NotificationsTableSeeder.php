<?php
namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('notifications')->delete();
        
        \DB::table('notifications')->insert(array (
            0 => 
            array (
                'id' => '12594b92-e583-4599-857f-22ab70e881cf',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request of \\u20a650,000.00 has been processed and \\u20a647,500.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:12:08',
                'updated_at' => '2020-04-16 05:12:08',
            ),
            1 => 
            array (
                'id' => '298efb6d-c273-4229-a150-7c195196883a',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request of \\u20a620,000.00 has been processed and \\u20a619,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:25:42',
                'updated_at' => '2020-04-16 05:25:42',
            ),
            2 => 
            array (
                'id' => '3094b0a3-41d1-4bdb-8cc0-947a7ef1c53d',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:25:29',
                'updated_at' => '2020-04-16 05:25:29',
            ),
            3 => 
            array (
                'id' => '32d1fbcd-fac7-4c23-b8d4-a4cdfafa369c',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request of \\u20a660,000.00 has been processed and \\u20a657,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:26:13',
                'updated_at' => '2020-04-16 05:26:13',
            ),
            4 => 
            array (
                'id' => '378dbe5e-1a2f-4a1e-8c81-a62f26e9c331',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:26:10',
                'updated_at' => '2020-04-16 05:26:10',
            ),
            5 => 
            array (
                'id' => '49d102ec-a771-407f-8922-d13028ee6ec7',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been processed and \\u20a670,000.00 has been transferred to your account on file. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:10:51',
                'updated_at' => '2020-04-16 05:10:51',
            ),
            6 => 
            array (
                'id' => '5cfde31e-608a-4755-bc55-3a2e8cf26f09',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:20:57',
                'updated_at' => '2020-04-16 05:20:57',
            ),
            7 => 
            array (
                'id' => '6db0b9e0-4b50-4ac7-b7e0-2d110f8fde62',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:25:55',
                'updated_at' => '2020-04-16 05:25:55',
            ),
            8 => 
            array (
                'id' => '9924d58c-c9b4-446b-8028-f7d4ebabb323',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:11:46',
                'updated_at' => '2020-04-16 05:11:46',
            ),
            9 => 
            array (
                'id' => 'a80fb62f-6201-45d7-be1a-b5bfec201f54',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request of \\u20a620,000.00 has been processed and \\u20a619,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:21:12',
                'updated_at' => '2020-04-16 05:21:12',
            ),
            10 => 
            array (
                'id' => 'aa96f213-4f28-47bd-a01d-60c4beb78e3e',
                'type' => 'App\\Modules\\AppUser\\Notifications\\SmartLockBroken',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
            'data' => '{"action":"You have chosen to break your smart lock savings started with \\u20a613,500.00. The amount accrued\\t(short the lock break charges) has been rolled over to your core savings balance. We hope the emergency blows over quickly and you can get back\\tto saving again. Over the period it has accrued a total interest of \\u20a616,612.50. Keep living, keep saving!"}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:03:20',
                'updated_at' => '2020-04-16 05:03:20',
            ),
            11 => 
            array (
                'id' => 'b5eaf743-4504-42e0-9eb8-0640847fec55',
                'type' => 'App\\Modules\\AppUser\\Notifications\\DeclinedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request declined. Kindly contact support for more information."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:09:51',
                'updated_at' => '2020-04-16 05:09:51',
            ),
            12 => 
            array (
                'id' => 'b9f0ca3b-1090-4ee3-91a1-7ef192fba8fe',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:09:43',
                'updated_at' => '2020-04-16 05:09:43',
            ),
            13 => 
            array (
                'id' => 'cec599fc-a453-4ccb-879a-bd08288b1846',
                'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:10:07',
                'updated_at' => '2020-04-16 05:10:07',
            ),
            14 => 
            array (
                'id' => 'e0b46526-161a-4e2f-a56d-507445ed84bf',
                'type' => 'App\\Modules\\AppUser\\Notifications\\DeclinedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request declined. Kindly contact support for more information."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:08:25',
                'updated_at' => '2020-04-16 05:08:25',
            ),
            15 => 
            array (
                'id' => 'f986f89c-8f28-4f72-ac89-bb688efeb3d3',
                'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
                'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
                'notifiable_id' => 2,
                'data' => '{"action":"Your withdrawal request of \\u20a630,000.00 has been processed and \\u20a628,500.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
                'read_at' => NULL,
                'created_at' => '2020-04-16 05:26:05',
                'updated_at' => '2020-04-16 05:26:05',
            ),
        ));

        
    }
}