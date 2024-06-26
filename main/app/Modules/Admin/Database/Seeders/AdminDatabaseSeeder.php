<?php

namespace App\Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AdminDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $this->call(AdminsTableSeeder::class);
    $this->call(TargetTypesTableSeeder::class);
    $this->call(SavingsTableSeeder::class);
    $this->call(TransactionsTableSeeder::class);
    $this->call(SavingsInterestsTableSeeder::class);
    $this->call(DebitCardsTableSeeder::class);
    $this->call(AutoSaveSettingsTableSeeder::class);
    $this->call(WithdrawalRequestsTableSeeder::class);
    $this->call(ActivityLogsTableSeeder::class);
    $this->call(ServiceChargesTableSeeder::class);
    $this->call(NotificationsTableSeeder::class);
    $this->call(ErrLogsTableSeeder::class);
  }
}
