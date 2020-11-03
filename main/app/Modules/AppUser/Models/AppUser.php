<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Inertia\Inertia;
use GuzzleHttp\Client;
use Paystack\Bank\GetBVN;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Paystack\Bank\ListBanks;
use Illuminate\Support\Facades\DB;
use App\Modules\Agent\Models\Agent;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Auth;
use Paystack\Bank\GetAccountDetails;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
use GuzzleHttp\Exception\ClientException;
use App\Modules\Admin\Models\ServiceCharge;
use App\Modules\AppUser\Models\Transaction;
use Gbowo\Adapter\Paystack\PaystackAdapter;
use App\Modules\AppUser\Models\AutoSaveSetting;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\Admin\Transformers\AdminTransactionTransformer;
use App\Modules\AppUser\Http\Requests\EditUserProfileValidation;
use App\Modules\Admin\Http\Requests\AdminEditUserProfileValidation;

/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @property int $id
 * @property string $full_name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $acc_num
 * @property string|null $acc_name
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $paystack_nuban
 * @property string|null $paystack_nuban_name
 * @property string|null $paystack_nuban_bank
 * @property string|null $bvn
 * @property string|null $bvn_name
 * @property bool $is_bvn_verified
 * @property bool $is_bank_verified
 * @property string|null $id_card
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property bool $can_withdraw
 * @property bool $is_active
 * @property int|null $agent_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|AutoSaveSetting[] $auto_save_settings
 * @property-read int|null $auto_save_settings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|DebitCard[] $debit_cards
 * @property-read int|null $debit_cards_count
 * @property-read DebitCard|null $default_debit_card
 * @property-read string $id_card_thumb_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\PaystackTransaction[] $paystack_transactions
 * @property-read int|null $paystack_transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $savings_list
 * @property-read int|null $savings_list_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read Agent|null $smart_collector
 * @property-read Savings|null $smart_savings
 * @property-read \Illuminate\Database\Eloquent\Collection|Savings[] $target_savings
 * @property-read int|null $target_savings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read WithdrawalRequest|null $withdrawal_request
 * @property-read \Illuminate\Database\Eloquent\Collection|WithdrawalRequest[] $withdrawal_requests
 * @property-read int|null $withdrawal_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereBvnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNuban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNubanBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePaystackNubanName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class AppUser extends User
{
  protected $fillable = [
    'full_name', 'email', 'password', 'phone', 'id_card', 'agent_id'
  ];
  protected $dates = ['email_verified_at', 'verified_at'];
  protected $casts = [
    'can_withdraw' => 'boolean',
    'is_active' => 'boolean',
    'is_bvn_verified' => 'boolean',
    'is_bank_verified' => 'boolean',
  ];
  protected $appends = ['id_card_thumb_url'];

  const DASHBOARD_ROUTE_PREFIX = "user";

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (self::hasRouteNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (self::hasRouteNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    }
  }

  public function smart_collector()
  {
    return $this->belongsTo(Agent::class, 'agent_id');
  }

  public function paystack_transactions()
  {
    return $this->hasMany(PaystackTransaction::class);
  }

  public function service_charges()
  {
    return $this->hasManyThrough(ServiceCharge::class, Savings::class)->latest('service_charges.created_at');
  }

  public function auto_save_settings()
  {
    return $this->hasMany(AutoSaveSetting::class)->latest();
  }

  public function debit_cards()
  {
    return $this->hasMany(DebitCard::class)->latest();
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
    return $this->hasMany(Savings::class)->latest();
  }

  public function smart_savings()
  {
    return $this->hasOne(Savings::class)->where('type', 'smart');
  }

  public function smart_savings_interests()
  {
    return optional($this->smart_savings)->savings_interests()->latest();
  }

  public function savings_interests()
  {
    return $this->hasManyThrough(SavingsInterest::class, Savings::class)->latest('savings_interests.created_at');
  }

  public function target_savings()
  {
    return $this->hasMany(Savings::class)->where('type', 'target')->latest();
  }

  public function withdrawal_requests()
  {
    return $this->hasMany(WithdrawalRequest::class)->latest();
  }

  public function previous_withdrawal_requests()
  {
    return $this->withdrawal_requests()->where('is_processed', true)->latest();
  }

  public function withdrawal_request()
  {
    return $this->hasOne(WithdrawalRequest::class)->where('is_processed', false);
  }

  public function transactions()
  {
    return $this->hasManyThrough(Transaction::class, Savings::class)->latest('transactions.created_at');
  }

  public function withdrawal_transactions()
  {
    return $this->transactions()->where('trans_type', 'withdrawal')->latest();
  }

  public function deposit_transactions()
  {
    return $this->transactions()->where('trans_type', 'deposit')->latest();
  }

  public function interestable_deposit_transactions()
  {
    return $this->deposit_transactions()->latest()->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
  }

  public function get_currency(): string
  {
    switch ($this->currency) {
      case 'USD':
        return '$';
        break;
      case 'GBP':
        return '£';
        break;
      case 'EUR':
        return '€';
        break;
      default:
        return $this->currency;
        break;
    }
  }

  public function is_verified(): bool
  {
    return $this->verified_at !== null;
  }

  public function is_managed_by(Agent $user): bool
  {
    return $this->smart_collector == $user;
  }
  public function is_email_verified(): bool
  {
    return $this->email_verified_at !== null;
  }

  public function has_authorised_card()
  {
    return $this->debit_cards()->where('is_authorised', true)->exists();
  }

  public function has_auto_save(): bool
  {
    return $this->auto_save_settings()->exists();
  }

  public function has_smart_savings(): bool
  {
    return $this->smart_savings()->exists();
  }

  public function has_target_savings(): bool
  {
    return $this->target_savings()->exists();
  }

  public function has_pending_withdrawal_request(): bool
  {
    return $this->withdrawal_request()->exists();
  }

  public function total_withdrawal_amount(): float
  {
    return $this->withdrawal_transactions()->sum('amount');
  }

  public function total_deposit_amount(): float
  {
    return $this->deposit_transactions()->sum('amount');
  }

  public function daily_interest(): float
  {
    return $this->savings_interests()->whereDate('savings_interests.created_at', today())->sum('amount');
  }

  public function total_interests_amount(): float
  {
    return $this->savings_interests()->sum('amount');
  }

  public function total_balance(): float
  {
    return $this->total_deposit_amount() + $this->total_interests_amount();
  }

  public function activeDays(): int
  {
    return now()->diffInDays($this->created_at);
  }

  public function deduct_debit_card(DebitCard $debit_card_to_deduct, float $amount): bool
  {
    if (!$debit_card_to_deduct->is_authorised) {
      return false;
    }

    return $debit_card_to_deduct->perform_recurrent_debit($amount);
  }

  public function fund_smart_savings(float $amount, string $desc = null): void
  {
    DB::beginTransaction();
    $smart_savings = $this->smart_savings;
    $smart_savings->current_balance += $amount;
    /**
     * Set the date of his first funding of this savings
     */
    $smart_savings->funded_at  = $smart_savings->funded_at ?? now();
    $smart_savings->save();

    $desc = $desc ?? 'Deposit into smart savings';
    $smart_savings->create_deposit_transaction($amount, $desc);

    DB::commit();
  }

  public function fund_target_savings(Savings $target_savings, float $amount): void
  {
    DB::beginTransaction();

    $target_savings->current_balance += $amount;
    /**
     * Specify the first time money was deposited into this profile.
     */
    $target_savings->funded_at  = $target_savings->funded_at ?? now();
    $target_savings->save();

    $target_savings->create_deposit_transaction($amount, 'Funding ' . $target_savings->target_type->name . ' savings');

    DB::commit();
  }

  public function defund_smart_savings(float $amount, string $desc = null): void
  {
    DB::beginTransaction();
    $smart_savings = $this->smart_savings;
    $smart_savings->current_balance -= $amount;
    $smart_savings->save();

    $desc = $desc ?? 'Automatic deduction from smart savings';
    $smart_savings->create_withdrawal_transaction($amount, $desc);

    DB::commit();
  }

  public function defund_target_savings(Savings $target_savings, float $amount): void
  {
    DB::beginTransaction();

    $target_savings->current_balance -= $amount;
    $target_savings->save();

    $target_savings->create_withdrawal_transaction($amount, 'Automatic deduction from ' . $target_savings->target_type->name . ' savings');

    DB::commit();
  }

  static function store_id_card()
  {
    return compress_image_upload('id_card', 'id_cards/' . now()->toDateString() . '/', 'id_cards/' . now()->toDateString() . '/thumbs/', 1400, true, 150)['img_url'];
  }

  static function findByEmail($email): object
  {
    return self::whereEmail($email)->firstOr(function () {
      return new self;
    });
  }

  public function validate_bvn(string $bvn, string $phone_number = null, string $full_name = null): object
  {
    try {
      $comparison_phone_number = $phone_number ?? $this->phone ?? abort(422,  'A valid phone number required to validate your BVN');
    } catch (\Throwable $th) {
      return (object)[
        'code' => 409,
        'msg' => $th->getMessage()
      ];
    }
    $comparison_full_name = $full_name ?? $this->full_name;
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new GetBVN(PaystackAdapter::API_LINK));

    $rsp = [
      "data" =>  [
        "first_name" => "EHIKIOYA",
        "last_name" => "AKHILE",
        "dob" => "15-Aug-85",
        "formatted_dob" => "1985-08-15",
        "mobile" => "08034411661",
        "bvn" => "22358166951",
      ],
      "meta" =>  [
        "calls_this_month" => 5,
        "free_calls_left" => 5,
      ]
    ];

    try {
      // $rsp = $paystack->getBVN($bvn);
      $data = (object)$rsp['data'];
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($this, $th, $th->getMessage());
      return (object)[
        'code' => $th->getCode(),
        'msg' => $th->getMessage()
      ];
    }

    /**
     * ! Verify via phone number
     */
    if ($data->mobile === get_11_digit_nigerian_number($comparison_phone_number)) {
      return (object)[
        'code' => 200,
        'msg' => 'The BVN is correct'
      ];
    } else {
      ErrLog::notifyAdmin($this, (new \Exception('BVN mismatch: ' . $bvn)), 'BVN supplied does not match supplied phone number');
      return (object)[
        'code' => 409,
        'msg' => 'This BVN does not belong to you.'
      ];
    }


    /**
     * ! Verify via full name
     */
    // if (Str::containsAll(strtoupper($comparison_full_name), [$data->first_name, $data->last_name])) {
    // 	return (object)[
    // 		'code' => 200,
    // 		'msg' => 'The BVN is correct'
    // 	];
    // } else {
    // 	ErrLog::notifyAdmin($this, (new \Exception('BVN mismatch: ' . $bvn)), 'BVN supplied does not match supplied full name');
    // 	return (object)[
    // 		'code' => 409,
    // 		'msg' => 'This BVN does not belong to you.'
    // 	];
    // }
  }

  public function validate_bank_account(string $acc_num, string $acc_bank, string $acc_name = null): int
  {
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new ListBanks(PaystackAdapter::API_LINK));
    $paystack->addPlugin(new GetAccountDetails(PaystackAdapter::API_LINK));

    $acc_name_to_compare = $acc_name ?? $this->full_name;

    $banks = collect($paystack->listBanks());
    $bank_details = $banks->filter(function ($item) use ($acc_bank) {
      return false !== stristr($item['name'], $acc_bank);
    })->first();

    if (is_null($bank_details)) {
      return 400;
    }

    $bank_object = (object)$bank_details;

    try {
      $data = (object)$paystack->getAccountDetails(["account_number" => $acc_num, "bank_code" => $bank_object->code]);
    } catch (ClientException $th) {
      if ($th->getCode() == 400) {
        ErrLog::notifyAdmin($this, $th, $th->getMessage());
        abort(400, $th->getResponse()->getReasonPhrase());
      } elseif ($th->getCode() == 422) {
        ErrLog::notifyAdmin($this, $th, $th->getMessage());
        return 422;
      }
    }

    if (Str::containsAll(strtolower($data->account_name), explode(' ', strtolower($acc_name_to_compare)))) {
      return 200;
    } else {
      return 409;
    }

    dd($data);
  }

  public function get_bank_account_name(string $acc_num, string $acc_bank): string
  {
    $paystack = new PaystackAdapter(new Client(
      [
        'base_uri' => config('services.paystack.base_url'),
        'headers' => [
          'Authorization' => 'Bearer ' . config('services.paystack.secret_key'),
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
          'User-Agent' => 'PHP/Gbowo'
        ]
      ]
    ));
    $paystack->addPlugin(new ListBanks(PaystackAdapter::API_LINK));
    $paystack->addPlugin(new GetAccountDetails(PaystackAdapter::API_LINK));

    $banks = collect($paystack->listBanks());
    $bank_details = $banks->filter(function ($item) use ($acc_bank) {
      return false !== stristr($item['name'], $acc_bank);
    })->first();

    if (is_null($bank_details)) {
      generate_422_error(['acc_num' => 'This bank name is incorrect or not verifiable. Try another form of the name if any']);
    }

    $bank_object = (object)$bank_details;

    try {
      $data = (object)$paystack->getAccountDetails(["account_number" => $acc_num, "bank_code" => $bank_object->code]);
    } catch (ClientException $th) {
      if ($th->getCode() == 400) {
        ErrLog::notifyAdmin($this, $th, $th->getMessage());
        generate_422_error(['acc_num' => $th->getResponse()->getReasonPhrase()]);
        abort(400, ['acc_num' => $th->getResponse()->getReasonPhrase()]);
      } elseif ($th->getCode() == 422) {
        ErrLog::notifyAdmin($this, $th, $th->getMessage());
        generate_422_error(['acc_num' => 'This account number is invalid']);
      }
    }

    return $data->account_name;
  }

  /**
   * Create a new OTP for the user
   *
   * Deletes all previous OTP codes, creates a new unique one and then returns it
   * @return string
   **/
  public function createVerificationToken(): string
  {
    $token = unique_random('password_resets', 'token', null, 100, true);

    // DB::table('password_resets')->where('email', $this->email)->delete();

    DB::table('password_resets')->insert(
      ['phone' => $this->phone, 'token' => $token, 'created_at' => now()]
    );

    return $token;
  }

  public function getIdCardThumbUrlAttribute(): string
  {
    return Str::of($this->id_card)->replace(Str::of($this->id_card)->dirname(), Str::of($this->id_card)->dirname() . '/thumbs');
  }

  static function adminRoutes()
  {
    Route::get('users', [self::class, 'getListOfUsers'])->name('admin.manage_users')->defaults('extras', ['icon' => 'fas fa-users']);
    Route::put('user/{user}/verify', [self::class, 'verifyUser'])->name('admin.user.verify');
    Route::get('user/{appUser}/statement', [self::class, 'adminGetUserAccountStatement'])->name('admin.user.statement')->defaults('extras', ['nav_skip' => true]);
    Route::get('user/{appUser:phone}/profile', [self::class, 'adminViewUserProfile'])->name('admin.user.profile')->defaults('extras', ['nav_skip' => true]);
    Route::put('user/{appUser:phone}/profile', [self::class, 'adminEditUserProfile'])->name('admin.user.profile.edit')->defaults('extras', ['nav_skip' => true]);
  }

  static function adminApiRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

      Route::delete('user/{user}/delete', [self::class, 'deleteUser']);

      Route::get('user/{user}/transactions', [self::class, 'getUserTransactions']);
    });
  }

  static function routes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      Route::get('/auth/verify', [self::class, 'verifyAuth']);
      Route::post('/account/verify', [self::class, 'verifyUserAccount'])->name('appuser.account.verify')->defaults('extras', ['nav_skip' => true]);
      Route::get('profile', [self::class, 'getUserProfile'])->name('appuser.my_profile')->defaults('extras', ['nav_skip' => true]);
      Route::put('/profile/edit', [self::class, 'editUserProfile'])->name('appuser.profile.edit');
      Route::get('/notifications', [self::class, 'getUserNotifications'])->name('appuser.notifications')->defaults('extras', ['nav_skip' => true]);
      Route::get('statement', [self::class, 'getUserAccountStatement'])->name('appuser.statement')->defaults('extras', ['icon' => 'far fa-file-alt']);
    });
  }

  public function verifyUserAccount(Request $request)
  {
    if (!$request->acc_num || !$request->acc_bank) {
      generate_422_error(['acc_num' => 'Account name and number required',]);
    }

    $res = $this->get_bank_account_name($request->acc_num, $request->acc_bank);
    if ($request->isApi()) return ['rsp' => $res];

    session()->flash('account_name', $res);
    return back()->withFlash(['success' => 'Account validated successfully']);
  }

  public function getUserProfile(Request $request)
  {
    if ($request->isApi()) return (new AppUserTransformer)->detailed($request->user());
    return Inertia::render('AppUser,UserProfile', [
      'banks' => fn () => $this->getBanksList(),
      'account_name' => fn () => session('account_name')
    ]);
  }

  public function editUserProfile(EditUserProfileValidation $request)
  {
    // dd($request);
    // compress_image_upload('id_card', 'id_cards', 'id_cards/thumbs');
    try {
      /**
       * If updating bvn, set is_bvn_verified to false
       */
      if ($request->bvn) {
        $request->user()->is_bvn_verified = true;
      }

      if ($request->acc_num) {
        $request->user()->is_bank_verified = true;
      }

      if ($request->id_card) {
        $request->user()->id_card = $request->user()->store_id_card();
      }

      /**
       * ? Disable updating phone number if bvn is already verified
       */

      if ($request->user()->is_bvn_verified) {
        foreach (collect($request->validated())->except(['id_card', 'phone']) as $key => $value) {
          $request->user()->$key = $value;
        }
      } else {
        foreach (collect($request->validated())->except('id_card') as $key => $value) {
          $request->user()->$key = $value;
        }
      }


      $request->user()->save();

      if ($request->password) {
        Auth::logout();
      }

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withFlash(['success' => 'Profile details updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Account details NOT updated');
      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withFlash(['error' => 'Account details NOT updated']);
    }

    Auth::apiuser()->update($request->validated());
    return response()->json(['updated' => true], 205);
  }

  public function getUserNotifications(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();

    if ($request->isApi()) {
      return $request->user()->notifications;
    }
    return Inertia::render('AppUser,UserNotifications', [
      'notifications' => $request->user()->notifications
    ]);
  }

  public function getUserAccountStatement(Request $request)
  {
    $userStatement = cache()->remember('users', config('cache.account_statement_cache_duration'), function () use ($request) {
      return $request->user()->load([
        'savings_interests.savings.target_type',
        'service_charges',
        'transactions'
      ]);
    });

    $account_statement = collect($userStatement->savings_interests)
      ->merge($userStatement->service_charges)
      ->merge($userStatement->transactions)->sortByDesc('created_at')->values();

    if ($request->isApi()) {
      return $account_statement;
    }

    return Inertia::render('AppUser,UserTransactionHistory', compact('account_statement'));
  }

  public function getListOfUsers(Request $request)
  {
    $users = (new AdminUserTransformer)->collectionTransformer(AppUser::all(), 'transformForAdminViewUsers');
    if ($request->isApi())
      return $users;

    return Inertia::render('Admin,ManageUsers', compact('users'));
  }

  public function verifyUser(Request $request, self $user)
  {
    $user->verified_at = now();
    $user->save();

    if ($request->isApi())
      return response()->json([], 204);

    return back()->withFlash(['success' => 'User verified. They will be able to access their dashboard now']);
  }

  public function deleteUser(self $user)
  {
    $user->transactions()->delete();
    return response()->json(['rsp' => $user->delete()], 204);
  }

  public function adminViewUserProfile(Request $request, self $appUser)
  {
    if ($request->isApi()) return (new AppUserTransformer)->detailed($appUser);

    return Inertia::render('Admin,ManageUserProfile', [
      'banks' => fn () => $this->getBanksList(),
      'user_details' => (new AppUserTransformer)->detailed($appUser)
    ]);
  }

  public function adminEditUserProfile(AdminEditUserProfileValidation $request, self $appUser)
  {
    try {

      if ($request->id_card) {
        $appUser->id_card = $appUser->store_id_card();
      }

      foreach (collect($request->validated())->except(['id_card', 'phone']) as $key => $value) {
        $appUser->$key = $value;
      }

      $appUser->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success' => 'Profile details updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Account details NOT updated');
      if ($request->isApi()) return response()->json(['err' => 'Account details NOT updated'], 500);
      return back()->withFlash(['error' => 'Account details NOT updated']);
    }
  }

  public function adminGetUserAccountStatement(Request $request, AppUser $appUser)
  {
    $userStatement = cache()->remember('users', config('cache.account_statement_cache_duration'), function () use ($appUser) {
      return $appUser->load([
        'savings_interests.savings.target_type',
        'service_charges',
        'transactions'
      ]);
    });

    $account_statement = collect($userStatement->savings_interests)
      ->merge($userStatement->service_charges)
      ->merge($userStatement->transactions)->sortByDesc('created_at')->values();

    if ($request->isApi()) {
      return $account_statement;
    }

    return Inertia::render('AppUser,savings/AdminViewUserTransactionHistory', compact('account_statement', 'appUser'));
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

  protected function getBanksList(): array
  {
    return [
      'Access Bank', 'Access Bank (Diamond)', 'ALAT by WEMA', 'ASO Savings and Loans', 'Bowen Microfinance Bank', 'CEMCS Microfinance Bank', 'Citibank Nigeria', 'Ecobank Nigeria', 'Ekondo Microfinance Bank', 'Fidelity Bank', 'First Bank of Nigeria', 'First City Monument Bank', 'Globus Bank', 'Guaranty Trust Bank', 'Hasal Microfinance Bank', 'Heritage Bank', 'Jaiz Bank', 'Keystone Bank', 'Kuda Bank', 'One Finance', 'Parallex Bank', 'Polaris Bank', 'Providus Bank', 'Rubies MFB', 'Sparkle Microfinance Bank', 'Stanbic IBTC Bank', 'Standard Chartered Bank', 'Sterling Bank', 'Suntrust Bank', 'TAJ Bank', 'TCF MFB', 'Titan Bank', 'Union Bank of Nigeria', 'United Bank For Africa', 'Unity Bank', 'VFD', 'Wema Bank', 'Zenith Bank',
    ];
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
