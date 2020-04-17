<?php

namespace App\Modules\Admin\Console;

use Illuminate\Console\Command;
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


		// foreach (Savings::with(['app_user', 'gos_type'])->get() as $savings_record) {
		// 	$interest_amount = $savings_record->get_due_interest();
		// 	if ($interest_amount > 0) {
		// 		dump($savings_record->app_user->full_name . ' ' . $savings_record->gos_type->name . ' savings intrested with ' . $interest_amount);
		// 		$savings_record->create_interest_record($interest_amount);
		// 	}
		// }


		foreach (Savings::with('app_user')->get() as $value) {
			if ($value->type == 'core') {
				$interest = $value->interestable_deposit_transactions()->sum('amount') * (config('app.core_savings_interest_rate') / 100);
				if ($interest > 0) {
					dump($value->app_user->full_name . ' ' . $value->type . ' savings intrested with ' . $interest . " \n");
					$value->savings_interests()->create([
						'amount' => $interest
					]);
				}
			} else if ($value->type == 'gos') {
				$interest =  $value->interestable_deposit_transactions()->sum('amount') * (config('app.gos_savings_interest_rate') / 100);
				if ($interest > 0) {
					dump($value->app_user->full_name . ' ' . $value->type . ' savings intrested with ' . $interest . " \n");
					$value->savings_interests()->create([
						'amount' => $interest
					]);
				}
			} else if ($value->type == 'locked') {
				$interest = $value->interestable_deposit_transactions()->sum('amount') * (config('app.locked_savings_interest_rate') / 100);
				if ($interest > 0) {
					dump($value->app_user->full_name . ' ' . $value->type . ' savings intrested with ' . $interest . " \n");
					$value->savings_interests()->create([
						'amount' => $interest
					]);
				}
			}
		}
	}
}
