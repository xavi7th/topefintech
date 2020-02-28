<?php

namespace App\Modules\Admin\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\AutoSaveSetting;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ProcessAutoSaveDeductions extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'savings:auto-deduct-savings';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deduct from user\'s debit cards savings request';

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
		foreach (AutoSaveSetting::all() as $deduction_request) {

			/**
			 * ! Put a processed_at so that the stuff is not processed twice by the scheduling running twice
			 * ? Test if the processed at is today. If yes then skip else carry on
			 */

			dump($deduction_request->toArray());

			// This must run in background

			//check the schedule
			//if weekly check the day of week
			if ($deduction_request->period == 'weekly') {
				//	if same day fire request to deduct
				if (today()->isDayOfWeek($deduction_request->weekday)) {
					$this->requestSavingsDeduction($deduction_request);
				}
			}
			//if daily check the time
			else if ($deduction_request->period == 'daily') {
				//	if same hour fire request to deduct
				if (now()->isSameHour($deduction_request->time)) {
					$this->requestSavingsDeduction($deduction_request);
				}
			}
			//if monthly check the date
			else if ($deduction_request->period == 'monthly') {
				//	if same date fire request to deduct
				if (now()->day == $deduction_request->date) {
					$this->requestSavingsDeduction($deduction_request);
				}
			}
			//if quarterly check if this is the first day of quarter Carbon::now()->firstOfQuarter()->isToday()
			else if ($deduction_request->period == 'quarterly') {
				//	if it is fire request to deduct
				if (now()->firstOfQuarter()->isToday()) {
					$this->requestSavingsDeduction($deduction_request);
				}
			}
		}
		echo 'Completed successfully';
	}

	/**
	 * attempt to auto deduct the amount from the user's debit card
	 *
	 * @param AutoSaveSetting $deduction_request The AutoSaveSetting object to process
	 * @return void
	 **/
	private function requestSavingsDeduction(AutoSaveSetting $deduction_request): void
	{

		//Get the user
		$app_user = $deduction_request->app_user;

		/**
		 * ! Make sure the user distribution is 100% before we start anything
		 */
		if ($app_user->total_distribution_percentage() != 100) {
			// $app_user->notify(new InvalidSavingsDistributionValue);
			dump('Invalid savings ditribution settings');

			// $app_user->notify(new AutoSaveSavingsFailure($deduction_request->amount));
			dump('Auto save failure');
			return;
		}

		//Get the user's default debit card
		$debit_card_to_deduct = $app_user->default_debit_card;

		//Fire a deduction request via paystack
		$rsp = $app_user->deduct_debit_card($debit_card_to_deduct, $deduction_request->amount);

		dump('Deduction response ' . (string)$rsp);

		//If it fails,
		if (!$rsp) {
			//notify him of failure of default card debit
			// $app_user->notify(new CardDebitFailure($debit_card_to_deduct, $deduction_request->amount));
			dump('Debit failure');

			//check if request permits us to try other cards
			if ($deduction_request->try_other_cards) {
				//	if it does pick other cards
				$app_user_other_debit_cards = $app_user->other_debit_cards;
				$num_of_cards_on_file = count($app_user_other_debit_cards);

				// 	and then rinse and repeat in a loop
				foreach ($app_user_other_debit_cards as $idx => $debit_card_to_try) {
					//attempt to deduct card
					$rsp = $app_user->deduct_debit_card($debit_card_to_try, $deduction_request->amount);
					dump('Deduction response ' . (string)$rsp);

					//		if any is successful,
					if ($rsp) {
						//notify him of card debit success
						// $app_user->notify(new CardDebitSuccess($debit_card_to_deduct, $deduction_request->amount));
						dump('Debit Success');

						//	fund the user according to their savings distribution
						$this->processUserSavingsDistribution($app_user, $deduction_request->amount);

						//notify him of autosave success
						// $app_user->notify(new AutoSaveSavingsSuccess($deduction_request->amount));
						dump('Autosave success');

						// break the loop and then exit
						break;
					} else {
						//	if it doesnt notify him of card debit failure
						// $app_user->notify(new CardDebitFailure($debit_card_to_deduct, $deduction_request->amount));
						dump('Debit failure');
					}

					// if there are still cards to try then try next card
					if ($idx == $num_of_cards_on_file) {
						//		if none drop an auto save failure notification for him
						// $app_user->notify(new AutoSaveSavingsFailure($deduction_request->amount));
						dump('Autosave failure');
					}
				}
				// if request does not permit us to try other cards
			} else {
				//notify him of failure to process autosave
				// $app_user->notify(new AutoSaveSavingsFailure($deduction_request->amount));
				dump('Autosave failure');
			}
			// if default card debit succeeds
		} else {
			//notify him of card debit success
			// $app_user->notify(new CardDebitSuccess($debit_card_to_deduct, $deduction_request->amount));
			dump('Debit success');

			//	fund the user according to their savings distribution
			$this->processUserSavingsDistribution($app_user, $deduction_request->amount);

			//notify him of autosave success
			// $app_user->notify(new AutoSaveSavingsSuccess($deduction_request->amount));
			dump('Autosave success');
		}
	}

	/**
	 * Create records to show the new savings of the user
	 *
	 * @param AppUser $app_user The user to create the records for
	 * @param float $amount The amount the user wants to save
	 * @return void
	 **/
	private function processUserSavingsDistribution(AppUser $app_user, float $amount)
	{
		if ($app_user->has_gos_savings() && !$app_user->has_locked_savings()) {
			$app_user->fund_core_savings($amount);
		} else {
			$app_user->distribute_savings($amount);
		}
		dump('Savings distribution success');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			// ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}
}
