<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\Savings;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;
use RachidLaasri\Travel\Travel;

class ProcessMatureSavings extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'savings:process-mature-savings';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Move matured Smart Savings and Target Savings funds to user’s Vault balance.';

  /**
   * Indicates whether the command should be shown in the Artisan command list.
   *
   * @var bool
   */
  protected $hidden = false;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    /**
     * !restrict the call to get only mature savings in the first place
     * ? A static method?
     * @param Savings $savings_record
     */
    // Travel::to('4 months 4 days', function () {
    foreach (Savings::with(['app_user', 'portfolio'])->matured()->notWithdrawn()->get() as $savings_record) {
        /**
         * ! An option could be to verify the savings balance before rolling over.
         * * If there is a discrepancy we could notify the accountants and admins so that they investigate it
         * ? $savings_record->$savings->is_balance_consistent()
         */
        if ($savings_record->complete_mature_savings()) {
        dump($savings_record->app_user->full_name . '´s ' . $savings_record->portfolio->name . ' savings has matured and is due for payout.');
          Admin::send_notification(new SavingsMaturedNotification($savings_record));
          optional($savings_record->app_user->smart_collector)->notify(new SavingsMaturedNotification($savings_record));
        }
      }
    // });
    echo 'Completed successfully';
  }
}
