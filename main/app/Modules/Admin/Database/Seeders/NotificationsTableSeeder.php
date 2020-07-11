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
      )
    ));
  }
}
