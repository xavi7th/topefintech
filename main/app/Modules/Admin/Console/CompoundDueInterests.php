<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\Savings;
use App\Modules\Admin\Notifications\GenericAdminNotification;

class CompoundDueInterests extends Command
{
  /**
   * The console command name.
   *
   * @var string
   */
  protected $name = 'savings:compound-due-interests';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Rollover accrued interests into savings portfolio so that they can be compounded for more interests';
  protected $notification = [];

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
    foreach (Savings::active()->target()->where(fn ($query) => $query->dueAndNeverCompounded()->orWhere->dueForRecompounding())->with(['app_user', 'portfolio'])->cursor() as $savingsRecord) {
      DB::beginTransaction();

      /**
       * @var Savings $savingsRecord
       */
      if ($savingsRecord->compoundInterests()) {
        $this->notification[] = $savingsRecord->app_user->full_name . ' ' . $savingsRecord->portfolio->name . ' savings interests compounded successfully';
      } else {
        $this->notification[] = $savingsRecord->app_user->full_name . ' ' . $savingsRecord->portfolio->name . ' savings interests FAILED to compound successfully';
      }

      DB::commit();
    }

    dump(collect($this->notification)->implode(',' . PHP_EOL));
    Admin::find(1)->notify(new GenericAdminNotification('Processed Mature Withdrawable Interests', collect($this->notification)->implode(', ' . PHP_EOL)));
  }
}
