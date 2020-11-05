<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\ActivityLog;
use App\Modules\Admin\Transformers\AdminWithdrawalRequestTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use App\Modules\AppUser\Notifications\SendAccountVerificationMessage;
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;
use App\Modules\AppUser\Notifications\WithdrawalRequestCreatedNotification;
use App\Modules\AppUser\Notifications\DeclinedWithdrawalRequestNotification;
use App\Modules\AppUser\Notifications\ProcessedWithdrawalRequestNotification;

class WithdrawalRequest extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'app_user_id', 'description', 'amount', 'is_charge_free', 'savings_id'
  ];

  protected $casts = [
    'is_processed' => 'boolean',
    'is_charge_free' => 'boolean',
    'is_user_verified' => 'boolean',
    'amount' => 'double',
  ];

  public function processor()
  {
    return $this->morphTo('processor', 'processor_type', 'processed_by');
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function savingsPortfolio()
  {
    return $this->belongsTo(Savings::class, 'savings_id');
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'withdrawal-requests'], function () {
      Route::get('', [self::class, 'getWithdrawalRequests'])->name('appuser.withdraw.requests')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
      Route::get('create', [self::class, 'showWithdrawalForm'])->name('appuser.withdraw')->defaults('extras', ['nav_skip' => true]);
      Route::post('{savings}/create', [self::class, 'createWithdrawalRequest'])->name('appuser.withdraw.create');
      Route::post('verify', [self::class, 'verifyWithdrawalRequest'])->name('appuser.withdraw.verify');
    });
  }

  static function adminRoutes()
  {
    Route::prefix('withdrawal-requests')->name('admin.')->group(function () {
      Route::get('', [self::class, 'adminGetWithdrawalRequests'])->name('withdrawal_requests')->defaults('extras', ['icon' => 'fa fa-x-ray']);
      Route::put('/{withdrawal_request}/mark-complete', [self::class, 'approveWithdrawalRequest'])->name('withdrawal_request.mark_complete');
      Route::put('/{withdrawal_request}/cancel', [self::class, 'cancelWithdrawalRequest'])->name('withdrawal_request.delete');
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

  public function createWithdrawalRequest(CreateWithdrawalRequestValidation $request, Savings $savings)
  {

    try {
      if (!$request->user()->hasUnverifiedWithdrawalRequest()) {
        DB::beginTransaction();

        /**
         * Create a withdrawal request
         */
        $withdrawal_request = $request->user()->withdrawal_request()->create($request->validated());

        $token = $request->user()->createVerificationToken();
        $request->user()->notify((new SendAccountVerificationMessage('sms', $token, 'A withdrawal request was initialised on your account for your ' . $savings->type . ' savings. Use this OTP: ' . $token . 'to verify the request to enable us proceed.'))->onQueue('high'));

        DB::commit();
      }

      if ($request->isApi()) return response()->json($withdrawal_request, 201);
      return back()->withFlash([
        'success' => 'A withdrawal request has been initialised on your account. Use this OTP to verify the request to enable us proceed.',
        'verification_needed' => 'A withdrawal request has been initialised on your account. Use the OTP sent to your registered phone number to verify the request to enable us proceed.'
      ]);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Withdrawal request NOT created');
      if ($request->isApi())  return response()->json(['err' => 'Withdrawal request not created'], 500);
      abort(500, 'An error occured while creating the request');
    }
  }

  public function verifyWithdrawalRequest(Request $request)
  {
    $tokenRecord = DB::table('password_resets')->where('token', $request->otp)->first();
    if (!$tokenRecord) throw ValidationException::withMessages(['err' => 'Invalid token!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $user = AppUser::where('phone', $tokenRecord->phone)->firstOr(function () {
      throw ValidationException::withMessages(['err' => 'Invalid or stale request. Contact Support for assistance!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    if (!$user->is($request->user())) throw ValidationException::withMessages(['err' => 'Request not permitted! Contact our support team for more information.'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $withdrawalRequest = $user->pendingWithdrawalRequest;
    if (!$withdrawalRequest) throw ValidationException::withMessages(['err' => 'You currently have no pending withdrawal requests.'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    DB::transaction(function () use ($withdrawalRequest) {
      $withdrawalRequest->is_user_verified = true;
      $withdrawalRequest->save();
    });

    DB::table('password_resets')->where('token', $request->otp)->delete();

    try {
      $user->notify(new WithdrawalRequestCreatedNotification($withdrawalRequest->amount));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($user, $th, 'Withdrawal request created notification failed');
    }

    if ($request->isApi()) return response()->json($withdrawalRequest, 201);
    return back()->withFlash(['success' => 'Withdrawal request verified. We will update you on the status of your request', 'verifiation_succeded' => true]);
  }

  /**
   * Admin routes
   * @return Illuminate\Http\JsonResponse
   */
  public function adminGetWithdrawalRequests(Request $request)
  {
    $withdrawal_requests = Cache::rememberForever('withdrawalRequests', fn () => (new AdminWithdrawalRequestTransformer)->collectionTransformer(self::with(['processor', 'app_user.smart_collector', 'savingsPortfolio'])->withTrashed()->get(), 'detailed'));

    if ($request->isApi()) return $withdrawal_requests;
    return Inertia::render('Admin,WithdrawalRequests', compact('withdrawal_requests'));
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

  public function scopeProcessed($query)
  {
    return $query->whereIsProcessed(true);
  }

  public function scopeUnprocessed($query)
  {
    return $query->whereIsProcessed(false);
  }

  protected static function boot()
  {
    parent::boot();

    static::created(function (self $withdrawalRequest) {
      ActivityLog::notifyAdmins(auth()->user()->email . ' requested a withdrawal request of ' . to_naira($withdrawalRequest->amount));
    });

    static::saved(function (self $withdrawalRequest) {
      Cache::forget('withdrawalRequests');
    });

    static::deleting(function ($withdrawal_request) {
      if (!$withdrawal_request->isForceDeleting()) {
        ActivityLog::notifyAdmins(auth()->user()->email . ' declined ' . $withdrawal_request->app_user->email . '\'s withdrawal request of ' . to_naira($withdrawal_request->amount));
      }
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
