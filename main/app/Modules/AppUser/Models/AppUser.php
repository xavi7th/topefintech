<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Modules\AppUser\Models\Savings;
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

	public function transactions()
	{
		return $this->hasMany(Transaction::class, 'user_id');
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

	public function total_deposit_amount()
	{
		return $this->transactions()->where('trans_type', 'deposit')->sum('amount');
	}

	public function deposit_transactions()
	{
		return $this->transactions()->where('trans_type', 'deposit');
	}

	public function expected_withdrawal_amount()
	{
		return $this->transactions()->where('trans_type', 'deposit')->sum('target_amount');
	}

	public function total_withdrawal_amount()
	{
		return $this->transactions()->where('trans_type', 'withdrawal')->sum('amount');
	}

	public function total_withdrawalable_amount()
	{
		return $this->can_withdraw ? $this->expected_withdrawal_amount() : 0;
	}

	public function total_profit_amount()
	{
		return $this->transactions()->where('trans_type', 'profit')->sum('amount');
	}

	public function profit_transactions()
	{
		return $this->transactions()->where('trans_type', 'profit');
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
		$core_savings = $this->core_savings;
		$core_savings->current_balance += $amount;
		$core_savings->save();
	}

	public function distribute_savings(float $amount): void
	{
		DB::beginTransaction();
		/**
		 * Fund Core Savings based on distribution
		 */
		$core_savings = $this->core_savings;
		$core_savings->current_balance += ($amount * ($core_savings->savings_distribution / 100));
		$core_savings->save();
		/**
		 * Fund each gos saving based on distribution
		 */
		$gos_savings = $this->gos_savings;
		foreach ($gos_savings as $savings) {
			$savings->current_balance += ($amount * ($savings->savings_distribution / 100));
			$savings->save();
		}
		/**
		 * Fund each locked savings based on distribution
		 */
		$locked_funds = $this->locked_funds;
		foreach ($locked_funds as $savings) {
			$savings->current_balance += ($amount * ($savings->savings_distribution / 100));
			$savings->save();
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
