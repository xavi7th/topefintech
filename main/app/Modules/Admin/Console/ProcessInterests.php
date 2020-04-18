<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Modules\AppUser\Models\Savings;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProcessInterests extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'savings:process-interests';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Give every user the interests that are due to their portfolio per the interest rates.';

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
		 * ! Optimisation concern
		 * ? Should we eager load the deposit transaction (maybe 100s or 1000s) and then do the sum in the collection
		 * //Savings::with(['app_user', 'interestable_deposit_transactions'])->get()
		 * -- $this->interestable_deposit_transactions()->sum('amount') VS $this->interestable_deposit_transactions->sum('amount')
		 * ? Or should we run multiple database calls to retrieve the sum of each saving´s deposit transactions
		 * -- The issue is multiple single sum queries VS a single select query with potential 1000s rows which is faster
		 */

		foreach (Savings::with(['app_user', 'gos_type'])->get() as $savings_record) {
			$interest_amount = $savings_record->get_due_interest();
			if ($interest_amount > 0) {
				dump($savings_record->app_user->full_name . ' ' . $savings_record->gos_type->name . ' savings intrested with ' . $interest_amount);
				DB::beginTransaction();
				$savings_record->create_interest_record($interest_amount);

				/**
				 * Mark all interestable transactions as processed
				 */
				$savings_record->mark_interest_as_processed();
				DB::commit();
			}
		}
	}
}
