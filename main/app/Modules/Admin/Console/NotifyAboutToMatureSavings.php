<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\Savings;
use App\Modules\Admin\Notifications\SavingsAboutToMatureNotification;

class NotifyAboutToMatureSavings extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'savings:notify-about-to-mature-savings';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Notify admins about savings that are due to mature in specified number of days.';

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
     * @var Savings $savings_record
     */
    // Travel::to('4 months 4 days', function () {
    foreach (Savings::maturingSoon()->notWithdrawn()->get() as $savings_record) {
      Admin::send_notification(new SavingsAboutToMatureNotification($savings_record));
      optional($savings_record->app_user->smart_collector)->notify(new SavingsAboutToMatureNotification($savings_record));
      dump($savings_record->app_user->full_name . '´s ' . $savings_record->portfolio->name . ' savings is about to mature and become due for payout.');
    }
    // });
    echo 'Completed successfully';
  }
}
