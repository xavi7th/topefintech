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

    \DB::table('notifications')->insert(array(
      0 =>
      array(
        'id' => '0252dd6c-6959-4e0a-9811-a91fed91a4d1',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 5000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      1 =>
      array(
        'id' => '0578ac46-41fa-470d-b9c3-2ce33087f5e9',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed smoothly"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      2 =>
      array(
        'id' => '079e7213-35be-459b-8bab-7badae64e8df',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 90000 based on your auto save setting failed for the following reason: Invalid savings distributrion value"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 09:57:41',
        'updated_at' => '2020-04-19 09:57:41',
      ),
      3 =>
      array(
        'id' => '0a157035-df9d-4c7b-8d8b-cafeed9fd86a',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 75000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      4 =>
      array(
        'id' => '0e390b01-16ee-4c63-9717-96d7ae5ba169',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a successful debit of 80000 from your card ending in 0273. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:41',
        'updated_at' => '2020-04-19 10:12:41',
      ),
      5 =>
      array(
        'id' => '0f8961c8-ec54-495d-a7e6-11fe3cd8da28',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 90000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:00:47',
        'updated_at' => '2020-04-19 10:00:47',
      ),
      6 =>
      array(
        'id' => '12594b92-e583-4599-857f-22ab70e881cf',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request of \\u20a650,000.00 has been processed and \\u20a647,500.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:12:08',
        'updated_at' => '2020-04-16 05:12:08',
      ),
      7 =>
      array(
        'id' => '24e68dd5-20b8-45c2-8f08-3d1283a8fe64',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 75000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      8 =>
      array(
        'id' => '298efb6d-c273-4229-a150-7c195196883a',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request of \\u20a620,000.00 has been processed and \\u20a619,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:25:42',
        'updated_at' => '2020-04-16 05:25:42',
      ),
      9 =>
      array(
        'id' => '2cec1b6e-a49b-4934-bda2-de01b15d939e',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed successfully"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:34:20',
        'updated_at' => '2020-04-19 10:34:20',
      ),
      10 =>
      array(
        'id' => '3094b0a3-41d1-4bdb-8cc0-947a7ef1c53d',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:25:29',
        'updated_at' => '2020-04-16 05:25:29',
      ),
      11 =>
      array(
        'id' => '32d1fbcd-fac7-4c23-b8d4-a4cdfafa369c',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request of \\u20a660,000.00 has been processed and \\u20a657,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:26:13',
        'updated_at' => '2020-04-16 05:26:13',
      ),
      12 =>
      array(
        'id' => '35b95ee5-61ca-49dd-9b26-83a3b8047332',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 25000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:18:48',
        'updated_at' => '2020-04-19 10:18:48',
      ),
      13 =>
      array(
        'id' => '378dbe5e-1a2f-4a1e-8c81-a62f26e9c331',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:26:10',
        'updated_at' => '2020-04-16 05:26:10',
      ),
      14 =>
      array(
        'id' => '37be3328-560a-4561-96fb-b7a3e9677980',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 90000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:20',
        'updated_at' => '2020-04-19 10:12:20',
      ),
      15 =>
      array(
        'id' => '37fa60b8-e299-4db6-9907-a049e6168601',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 1,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed successfully"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:34',
        'updated_at' => '2020-04-19 10:30:34',
      ),
      16 =>
      array(
        'id' => '46466afe-6e36-42a7-9a6f-711b76fbd1f0',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically deduct 80000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:20',
        'updated_at' => '2020-04-19 10:12:20',
      ),
      17 =>
      array(
        'id' => '476236e7-02d4-4619-9550-18e7e084c4a5',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 90000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:00:47',
        'updated_at' => '2020-04-19 10:00:47',
      ),
      18 =>
      array(
        'id' => '499b78ac-ff8c-4cd2-a8a2-a9af8657ad67',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a failure when we attempted to debit 80000 from your card ending in 0273. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      19 =>
      array(
        'id' => '49d102ec-a771-407f-8922-d13028ee6ec7',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been processed and \\u20a670,000.00 has been transferred to your account on file. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:10:51',
        'updated_at' => '2020-04-16 05:10:51',
      ),
      20 =>
      array(
        'id' => '4b518fe5-4576-4185-b660-44f938da428b',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 1,
        'data' => '{"action":"You have automatically saved \\u20a640,000.00 based on your auto save setting. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:25:19',
        'updated_at' => '2020-04-19 10:25:19',
      ),
      21 =>
      array(
        'id' => '514e3123-5449-49c0-a2e5-418050ddf411',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a failure when we attempted to debit 80000 from your card ending in 0273. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:20',
        'updated_at' => '2020-04-19 10:12:20',
      ),
      22 =>
      array(
        'id' => '53079c8b-f46f-41ef-b732-a04e8865a584',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 5000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:33',
        'updated_at' => '2020-04-19 10:30:33',
      ),
      23 =>
      array(
        'id' => '53185eba-6ad3-40e8-8c33-81390f504b8c',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 5000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      24 =>
      array(
        'id' => '5cfde31e-608a-4755-bc55-3a2e8cf26f09',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:20:57',
        'updated_at' => '2020-04-16 05:20:57',
      ),
      25 =>
      array(
        'id' => '62af395b-3d46-48c4-bd94-cdff6705971a',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically save 75000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:34:20',
        'updated_at' => '2020-04-19 10:34:20',
      ),
      26 =>
      array(
        'id' => '62ea1780-7943-424b-8a37-dc3fa55d2435',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed successfully"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:33',
        'updated_at' => '2020-04-19 10:30:33',
      ),
      27 =>
      array(
        'id' => '6778414b-e04f-43a9-9564-a615f383eabe',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 75000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:36:58',
        'updated_at' => '2020-04-19 10:36:58',
      ),
      28 =>
      array(
        'id' => '697425f5-12e8-4688-9678-b0db6228f34b',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 5000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      29 =>
      array(
        'id' => '6db0b9e0-4b50-4ac7-b7e0-2d110f8fde62',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:25:55',
        'updated_at' => '2020-04-16 05:25:55',
      ),
      30 =>
      array(
        'id' => '6ed33307-301c-4a74-92eb-28ed686ebdd6',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 5000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:33',
        'updated_at' => '2020-04-19 10:30:33',
      ),
      31 =>
      array(
        'id' => '70f0dbf8-fb49-412e-a341-b7a7a6be2915',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically save 80000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      32 =>
      array(
        'id' => '7ae88cb3-d43d-4021-a8b1-a3ddc2325bed',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically deduct 80000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:18:48',
        'updated_at' => '2020-04-19 10:18:48',
      ),
      33 =>
      array(
        'id' => '7d0918a2-39da-43f9-8e36-a0b432957ded',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed smoothly"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:36:58',
        'updated_at' => '2020-04-19 10:36:58',
      ),
      34 =>
      array(
        'id' => '7d715fe4-59f5-439e-bbde-0488f2a40d51',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 90000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:09:11',
        'updated_at' => '2020-04-19 10:09:11',
      ),
      35 =>
      array(
        'id' => '89e408b6-d5c1-4490-9758-8f7687f44857',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically deduct 80000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:09:11',
        'updated_at' => '2020-04-19 10:09:11',
      ),
      36 =>
      array(
        'id' => '8df2eb1b-7f8b-4eaf-9181-09f33ded2da2',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 25000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:18:48',
        'updated_at' => '2020-04-19 10:18:48',
      ),
      37 =>
      array(
        'id' => '8ecb62b4-3939-4cfc-a4f7-439570438365',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a successful debit of 80000 from your card ending in 0273. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:00:47',
        'updated_at' => '2020-04-19 10:00:47',
      ),
      38 =>
      array(
        'id' => '9924d58c-c9b4-446b-8028-f7d4ebabb323',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:11:46',
        'updated_at' => '2020-04-16 05:11:46',
      ),
      39 =>
      array(
        'id' => 'a80fb62f-6201-45d7-be1a-b5bfec201f54',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request of \\u20a620,000.00 has been processed and \\u20a619,000.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:21:12',
        'updated_at' => '2020-04-16 05:21:12',
      ),
      40 =>
      array(
        'id' => 'aa96f213-4f28-47bd-a01d-60c4beb78e3e',
        'type' => 'App\\Modules\\AppUser\\Notifications\\SmartLockBroken',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have chosen to break your smart lock savings started with \\u20a613,500.00. The amount accrued\\t(short the lock break charges) has been rolled over to your core savings balance. We hope the emergency blows over quickly and you can get back\\tto saving again. Over the period it has accrued a total interest of \\u20a616,612.50. Keep living, keep saving!"}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:03:20',
        'updated_at' => '2020-04-16 05:03:20',
      ),
      41 =>
      array(
        'id' => 'b34a1278-a766-41b1-93ff-9b58ae867d14',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have automatically saved \\u20a65,000.00 based on your auto save setting. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:25:19',
        'updated_at' => '2020-04-19 10:25:19',
      ),
      42 =>
      array(
        'id' => 'b5eaf743-4504-42e0-9eb8-0640847fec55',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DeclinedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request declined. Kindly contact support for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:09:51',
        'updated_at' => '2020-04-16 05:09:51',
      ),
      43 =>
      array(
        'id' => 'b9f0ca3b-1090-4ee3-91a1-7ef192fba8fe',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:09:43',
        'updated_at' => '2020-04-16 05:09:43',
      ),
      44 =>
      array(
        'id' => 'baec4be7-beb5-4d4d-8733-f979f541230c',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DefaultDebitCardNotFound',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"You have no default debit card specified in your account. Kindly correct this in order for card transactions to proceed smoothly"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      45 =>
      array(
        'id' => 'bb422c15-8539-4324-9215-86e4eb05af20',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a successful debit of 80000 from your card ending in 0273. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:18:48',
        'updated_at' => '2020-04-19 10:18:48',
      ),
      46 =>
      array(
        'id' => 'c5d1d902-cc55-4d28-aa2e-d77931fbceb2',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 5000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:33',
        'updated_at' => '2020-04-19 10:30:33',
      ),
      47 =>
      array(
        'id' => 'cec599fc-a453-4ccb-879a-bd08288b1846',
        'type' => 'App\\Modules\\AppUser\\Notifications\\WithdrawalRequestCreatedNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request has been created. We will update you once it has been attended to."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:10:07',
        'updated_at' => '2020-04-16 05:10:07',
      ),
      48 =>
      array(
        'id' => 'cf54fced-f182-41cf-b69f-e17769811a98',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 90000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:41',
        'updated_at' => '2020-04-19 10:12:41',
      ),
      49 =>
      array(
        'id' => 'd2d8e4a0-a912-4a08-86b4-35e1f93a18a3',
        'type' => 'App\\Modules\\AppUser\\Notifications\\InvalidSavingsDistributionValue',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"An attempt to process a distributed savings on your account failed because your savings distribution percentage is not 100%. Please fix that and try again."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 09:57:41',
        'updated_at' => '2020-04-19 09:57:41',
      ),
      50 =>
      array(
        'id' => 'dc203bdf-4234-4731-9fd3-649698d86fef',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 90000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:41',
        'updated_at' => '2020-04-19 10:12:41',
      ),
      51 =>
      array(
        'id' => 'e0b46526-161a-4e2f-a56d-507445ed84bf',
        'type' => 'App\\Modules\\AppUser\\Notifications\\DeclinedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request declined. Kindly contact support for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:08:25',
        'updated_at' => '2020-04-16 05:08:25',
      ),
      52 =>
      array(
        'id' => 'e18d3806-0e04-4e4b-abd1-c9dde1b44915',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 1,
        'data' => '{"action":"At attempt to automatically save 40000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:34',
        'updated_at' => '2020-04-19 10:30:34',
      ),
      53 =>
      array(
        'id' => 'e58d71d4-5aac-4fad-a847-f7e01a27005c',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Congratulations! Based on your auto save setting, you have automatically saved \\u20a675,000.00 according to your savings distribution."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:36:58',
        'updated_at' => '2020-04-19 10:36:58',
      ),
      54 =>
      array(
        'id' => 'e5c70468-3d4d-47e0-99ff-5a17b9040808',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Congratulations! Based on your auto save setting, you have automatically saved \\u20a65,000.00 according to your savings distribution."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:30:33',
        'updated_at' => '2020-04-19 10:30:33',
      ),
      55 =>
      array(
        'id' => 'e8d5473c-8811-4cf6-9dfa-57c6d7135217',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically deduct 80000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:00:47',
        'updated_at' => '2020-04-19 10:00:47',
      ),
      56 =>
      array(
        'id' => 'ea225cb8-2fa1-417a-89f1-d7a13ad13644',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Congratulations! Based on your auto save setting, you have automatically saved \\u20a65,000.00 according to your savings distribution."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      57 =>
      array(
        'id' => 'ef5b1f1d-ca88-4433-a9fa-a3c42bf351ae',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 1,
        'data' => '{"action":"There was a successful debit of 40000 from your card ending in 0349. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:25:19',
        'updated_at' => '2020-04-19 10:25:19',
      ),
      58 =>
      array(
        'id' => 'efb2c7f8-2f41-48e3-b824-f50b0448b861',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"There was a successful debit of 80000 from your card ending in 0273. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:09:11',
        'updated_at' => '2020-04-19 10:09:11',
      ),
      59 =>
      array(
        'id' => 'f09f8883-21f6-4a3f-a750-a2db83893b92',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a failure when we attempted to debit 75000 from your card ending in 7040. Contact your card provider for more information."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:38:12',
        'updated_at' => '2020-04-19 10:38:12',
      ),
      60 =>
      array(
        'id' => 'f23d17ee-81d8-4acb-993c-ae40c837a3d6',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 3,
        'data' => '{"action":"At attempt to automatically deduct 80000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:41',
        'updated_at' => '2020-04-19 10:12:41',
      ),
      61 =>
      array(
        'id' => 'f650f37a-747a-4908-996d-3b240032db2b',
        'type' => 'App\\Modules\\AppUser\\Notifications\\CardDebitSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"There was a successful debit of 5000 from your card ending in 7040. if you believe this to be in error, kindly contact support."}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:25:19',
        'updated_at' => '2020-04-19 10:25:19',
      ),
      62 =>
      array(
        'id' => 'f669f177-ca07-4c04-9e99-db40cea364a3',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsFailure',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 90000 based on your auto save setting failed for the following reason: Deducting default card failed or there was no default card set"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:12:20',
        'updated_at' => '2020-04-19 10:12:20',
      ),
      63 =>
      array(
        'id' => 'f986f89c-8f28-4f72-ac89-bb688efeb3d3',
        'type' => 'App\\Modules\\AppUser\\Notifications\\ProcessedWithdrawalRequestNotification',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"Your withdrawal request of \\u20a630,000.00 has been processed and \\u20a628,500.00 has been transferred to your account on file. You were charged a fee of 5% for the transaction. If there are any issues kindly contact us."}',
        'read_at' => NULL,
        'created_at' => '2020-04-16 05:26:05',
        'updated_at' => '2020-04-16 05:26:05',
      ),
      64 =>
      array(
        'id' => 'f9cf290b-99cc-4aee-a940-def4ab994561',
        'type' => 'App\\Modules\\AppUser\\Notifications\\AutoSaveSavingsSuccess',
        'notifiable_type' => 'App\\Modules\\AppUser\\Models\\AppUser',
        'notifiable_id' => 2,
        'data' => '{"action":"At attempt to automatically deduct 90000 based on your auto save setting was successful. If you believe this to be in error, kindly contact support"}',
        'read_at' => NULL,
        'created_at' => '2020-04-19 10:09:11',
        'updated_at' => '2020-04-19 10:09:11',
      ),
    ));
  }
}
