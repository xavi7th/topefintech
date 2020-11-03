<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Notifications\SendAccountVerificationMessage;
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;
use App\Modules\AppUser\Notifications\WithdrawalRequestCreatedNotification;
use App\Modules\AppUser\Notifications\DeclinedWithdrawalRequestNotification;
use App\Modules\AppUser\Notifications\ProcessedWithdrawalRequestNotification;

/**
 * App\Modules\AppUser\Models\WithdrawalRequest
 *
 * @property int $id
 * @property int $app_user_id
 * @property float|null $amount
 * @property bool $is_processed
 * @property bool $is_charge_free
 * @property int|null $processed_by
 * @property string|null $processor_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $processor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereIsChargeFree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereProcessedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereProcessorType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\WithdrawalRequest withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\WithdrawalRequest whereDescription($value)
 * @property int $is_user_verified
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest userUnverified()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest userVerified()
 * @method static \Illuminate\Database\Eloquent\Builder|WithdrawalRequest whereIsUserVerified($value)
 */
class WithdrawalRequest extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'app_user_id', 'description', 'amount', 'is_charge_free'
  ];

  protected $casts = [
    'is_processed' => 'boolean',
    'is_charge_free' => 'boolean',
    'amount' => 'double',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    Inertia::setRootView('appuser::app');
  }

  public function processor()
  {
    return $this->morphTo('processor', 'processor_type', 'processed_by');
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'withdrawal-requests'], function () {
      Route::get('', [self::class, 'getWithdrawalRequests'])->name('appuser.withdraw.requests')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
      Route::get('create', [self::class, 'showWithdrawalForm'])->name('appuser.withdraw')->defaults('extras', ['nav_skip' => true]);
      Route::post('{savings_id}/create', [self::class, 'createWithdrawalRequest'])->name('appuser.withdraw.create');
      Route::post('verify', [self::class, 'verifyWithdrawalRequest'])->name('appuser.withdraw.verify');
    });
  }

  static function adminApiRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'withdrawal-requests'], function () {
      Route::get('', 'WithdrawalRequest@adminGetWithdrawalRequests');
      Route::put('/{withdrawal_request}/mark-complete', 'WithdrawalRequest@approveWithdrawalRequest');
      Route::put('/{withdrawal_request}/cancel', 'WithdrawalRequest@cancelWithdrawalRequest');
    });
  }

  /**
   * App User Routes
   */

  public function showWithdrawalForm(Request $request)
  {
    return Inertia::render('AppUser,withdraw/MakeWithdrawalRequest');
  }

  public function getWithdrawalRequests(Request $request)
  {
    $withdrawal_requests = $request->user()->withdrawal_requests()->latest()->withTrashed()->get();
    $statistics = [
      'total_pending' => $request->user()->withdrawal_requests()->where('is_processed', false)->count(),
      'total_processed' => $request->user()->withdrawal_requests()->where('is_processed', true)->count(),
      'total_declined' => $request->user()->withdrawal_requests()->onlyTrashed()->count(),
    ];
    if ($request->isApi()) {
      return response()->json($withdrawal_requests, 200);
    }

    return Inertia::render('AppUser,withdraw/ViewWithdrawalRequests', compact('withdrawal_requests', 'statistics'));
  }

  public function createWithdrawalRequest(CreateWithdrawalRequestValidation $request, $savings_id)
  {
    try {
      /**
       * Create a withdrawal request
       */
      $withdrawal_request = $request->user()->withdrawal_request()->create($request->validated());

      $token = $request->user()->createVerificationToken();
      $request->user()->notify((new SendAccountVerificationMessage('sms', $token, 'A withdrawal request was initialised on your account. Use this OTP: ' . $token . 'to verify the request to enable us proceed.'))->onQueue('high'));

      if ($request->isApi()) return response()->json($withdrawal_request, 201);
      return back()->withFlash(['success' => 'A withdrawal request was initialised on your account. Use this OTP to verify the request to enable us proceed.']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Withdrawal request NOT created');
      if ($request->isApi())  return response()->json(['err' => 'Withdrawal request not created'], 500);
      abort(500, 'An error occured while creating the request');
    }
  }

  public function verifyWithdrawalRequest(Request $request)
  {
    DB::beginTransaction();
    // Search for code or abort
    // Search for pending request or abort
    // Mark Withdrawal request as user verified
    //

    $withdrawal_request = $request->user()->pending_withdrawal_request;
    $savings = $withdrawal_request->savings_portfolio;

    /**
     * Delete the savings profile
     */

    $savings->deleted_at = now();
    $savings->is_withdrawn = true;
    $savings->save();

    /**
     * Notify user that his request was created
     */
    try {
      $request->user()->notify(new WithdrawalRequestCreatedNotification($savings->current_balance));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Withdrawal request created notification failed');
    }


    if ($request->isApi()) return response()->json($withdrawal_request, 201);
    return back()->withFlash(['success' => 'Withdrawal request sent. We will update you on the status of your request']);
  }

  /**
   * Admin routes
   * @return Illuminate\Http\JsonResponse
   */
  public function adminGetWithdrawalRequests()
  {
    return response()->json(self::with('processor')->withTrashed()->get(), 200);
  }

  public function cancelWithdrawalRequest(self $withdrawal_request)
  {
    DB::beginTransaction();
    $request_details = $withdrawal_request;

    /**
     * On withdrawal decline remember to top up the current balance back
     */
    $request_details->app_user->smart_savings->current_balance += $request_details->amount;
    $request_details->app_user->smart_savings->save();

    /**
     * Notify user that his request was declined
     */
    try {
      $request_details->app_user->notify(new DeclinedWithdrawalRequestNotification($request_details->amount));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request_details->app_user, $th, 'Declined withdrawal notification failed');
    }

    /**
     * Delete the request;
     */
    $request_details->delete();

    DB::commit();

    return response()->json([], 204);
  }

  public function approveWithdrawalRequest(self $withdrawal_request)
  {
    if ($withdrawal_request->is_processed) {
      ActivityLog::notifyAdmins(auth()->user()->email . ' attempted to approve an already processed request: ' . $withdrawal_request->id);
      return generate_422_error('Request has been processed already');
    }

    DB::beginTransaction();

    /**
     * on approval add a withdrawal transaction for the users smart savings_id
     */
    $desc = $withdrawal_request->is_charge_free ? 'Withdrawal from smart savings balance' : 'Charge-deductible withdrawal from smart savings balance';
    $withdrawal_request->app_user->smart_savings->create_withdrawal_transaction($withdrawal_request->amount, $desc);

    if (!$withdrawal_request->is_charge_free) {
      /**
       * Get deductible percentage of withdrawal request amount
       */
      $withdrawal_charge = $withdrawal_request->amount * (config('app.undue_withdrawal_charge_percentage') / 100);

      /**
       * Create a service charge transaction for this savings for the withdrawal if it is a chargeable withdrawal
       */
      $withdrawal_request->app_user->smart_savings->create_service_charge($withdrawal_charge, 'Amount deducted for multiple consecutive withdrawals');
    }

    /**
     * Mark the request as processed
     */
    $withdrawal_request->is_processed = true;
    $withdrawal_request->processed_by = auth()->id();
    $withdrawal_request->processor_type = get_class(auth()->user());
    $withdrawal_request->save();

    DB::commit();

    /**
     * Notify user that his request has been processed
     */
    try {
      $withdrawal_request->app_user->notify(new ProcessedWithdrawalRequestNotification($withdrawal_request));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($withdrawal_request->app_user, $th, 'Processed withdrawal notification failed');
    }


    return response()->json([], 204);
  }

  public function scopeUserVerified($query)
  {
    return $query->whereIsUserVerified(true);
  }

  public function scopeUserUnverified($query)
  {
    return $query->whereIsUserVerified(false);
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function ($withdrawal_request) {
      ActivityLog::notifyAdmins(auth()->user()->email . ' requested a withdrawal request of ' . to_naira($withdrawal_request->amount));
    });

    static::deleting(function ($withdrawal_request) {
      if (!$withdrawal_request->isForceDeleting()) {
        ActivityLog::notifyAdmins(auth()->user()->email . ' declined ' . $withdrawal_request->app_user->email . '\'s withdrawal request of ' . to_naira($withdrawal_request->amount));
      }
    });

    static::retrieved(function ($withdrawal_request) {
      $withdrawal_request->load('app_user');
    });

    static::updating(function ($withdrawal_request) {
      // dump($withdrawal_request->getOriginal());
      // dd($withdrawal_request->toArray());

      if ($withdrawal_request->is_processed) {
        ActivityLog::notifyAdmins(auth()->user()->email . ' processed ' . $withdrawal_request->app_user->full_name . '\'s withdrawal request of ' . $withdrawal_request->amount);
      }
    });
  }
}
