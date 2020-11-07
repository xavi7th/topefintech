<?php

namespace App\Console;

use Nwidart\Modules\Facades\Module;
use Illuminate\Console\Scheduling\Schedule;
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
    ->everyMinute()
      ->withoutOverlapping(10)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/process-interests-' . now()->toDateString() . '.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Failed to successfully process interests for all users');
      });

    $schedule->command('savings:auto-deduct-savings')
      ->everyMinute()
      ->withoutOverlapping(180)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/autosave-deductions-log' . now()->toDateTimeString() . '.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing auto save deductions failed');
      });

    $schedule->command('savings:process-mature-savings')
    // ->daily()
    ->everyMinute()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/process-mature-savings-log' . now()->toDateString() . '.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing mature savings failed to complete successfully');
      });

    // $schedule->job(new SendLoginNotification(AppUser::find(1)))->emailOutputTo('xavi7th@gmail.com')->everyFiveMinutes();

    /**
     * !See the explanation in ./explanation.cson
     */
    if (app()->environment('local')) {
      $schedule->command('queue:work --once --queue=high,low,default')->sendOutputTo(Module::getModulePath('Admin/Console') . '/queue-jobs.cson');
    } else {
      $schedule->command('queue:restart')->hourly();
      $schedule->command('queue:work --sleep=3 --timeout=900 --queue=high,default,low')->runInBackground()->withoutOVerlapping()->everyMinute();
    }
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
