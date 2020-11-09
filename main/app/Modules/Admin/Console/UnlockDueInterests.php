<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\Savings;
use App\Modules\Admin\Notifications\GenericAdminNotification;
use RachidLaasri\Travel\Travel;

class UnlockDueInterests extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'savings:unlock-due-interests';
  private $minimumDuration;

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description;
  protected $notification = [];

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
    $this->minimumDuration = config('app.smart_savings_minimum_duration_before_interests_withdrawal');

    $this->description = 'Unlock the interests of smart savings that are interest withdrawable and that are older than ' . $this->minimumDuration . ' days.';
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    /**
     * @var Savings $savingsRecord
     */
    foreach (Savings::smart()->active()->whereDate('funded_at', '<', now()->subDays($this->minimumDuration))->with(['app_user', 'target_type'])->cursor() as $savingsRecord) {

      DB::beginTransaction();

      if ($savingsRecord->isDueForIntetestsUnlock() && $savingsRecord->unlockSavingsInterests()) {
        $this->notification[] = $savingsRecord->app_user->full_name . ' ' . $savingsRecord->target_type->name . ' savings interested unlocked for withdrawal';
      }

      DB::commit();
    }

    dump(collect($this->notification)->implode(',' . PHP_EOL));
    Admin::find(1)->notify(new GenericAdminNotification('Processed Mature Withdrawable Interests', collect($this->notification)->implode(', ' . PHP_EOL)));
  }
}
