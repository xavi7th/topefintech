<?php

namespace App\Modules\Admin\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Modules\Admin\Models\ErrLog;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\DebitCard;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\AppUser\Models\AutoSaveSetting;
use App\Modules\AppUser\Notifications\CardDebitFailure;
use App\Modules\AppUser\Notifications\CardDebitSuccess;
use App\Modules\SuperAdmin\Notifications\GenericSuperAdminNotification;
use App\Modules\AppUser\Notifications\AutoSaveSavingsFailure;
use App\Modules\AppUser\Notifications\AutoSaveSavingsSuccess;
use App\Modules\AppUser\Notifications\DefaultDebitCardNotFound;

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
    Carbon::setLocale('en_US');
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {

    foreach (AutoSaveSetting::with('app_user')->cursor() as $deduction_request) {
      dump($deduction_request->load('app_user:id,email,full_name')->toArray());

      /**
       * Check this autosave request's schedule to determine whether or not to
       * attempt to process auto save request
       */

      if ($deduction_request->is_weekly()) {
        /**
         *  check the day of week, if it's today fire request to deduct
         */
        if (today()->isDayOfWeek($deduction_request->weekday) && !$deduction_request->processed_at->startOfWeek()->isSameDay(now()->startOfWeek())) {
          $this->processSavingsDeduction($deduction_request);
        }
      } else if ($deduction_request->is_daily()) {
        /**
         * check the time, if same hour fire request to deduct
         */
        if (now()->isSameHour($deduction_request->time) && !today()->isSameDay($deduction_request->processed_at)) {
          $this->processSavingsDeduction($deduction_request);
        }
      } else if ($deduction_request->is_monthly()) {
        /**
         * check the date, if same date fire request to deduct
         */
        if (now()->day == $deduction_request->date && !$deduction_request->processed_at->isCurrentMonth()) {
          $this->processSavingsDeduction($deduction_request);
        }
      } else if ($deduction_request->is_quarterly()) {
        /**
         * check if this is the first day of the quarter,
         * if it is fire request to deduct
         */
        if (now()->firstOfQuarter()->isToday() && !$deduction_request->processed_at->isCurrentQuarter()) {
          $this->processSavingsDeduction($deduction_request);
        }
      }
    }

    dump('AutoSave Requests Processing Completed successfully');
  }

  /**
   * attempt to auto deduct the amount from the user's debit card
   *
   * @param AutoSaveSetting $deduction_request The AutoSaveSetting object to process
   * @return void
   **/
  private function processSavingsDeduction(AutoSaveSetting $deduction_request): void
  {
    /**
     * Get the user that made the auto save request
     */
    $app_user =  $deduction_request->app_user;

    if ($this->deductDefaultCard($app_user, $deduction_request->amount)) {

      $this->markRequestAsProcessed($deduction_request);
    } else {
      /**
       * Check if the user permitted us to try his other cards.
       */
      if ($deduction_request->try_other_cards) {

        if ($this->attemptOtherCardDeductions($app_user, $deduction_request->amount)) {
          $this->markRequestAsProcessed($deduction_request);
        }
      } else {
        $this->fireAutoSaveFailureAction($app_user, $deduction_request->amount, 'Deducting default card failed or there was no default card set');
        $this->markRequestAsProcessed($deduction_request);
      }
    }
  }

  /**
   * Attempt to deduct the autosave amount from the user's default card if he has specified one on file
   *
   * @param \App\Modules\AppUser\Models\AppUser $app_user
   * @param float $amount
   *
   * @return boolean
   */
  private function deductDefaultCard(AppUser $app_user, float $amount): bool
  {
    /**
     * Get the user's default debit card
     */
    $debit_card_to_deduct = $app_user->default_debit_card;

    if (is_null($debit_card_to_deduct)) {
      try {
        $app_user->notify(new DefaultDebitCardNotFound());
        SuperAdmin::find(1)->notify(new GenericSuperAdminNotification('Auto Deduct Failure', $app_user->full_name . ' has no default card to auto deduct'));
        logger()->notice($app_user->full_name . ' has no default card to auto deduct');
      } catch (\Throwable $th) {
        ErrLog::notifySuperAdmin($app_user, $th, 'failure to notify user that default card not found');
      }
      return false;
    }

    /**
     * Delegate a deduction request via paystack
     */
    $deduction_successful = (bool)$app_user->deduct_debit_card($debit_card_to_deduct, $amount);
    dump('Deduction response ' . (string)$deduction_successful);

    if (!$deduction_successful) {
      $this->fireFailedDebitAction($app_user, $debit_card_to_deduct, $amount);
    } else {
      $this->fireSuccessfulDebitAction($app_user, $debit_card_to_deduct, $amount);
    }
    return $deduction_successful;
  }

  /**
   * Attempt to deduct the other cards the user has on file
   *
   * @param \App\Modules\AppUser\Models\AppUser $app_user
   * @param float $amount The amount to attempt to deduct from the user's card
   *
   * @return void
   */
  private function attemptOtherCardDeductions(AppUser $app_user, float $amount): bool
  {
    $app_user_other_debit_cards = $app_user->other_debit_cards;
    $num_of_cards_on_file = count($app_user_other_debit_cards);
    /**
     * Initialise $debit_successful to false
     */
    $debit_successful = false;

    /**
     * Attempt to debit all his other cards in a loop
     */
    foreach ($app_user_other_debit_cards as $idx => $debit_card_to_try) {

      $debit_successful = $app_user->deduct_debit_card($debit_card_to_try, $amount);
      dump('Deduction response ' . (string)$debit_successful);

      if ($debit_successful) {
        $this->fireSuccessfulDebitAction($app_user, $debit_card_to_try, $amount);
        break;
      } else {
        $this->fireFailedDebitAction($app_user, $debit_card_to_try, $amount);
      }

      /**
       * if there are no more cards to attempt, drop an auto save failure notification for him
       */
      if ($idx == $num_of_cards_on_file) {
        $this->fireAutoSaveFailureAction($app_user, $amount, 'All card debit attempts failed');
      }
    }

    return $debit_successful;
  }

  /**
   * Function to fire when we have successfully debited the user's card.
   *
   * @param \App\Modules\AppUser\Models\AppUser $app_user
   * @param \App\Modules\AppUser\Models\DebitCard $deducted_debit_card
   * @param float $amount
   *
   * @return void
   */
  private function fireSuccessfulDebitAction(AppUser $app_user, DebitCard $deducted_debit_card, float $amount)
  {
    /**
     * notify him of card debit success
     */
    try {
      $app_user->notify(new CardDebitSuccess($deducted_debit_card, $amount));
      SuperAdmin::find(1)->notify(new GenericSuperAdminNotification('Successful Auto Debit', "Successful debit of  $amount from $app_user->fullname. Card:  $deducted_debit_card->pan"));
      logger()->notice("Successful debit of  $amount from $app_user->fullname. Card:  $deducted_debit_card->pan");
    } catch (\Throwable $th) {
      ErrLog::notifySuperAdmin($app_user, $th, 'Failure to notify user of card debit success');
    }
    dump('Debit Success');

    /**
     * !	fund the user savings
     * ? Should this give us a response so that we can know if it successfully gave the user value?
     */
    $this->processUserSavingsFunding($app_user, $amount);

    try {
      $app_user->notify(new AutoSaveSavingsSuccess($amount));
      SuperAdmin::find(1)->notify(new GenericSuperAdminNotification('Autosave Successful', "Autosave successful for $app_user->full_name. Amount: " . $amount));
      logger()->notice("Autosave successful for $app_user->full_name. Amount: " . $amount);
    } catch (\Throwable $th) {
      ErrLog::notifySuperAdmin($app_user, $th, 'Failure to notify user of autosave success');
    }
  }

  /**
   * Method to fire when we failed to debit their card
   *
   * @param \App\Modules\AppUser\Models\AppUser $app_user
   * @param \App\Modules\AppUser\Models\DebitCard $failed_debit_card
   * @param float $amount
   *
   * @return void
   */
  private function fireFailedDebitAction(AppUser $app_user, DebitCard $failed_debit_card, float $amount)
  {
    /**
     * Notify them of failure to debit card
     */
    try {
      $app_user->notify(new CardDebitFailure($failed_debit_card, $amount));
      SuperAdmin::find(1)->notify(new GenericSuperAdminNotification('Failed AutoDebit', "There was a failed attempt to deduct  $amount from $app_user->full_name. Card:   $failed_debit_card->pan"));
      logger()->notice("There was a failed attempt to deduct  $amount from $app_user->full_name. Card:   $failed_debit_card->pan");
    } catch (\Throwable $th) {
      ErrLog::notifySuperAdmin($app_user, $th, 'Failure to notify user of card debit failure');
    }

    dump('Debit failure');
  }

  /**
   * Method to fire when autosave process failed
   *
   * @param \App\Modules\AppUser\Models\AppUser $app_user
   * @param float $amount The amount the user attempted to autosave
   * @param string $reason The reason the autosave failed
   *
   * @return void
   */
  private function fireAutoSaveFailureAction(AppUser $app_user, float $amount, string $reason)
  {
    /**
     * notify him of failure to process autosave
     */
    try {
      $app_user->notify(new AutoSaveSavingsFailure($amount, $reason));
      SuperAdmin::find(1)->notify(new GenericSuperAdminNotification($app_user->full_name . ' autosave failed.', $reason));
      logger()->notice($app_user->full_name . ' autosave failed. Reason: ' . $reason);
    } catch (\Throwable $th) {
      ErrLog::notifySuperAdmin($app_user, $th, 'Failure to notify user of auto save failure');
    }

    dump('Autosave failure: ' . $reason);
  }

  /**
   * Create records to give the user value for their new savings
   *
   * @param AppUser $app_user The user to create the records for
   * @param float $amount The amount the user wants to save
   * @return void
   **/
  private function processUserSavingsFunding(AppUser $app_user, float $amount)
  {
    if (!$app_user->has_target_savings()) {
      $app_user->fund_smart_savings($amount, 'Smart savings funding from Auto Save deduction');
    } else {
      /** NOTE: uses transactions */
      $app_user->fund_smart_savings($amount, 'Smart savings funding from Auto Save deduction');
      // dd('fund a user´s particular savings');
    }
    dump('Savings funding success');
  }

  /**
   * Mark the request as processed in order to prevent duplicate deductions
   *
   * @param \App\Modules\AppUser\Models\AutoSaveSetting $deduction_request
   *
   * @return void
   */
  public function markRequestAsProcessed(AutoSaveSetting $deduction_request)
  {
    $deduction_request->processed_at = now();
    $deduction_request->save();
  }
}
