<?php

namespace App\Console;

use Nwidart\Modules\Facades\Module;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Console\Scheduling\Schedule;
use App\Modules\Admin\Jobs\SendLoginNotification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
			->everyMinute()
			->withoutOverlapping()
			->sendOutputTo(Module::getModulePath('Admin/Console') . '/log' . now()->toDateString() . '.cson')
			// ->emailOutputTo('xavi7th@gmail.com')
			// ->runInBackground() //causes emails not to deliver
			->onSuccess(function () {
				// The task succeeded...
				// save a notification for the admin
			})
			->onFailure(function () {
				// The task failed...
				// save a notification for the admin
			});

		$schedule->command('savings:auto-deduct-savings')
			->everyMinute()
			->withoutOverlapping()
			->appendOutputTo(Module::getModulePath('Admin/Console') . '/log.cson')
			// ->emailOutputTo('xavi7th@gmail.com')
			->runInBackground() //causes emails not to deliver
			->onSuccess(function () {
				// The task succeeded...
				// save a notification for the admin
			})
			->onFailure(function () {
				// The task failed...
				// save a notification for the admin
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
