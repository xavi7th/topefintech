<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\AppUser\Models\LoanSurety;
use App\Modules\AppUser\Models\LoanRequest;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\AutoSaveSetting;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;

class AppUser extends User
{
	protected $fillable = [
		'name', 'email', 'password', 'phone', 'id_card'
	];

	protected $casts = [
		'can_withdraw' => 'boolean',
		'is_active' => 'boolean',
		'is_bvn_verified' => 'boolean',
	];
	protected $table = "users";
	const DASHBOARD_ROUTE_PREFIX = "user";

	static function canAccess()
	{
		return Auth::user() instanceof AppUser;
	}

	public function is_verified()
	{
		return $this->verified_at !== null;
	}

	public function loan_requests()
	{
		return $this->hasMany(LoanRequest::class);
	}

	public function loan_surety_requests()
	{
		return $this->hasMany(LoanSurety::class, 'lender_id');
	}

	public function surety_request()
	{
		return $this->hasOne(LoanSurety::class, 'surety_id')->where('is_surety_accepted', null);
	}

	public function auto_save_settings()
	{
		return $this->hasMany(AutoSaveSetting::class);
	}

	public function debit_cards()
	{
		return $this->hasMany(DebitCard::class);
	}

	public function other_debit_cards()
	{
		return $this->debit_cards()->where('is_default', false);
	}

	public function default_debit_card()
	{
		return $this->hasOne(DebitCard::class)->where('is_default', true);
	}

	public function savings_list()
	{
		return $this->hasMany(Savings::class);
	}

	public function core_savings()
	{
		return $this->hasOne(Savings::class)->where('type', 'core');
	}

	public function gos_savings()
	{
		return $this->hasMany(Savings::class)->where('type', 'gos');
	}

	public function locked_savings()
	{
		return $this->hasMany(Savings::class)->where('type', 'locked');
	}

	public function has_core_savings()
	{
		return $this->core_savings()->exists();
	}

	public function has_gos_savings()
	{
		return $this->gos_savings()->exists();
	}

	public function has_locked_savings()
	{
		return $this->locked_savings()->exists();
	}

	public function total_distribution_percentage(): float
	{
		return $this->savings_list()->sum('savings_distribution');
	}

	public function withdrawal_requests()
	{
		return $this->hasMany(WithdrawalRequest::class);
	}

	public function total_withdrawal_amount()
	{
		return $this->transactions()->where('trans_type', 'withdrawal')->sum('amount');
	}

	public function withdrawal_transactions()
	{
		return $this->transactions()->where('trans_type', 'withdrawal');
	}

	public function deposit_transactions()
	{
		return $this->transactions()->where('trans_type', 'deposit');
	}

	public function interestable_deposit_transactions()
	{
		return $this->deposit_transactions()->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
	}

	public function transactions()
	{
		return $this->hasManyThrough(Transaction::class, Savings::class);
	}

	public function deduct_debit_card(DebitCard $debit_card_to_deduct, float $amount): bool
	{
		return (bool)mt_rand(0, 1);
	}

	public function fund_core_savings(float $amount): void
	{
		DB::beginTransaction();
		$core_savings = $this->core_savings;
		$core_savings->current_balance += $amount;
		$core_savings->funded_at  = $core_savings->funded_at ?? now();
		$core_savings->save();

		$core_savings->create_deposit_transaction($amount);

		DB::commit();
	}

	public function fund_locked_savings(Savings $locked_savings, float $amount): void
	{
		if ($locked_savings->type !== 'locked') {
			throw new Exception("You can only add locked funds to a locked savings", 422);
		}
		DB::beginTransaction();
		$locked_savings->current_balance += $amount;
		$locked_savings->funded_at  = $locked_savings->funded_at ?? now();
		$locked_savings->save();

		$locked_savings->create_deposit_transaction($amount);

		DB::commit();
	}

