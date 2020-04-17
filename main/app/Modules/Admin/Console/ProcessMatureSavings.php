<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\Savings;
use App\Modules\Admin\Models\ActivityLog;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Modules\AppUser\Notifications\GOSSavingsMatured;
use App\Modules\AppUser\Notifications\CoreSavingsInitialised;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;

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
	protected $description = 'Move matured Smart Lock and GOS Savings funds to user’s core savings balance.';

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
		foreach (Savings::with(['app_user', 'gos_type'])->matured()->get() as $savings_record) {
			/**
			 * ! An option could be to verify the savings balance before rolling over.
			 * * If there is a discrepancy we could notify the accountants and admins so that they investigate it
			 * ? $savings_record->$savings->is_balance_consistent()
			 */
			if ($savings_record->complete_mature_savings()) {
				Admin::send_notification(new SavingsMaturedNotification($savings_record));
			}
		}
		echo 'Completed successfully';
	}
}
