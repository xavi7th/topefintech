<?php

namespace App\Console;

use Nwidart\Modules\Facades\Module;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Modules\Admin\Models\ActivityLog;
use RachidLaasri\Travel\Travel;

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

  public function bootstrap()
  {
    parent::bootstrap();
    // Travel::to('11months 25 days 12:00am');
  }

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {

    $schedule->command('savings:process-interest')
    ->daily()
      ->withoutOverlapping(10)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1process-interests.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Failed to successfully process interests for all users');
      });

    $schedule->command('savings:auto-deduct-savings')
      ->everyMinute()
      ->withoutOverlapping(180)
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1autosave-deductions-log.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing auto save deductions failed');
      });

    $schedule->command('savings:notify-about-to-mature-savings')
    ->daily()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1notify-about-to-mature-savings-log.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing about to mature savings notifications failed to complete successfully');
      });

    $schedule->command('savings:process-mature-savings')
    ->daily()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1process-mature-savings-log.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Processing mature savings failed to complete successfully');
      });

    $schedule->command('savings:unlock-due-interests')
    ->daily()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1unlock-due-interests-log.cson')
      ->onFailure(function () {
      ActivityLog::notifyAdmins('Unlocking due interests of smart savings failed to complete successfully');
    });

    $schedule->command('savings:compound-due-interests')
    ->daily()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1compound-due-interests-log.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Compounding due interests of target savings failed to complete successfully');
      });

    $schedule->command('database:backup')
    ->daily()
      ->sendOutputTo(Module::getModulePath('Admin/Console') . '/1database-backup-log.cson')
      ->onFailure(function () {
        ActivityLog::notifyAdmins('Compounding due interests of target savings failed to complete successfully');
      });

    // $schedule->job(new SendLoginNotification(AppUser::find(1)))->emailOutputTo('xavi7th@gmail.com')->everyFiveMinutes();

    /**
     * !See the explanation in ./explanation.cson
     */
    if (app()->environment('local')) {
      // $schedule->command('queue:work --once --queue=high,low,default')->sendOutputTo(Module::getModulePath('Admin/Console') . '/queue-jobs.cson');
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