	public function distribute_savings(float $amount): void
	{
		/**
		 * ! Find a way to dind out from paystack whether paytment really was made
		 */
		DB::beginTransaction();
		/**
		 * Fund Core Savings based on distribution
		 */
		$core_savings = $this->core_savings;
		$core_savings_amount = ($amount * ($core_savings->savings_distribution / 100));
		if ($core_savings_amount > 0) {
			$core_savings->current_balance += $core_savings_amount;
			$core_savings->funded_at  = $core_savings->funded_at ?? now();
			$core_savings->save();

			$core_savings->create_deposit_transaction($core_savings_amount);
		}
		/**
		 * Fund each gos saving based on distribution
		 */
		$gos_savings = $this->gos_savings;
		if (!$gos_savings->isEmpty()) {
			foreach ($gos_savings->all() as $savings) {
				$savings_amount = ($amount * ($savings->savings_distribution / 100));
				if ($savings_amount > 0) {
					$savings->current_balance += $savings_amount;
					$savings->funded_at  = $savings->funded_at ?? now();
					$savings->save();

					$savings->create_deposit_transaction($savings_amount);
				}
			}
		}
		/**
		 * Fund each locked savings based on distribution
		 */
		$locked_funds = $this->locked_savings;
		if (!$locked_funds->isEmpty()) {
			foreach ($locked_funds->all() as $savings) {
				$savings_amount = ($amount * ($savings->savings_distribution / 100));
				if ($savings_amount > 0) {
					$savings->current_balance += $savings_amount;
					$savings->funded_at  = $savings->funded_at ?? now();
					$savings->save();

					$savings->create_deposit_transaction($savings_amount);
				}
			}
		}

		DB::commit();
	}

	public function update_savings_distribution(Savings $savings, float $percentage)
	{
		$total_percentage = $this->savings_list()->where('id', '<>', $savings->id)->sum('savings_distribution') + $percentage;
		if ($total_percentage < 100) {
			$savings->savings_distribution = $percentage;
			$savings->save();
			return response()->json(['rsp' => 'savings distribution less than 100%'], 202);
		} else if ($total_percentage > 100) {
			return generate_422_error('Total percentage above 100%. Reduce one other one first');
		} else if ($total_percentage == 100) {
			$savings->savings_distribution = $percentage;
			$savings->save();
			return response()->json(['rsp' => true], 201);
		}
	}

	public function savings_interests()
	{
		return $this->hasManyThrough(SavingsInterest::class, Savings::class);
	}

	public function total_balance(): float
	{
		return $this->deposit_transactions()->sum('amount') + $this->savings_interests()->sum('amount');
	}

	public function is_eligible_for_loan(float $amount): bool
	{
		/**
		 * ? If the user is not up to one month old return false
		 */

		if (now()->subMonth()->lte($this->created_at)) {
			return false;
		}
		/**
		 * ? If the user has not made a contribution return false
		 */
		elseif ($this->deposit_transactions()->sum('amount') <= 0) {
			return false;
		}
		/**
		 * If the loan amount is more than 2 times the user's balance return false
		 */
		elseif ($amount > ($this->total_balance() * 2)) {
			return false;
		} elseif (!$this->is_bvn_verified) {
			return false;
		} elseif (!$this->default_debit_card()->exists()) {
			return false;
		} elseif ($this->has_pending_loan()) {
			return false;
		} elseif ($this->is_loan_surety()) {
			return false;
		} else {
			return true;
		}
	}

	public function is_eligible_for_loan_surety(float $amount): bool
	{
		// dd($this->deposit_transactions()->whereMonth('transactions.created_at', now()->month)->get()->toArray());
		/**
		 * ? If the user is not up to two months old return false
		 */

		if (now()->subMonths(2)->lte($this->created_at)) {
			return false;
		}
		/**
		 * ? If the user has not made a contribution return false
		 */
		elseif (!($this->deposit_transactions()->whereMonth('transactions.created_at', now()->month)->exists()
			&& $this->deposit_transactions()->whereMonth('transactions.created_at', now()->subMonth()->month)->exists())) {
			return false;
		}
		/**
		 * If the loan amount is more than 2 times the user's balance return false
		 */
		elseif ($amount > $this->total_balance()) {
			return false;
		} elseif (!$this->is_bvn_verified) {
			return false;
		} elseif (!$this->default_debit_card()->exists()) {
			return false;
		} elseif ($this->has_pending_loan()) {
			return false;
		} elseif ($this->is_loan_surety()) {
			return false;
		}
		/**
		 * Else he is eligible. Return true
		 */
		else {
			return true;
		}
	}

	public function has_pending_loan(): bool
	{
		return $this->loan_requests()->where('is_paid', false)->exists();
	}

	public function is_loan_surety(): bool
	{
		return  !is_null($this->surety_request) && $this->surety_request()->where('is_surety_accepted', null)->orWhere('is_surety_accepted', true)->exists();
	}

	/**
	 * The booting method of the model
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::deleting(function ($user) {
			$user->notifications()->delete();
		});

		// static::addGlobalScope('appUsersOnly', function (Builder $builder) {
		// 	$builder->where('role_id', parent::$app_user_id);
		// });
	}
}
