<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Support\Facades\Storage;
use App\Modules\AppUser\Models\DebitCard;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\AppUser\Models\LoanSurety;
use App\Modules\Admin\Models\ServiceCharge;
use App\Modules\AppUser\Models\LoanRequest;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\AutoSaveSetting;
use App\Modules\AppUser\Models\LoanTransaction;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Transformers\AppuserTransformer;
use App\Modules\Admin\Transformers\AdminTransactionTransformer;
use App\Modules\AppUser\Http\Requests\EditUserProfileValidation;

/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $acc_num
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $bvn
 * @property bool $is_bvn_verified
 * @property bool $is_bank_verified
 * @property string|null $id_card
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $can_withdraw
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\AutoSaveSetting[] $auto_save_settings
 * @property-read int|null $auto_save_settings_count
 * @property-read \App\Modules\AppUser\Models\Savings $core_savings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\DebitCard[] $debit_cards
 * @property-read int|null $debit_cards_count
 * @property-read \App\Modules\AppUser\Models\DebitCard $default_debit_card
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $gos_savings
 * @property-read int|null $gos_savings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanRequest[] $loan_requests
 * @property-read int|null $loan_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanSurety[] $loan_surety_requests
 * @property-read int|null $loan_surety_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\LoanTransaction[] $loan_transactions
 * @property-read int|null $loan_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $locked_savings
 * @property-read int|null $locked_savings_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $previous_withdrawal_requests
 * @property-read int|null $previous_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Savings[] $savings_list
 * @property-read int|null $savings_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read \App\Modules\AppUser\Models\LoanSurety $surety_request
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Modules\AppUser\Models\WithdrawalRequest $withdrawal_request
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AppUser whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class AppUser extends User
{
	protected $fillable = [
		'full_name', 'email', 'password', 'phone', 'id_card'
	];
	protected $dates = ['email_verified_at', 'verified_at'];
	protected $casts = [
		'can_withdraw' => 'boolean',
		'is_active' => 'boolean',
		'is_bvn_verified' => 'boolean',
		'is_bank_verified' => 'boolean',
	];
	protected $table = "users";

	const DASHBOARD_ROUTE_PREFIX = "user";

	static function canAccess()
	{
		return Auth::user() instanceof AppUser;
	}

	public function is_verified(): bool
	{
		return $this->verified_at !== null;
	}

	public function is_email_verified(): bool
	{
		return $this->email_verified_at !== null;
	}

	public function service_charges()
	{
		return $this->hasManyThrough(ServiceCharge::class, Savings::class);
	}


	public function loan_requests()
	{
		return $this->hasMany(LoanRequest::class);
	}

	public function loan_transactions()
	{
		return $this->hasManyThrough(LoanTransaction::class, LoanRequest::class);
	}

	public function request_for_surety()
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

	public function has_auto_save(): bool
	{
		return $this->auto_save_settings()->exists();
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

	public function core_savings_interests()
	{
		return optional($this->core_savings)->savings_interests();
	}

	public function total_withdrawable_amount(): float
	{
		return optional($this->core_savings)->current_balance;
	}

	public function gos_savings()
	{
		return $this->hasMany(Savings::class)->where('type', 'gos');
	}

	public function locked_savings()
	{
		return $this->hasMany(Savings::class)->where('type', 'locked');
	}

	public function has_core_savings(): bool
	{
		return $this->core_savings()->exists();
	}

	public function has_gos_savings(): bool
	{
		return $this->gos_savings()->exists();
	}

	public function has_locked_savings(): bool
	{
		return $this->locked_savings()->exists();
	}

	public function total_distribution_percentage(): float
	{
		return $this->savings_list()->sum('savings_distribution');
	}

	public function previous_withdrawal_requests()
	{
		return $this->hasMany(WithdrawalRequest::class)->where('is_processed', true);
	}

	public function withdrawal_request()
	{
		return $this->hasOne(WithdrawalRequest::class)->where('is_processed', false);
	}

	public function has_pending_withdrawal_request(): bool
	{
		return $this->withdrawal_request()->exists();
	}

	public function transactions()
	{
		return $this->hasManyThrough(Transaction::class, Savings::class);
	}

	public function withdrawal_transactions()
	{
		return $this->transactions()->where('trans_type', 'withdrawal');
	}

	public function total_withdrawal_amount()
	{
		return $this->withdrawal_transactions()->sum('amount');
	}

	public function is_due_for_withdrawal(): bool
	{
		/**
		 * check if withdrawal was done in last month
		 * check if withdrawal was done in last 20 days
		 */

		if (
			$this->previous_withdrawal_requests()->whereMonth('created_at', now()->month)->exists() ||
			$this->previous_withdrawal_requests()->whereDate('created_at', '>=', now()->subDays(20))->exists()
		) {
			return false;
		}
		return true;
	}

	public function deposit_transactions()
	{
		return $this->transactions()->where('trans_type', 'deposit');
	}

	public function total_deposit_amount(): float
	{
		return $this->deposit_transactions()->sum('amount');
	}

	public function interestable_deposit_transactions()
	{
		return $this->deposit_transactions()->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
	}

	public function savings_interests()
	{
		return $this->hasManyThrough(SavingsInterest::class, Savings::class);
	}

	public function total_interests_amount(): float
	{
		return $this->savings_interests()->sum('amount');
	}

	public function total_balance(): float
	{
		return $this->total_deposit_amount() + $this->total_interests_amount();
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

	public function loan_surety_amount(): float
	{
		return ($this->surety_request()->where('is_surety_accepted', null)->orWhere('is_surety_accepted', true)->get()->load('loan_requests'))->sum('loan_request.amount');
	}

	public function activeDays(): int
	{
		return now()->diffInDays($this->created_at);
	}

	public function deduct_debit_card(DebitCard $debit_card_to_deduct, float $amount): bool
	{
		return (bool)mt_rand(0, 1);
	}

	public function fund_core_savings(float $amount, string $desc = null): void
	{
		DB::beginTransaction();
		$core_savings = $this->core_savings;
		$core_savings->current_balance += $amount;
		/**
		 * Set the date of his first funding of this savings
		 */
		$core_savings->funded_at  = $core_savings->funded_at ?? now();
		$core_savings->save();

		$desc = $desc ?? 'Deposit into core savings';
		$core_savings->create_deposit_transaction($amount, $desc);

		DB::commit();
	}

	public function fund_locked_savings(Savings $locked_savings, float $amount): void
	{

		DB::beginTransaction();
		$locked_savings->current_balance += $amount;
		/**
		 * Specify the first time money was deposited into this profile.
		 */
		$locked_savings->funded_at  = $locked_savings->funded_at ?? now();
		$locked_savings->save();

		$locked_savings->create_deposit_transaction($amount, 'Funding ' . $this->gos_type->name . ' savings');

		DB::commit();
	}

	public function distribute_savings(float $amount, string $description = null): void
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

			$description = $description ?? 'Distributed savings into core savings';
			$core_savings->create_deposit_transaction($core_savings_amount, $description);
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

					$description = $description ?? 'Distributed savings into ' . $savings->gos_type->name . ' savings';
					$savings->create_deposit_transaction($savings_amount, $description);
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

					$description = $description ?? 'Distributed savings into smart lock savings';
					$savings->create_deposit_transaction($savings_amount, $description);
				}
			}
		}

		DB::commit();
	}

	public function update_savings_distribution(Request $request)
	{
		$savings_list = $request->user()->savings_list;
		foreach ($request->all() as $val) {
			$savings_list->where('id', $val['id'])->first()->savings_distribution = $val['savings_distribution'];
		}

		return response()->json($request->user()->savings_list()->saveMany($savings_list), 201);
	}

	static function store_id_card(Request $request)
	{
		Storage::makeDirectory('public/id_cards/' . now()->toDateString());
		$id_url = Storage::url($request->file('id_card')->store('public/id_cards/' . now()->toDateString()));

		return $id_url;
	}

	static function findByEmail($email): object
	{
		return self::whereEmail($email)->firstOr(function () {
			return new self;
		});
	}

	public function create_loan_request(float $amount, string $repayment_installation_duration, $auto_debit = false): ?object
	{
		try {
			return $this->loan_requests()->create([
				'amount' => $amount,
				'expires_at' => now()->addMonths(3),
				'interest_rate' => config('app.smart_loan_interest_rate'),
				'repayment_installation_duration' => $repayment_installation_duration,
				'auto_debit' => filter_var($auto_debit, FILTER_VALIDATE_BOOLEAN),
				'loan_ref' => unique_random('loan_requests', 'loan_ref', null, 12)
			]);
		} catch (\Throwable $th) {
			ErrLog::notifyAdmin(auth()->user(), $th, 'Loan request creation failed');
			return null;
		}
	}

	public function create_surety_requests(string $first_surety_email, int $loan_request_id, string $second_surety_email = null): ?object
	{
		try {
			if ($second_surety_email) {
				$this->request_for_surety()->create(
					[
						'surety_id' => self::findByEmail($second_surety_email)->id,
						'loan_request_id' => $loan_request_id,
					]
				);
			}
			return $this->request_for_surety()->create(
				[
					'surety_id' => self::findByEmail($first_surety_email)->id,
					'loan_request_id' => $loan_request_id,
				]
			);
		} catch (\Throwable $th) {
			ErrLog::notifyAdmin($this, $th, 'Loan request creation failed');
			return null;
		}
	}

	static function adminApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('users', 'AppUser@getListOfUsers');

			Route::delete('user/{user}/delete', 'AppUser@deleteUser');

			Route::get('user/{user}/transactions', 'AppUser@getUserTransactions');
		});
	}

	static function routes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => self::DASHBOARD_ROUTE_PREFIX], function () {
			Route::get('/auth/verify', 'AppUser@verifyAuth');
		});
	}

	static function apiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/profile', 'AppUser@getUserProfile');
			Route::post('/profile/edit', 'AppUser@editUserProfile');
		});
	}

	public function getUserProfile(Request $request)
	{
		return (new AppuserTransformer)->detailed($request->user());
	}

	public function editUserProfile(EditUserProfileValidation $request)
	{
		try {
			/**
			 * If updating bvn, set is_bvn_verified to false
			 */
			if ($request->bvn) {
				$request->user()->is_bvn_verified = false;
			}

			if ($request->id_card) {
				$request->user()->id_card = $request->user()->store_id_card($request);
			}

			foreach (collect($request->validated())->except('id_card') as $key => $value) {
				$request->user()->$key = $value;
			}
			$request->user()->save();

			return response()->json([], 204);
		} catch (\Throwable $th) {
			ErrLog::notifyAdmin(auth()->user(), $th, 'Account details NOT updated');
			return response()->json(['err' => 'Account details NOT updated'], 500);
		}

		Auth::apiuser()->update($request->validated());
		return response()->json(['updated' => true], 205);
	}

	public function getListOfUsers()
	{
		return (new AdminUserTransformer)->collectionTransformer(AppUser::all(), 'transformForAdminViewUsers');
	}

	public function deleteUser(AppUser $user)
	{
		$user->transactions()->delete();
		return response()->json(['rsp' => $user->delete()], 204);
	}

	public function getUserTransactions(AppUser $user)
	{
		$transactions = $user->transactions()->when(
			request('sort'),
			function ($query) {
				$sort_params = explode('|', request('sort'));
				$sort_param = $sort_params[0]; // == 'is_verified' ? 'verified_at' : $sort_params[0];
				$sort_type = $sort_params[1];

				return $query->orderBy($sort_param, $sort_type);
			},
			function ($query) {
				return $query->latest('trans_date');
			}
		)
			->when(request('filter'), function ($query) {
				$filter = request('filter');
				return $query->where(function ($query) use ($filter) {
					$query->where('amount', 'LIKE',  "%$filter%")->orWhere('trans_type', 'LIKE', "%$filter%");
				});
			})->paginate(request('per_page'));

		return (new AdminTransactionTransformer)->collectionTransformer($transactions, 'transformForAdminViewTransactions');
	}

	public function verifyAuth()
	{
		if (Auth::check()) {
			return ['LOGGED_IN' => true, 'user' => Auth::user()];
		} else {
			return ['LOGGED_IN' => false, 'user' => []];
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
