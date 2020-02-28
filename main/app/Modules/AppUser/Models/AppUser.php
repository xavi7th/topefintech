<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\WithdrawalRequest;

class AppUser extends User
{
	protected $fillable = [
		'name', 'email', 'password', 'phone', 'id_card'
	];

	protected $casts = [
		'can_withdraw' => 'boolean',
		'is_active' => 'boolean'
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

	public function debit_cards()
	{
		return $this->hasMany(DebitCard::class);
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

	public function total_balance()
	{
		if ($this->total_profit_amount() <= 0) {
			return 0;
		}
		return $this->total_profit_amount() + $this->total_deposit_amount();
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
		$core_savings->current_balance += $core_savings_amount = ($amount * ($core_savings->savings_distribution / 100));
		$core_savings->funded_at  = $core_savings->funded_at ?? now();
		$core_savings->save();

		$core_savings->create_deposit_transaction($core_savings_amount);
		/**
		 * Fund each gos saving based on distribution
		 */
		$gos_savings = $this->gos_savings;
		if (!$gos_savings->isEmpty()) {
			foreach ($gos_savings->all() as $savings) {
				$savings->current_balance += $savings_amount = ($amount * ($savings->savings_distribution / 100));
				$savings->funded_at  = $savings->funded_at ?? now();
				$savings->save();

				$savings->create_deposit_transaction($savings_amount);
			}
		}
		/**
		 * Fund each locked savings based on distribution
		 */
		$locked_funds = $this->locked_savings;
		if (!$locked_funds->isEmpty()) {
			foreach ($locked_funds->all() as $savings) {
				$savings->current_balance += $savings_amount = ($amount * ($savings->savings_distribution / 100));
				$savings->funded_at  = $savings->funded_at ?? now();
				$savings->save();

				$savings->create_deposit_transaction($savings_amount);
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
