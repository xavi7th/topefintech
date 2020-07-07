<?php

namespace App\Console;

use Nwidart\Modules\Facades\Module;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Console\Scheduling\Schedule;
use App\Modules\Admin\Jobs\SendLoginNotification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Modules\Admin\Models\ActivityLog;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    //
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {

    $schedule->command('savings:process-interest')
      // ->daily()
      ->dailyAt('06:40')
      ->withoutOverlapping(10)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/process-interests-' . now()->toDateString() . '.cson')
      ->emailOutputTo('xavi7th@gmail.com')
      ->onSuccess(function () {
        ActivityLog::notifyAdmins('Successfully allocated interests to all due deposits');
      })
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Failed to successfully process interests for all users');
      });

    $schedule->command('savings:auto-deduct-savings')
      ->everyMinute()
      ->withoutOverlapping(180)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/autosave-deductions-log' . now()->toDateTimeString() . '.cson')
      ->emailOutputTo('xavi7th@gmail.com')
      // ->runInBackground()
      ->onSuccess(function () {
        ActivityLog::notifyAdmins('Processing auto save deductions completed successfully');
      })
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing auto save deductions failed');
      });

    $schedule->command('savings:process-mature-savings')
      ->daily()
      ->withoutOverlapping(30)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/process-mature-savings-log' . now()->toDateTimeString() . '.cson')
      // ->runInBackground()
      ->onSuccess(function () {
        ActivityLog::notifyAdmins('Processing mature savings completed successfully');
      })
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing mature savings failed to complete successfully');
      });

    // $schedule->job(new SendLoginNotification(AppUser::find(1)))->emailOutputTo('xavi7th@gmail.com')->everyFiveMinutes();
  }

  /**
   * Register the commands for the application.
   *
   * @return void
   */
  protected function commands()
  {
    $this->load(__DIR__ . '/Commands');
    $this->load(Module::getModulePath('Admin/Console'));

    require base_path('routes/console.php');
  }
}
