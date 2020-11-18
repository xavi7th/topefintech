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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use App\Modules\Admin\Transformers\AdminWithdrawalRequestTransformer;
use App\Modules\AppUser\Notifications\SendAccountVerificationMessage;
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;
use App\Modules\AppUser\Notifications\WithdrawalRequestCreatedNotification;
use App\Modules\AppUser\Notifications\DeclinedWithdrawalRequestNotification;
use App\Modules\AppUser\Notifications\ProcessedWithdrawalRequestNotification;
use App\Modules\AppUser\Http\Requests\CreateInterestsWithdrawalRequestValidation;

class WithdrawalRequest extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'app_user_id', 'description', 'amount', 'payout_amount', 'is_charge_free', 'savings_id', 'is_interests'
  ];

  protected $casts = [
    'is_processed' => 'boolean',
    'is_charge_free' => 'boolean',
    'is_user_verified' => 'boolean',
    'is_interests' => 'boolean',
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

  public function processSavingsWithdrawal(self $withdrawalRequest): void
  {

    $savingsPortfolio = $withdrawalRequest->savingsPortfolio;

    /**
     * on approval add a withdrawal transaction to clear the savings protfolio
     */
    $desc = $withdrawalRequest->description ?? ($withdrawalRequest->is_charge_free ? 'Withdrawal from ' . $savingsPortfolio->type . ' savings balance' : 'Charge-deductible withdrawal from ' . $savingsPortfolio->type . ' savings balance');
    $savingsPortfolio->create_withdrawal_transaction($withdrawalRequest->amount, $desc);

    if (!$withdrawalRequest->is_charge_free) {
      /**
       * Get deductible percentage of withdrawal request amount
       */
      $withdrawalCharge = $savingsPortfolio->getServiceCharge();

      /**
       * Create a service charge transaction for this savings for the withdrawal if it is a chargeable withdrawal
       */
      $savingsPortfolio->create_service_charge($withdrawalCharge, 'Amount deducted for as withdrawal charge for charge deductible withdrawal on ' . $withdrawalRequest->description ?? ($savingsPortfolio->portfolio->name . ' savings portfolio'));
    }

    /**
     * Mark the request as processed
     */
    $withdrawalRequest->is_processed = true;
    $withdrawalRequest->processed_by = request()->user()->id;
    $withdrawalRequest->processor_type = get_class(request()->user());
    $withdrawalRequest->save();

    /**
     * Mark the savings as withdrawn
     */
    $savingsPortfolio->withdrawn_at = now();
    $savingsPortfolio->save();
  }

  public function processSavingsInterestsWithdrawal(self $withdrawalRequest): void
  {

    $savingsPortfolio = $withdrawalRequest->savingsPortfolio;

    /**
     * on approval add a withdrawal transaction to clear the savings protfolio
     */
    $desc = $withdrawalRequest->is_charge_free ? 'Withdrawal of interests accrued on ' . $savingsPortfolio->portfolio->name . ' savings' : 'Charge-deductible withdrawal of interests accrued on ' . $savingsPortfolio->portfolio->name . ' savings';
    $savingsPortfolio->create_withdrawal_transaction($withdrawalRequest->amount, $desc);

    if (!$withdrawalRequest->is_charge_free) {
      /**
       * Get deductible percentage of withdrawal request amount
       */
      $withdrawalCharge = $withdrawalRequest->amount * (config('app.undue_withdrawal_charge_percentage') / 100);

      /**
       * Create a service charge transaction for this savings for the withdrawal if it is a chargeable withdrawal
       */
      $savingsPortfolio->create_service_charge($withdrawalCharge, 'Amount deducted for as withdrawal charge for charge deductible withdrawal on ' . $savingsPortfolio->portfolio->name . ' savings accrued interests');
    }

    /**
     * Mark the request as processed
     */
    $withdrawalRequest->is_processed = true;
    $withdrawalRequest->processed_by = request()->user()->id;
    $withdrawalRequest->processor_type = get_class(request()->user());
    $withdrawalRequest->save();

    /**
     * Mark the savings interests as withdrawn
     */
    $savingsPortfolio->savings_interests()->unlocked()->unprocessed()->update([
      'processed_at' => now(),
      'process_type' => 'withdrawn'
    ]);
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'withdrawal-requests'], function () {
      Route::get('', [self::class, 'getWithdrawalRequests'])->name('appuser.withdraw.requests')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
      // Route::get('create', [self::class, 'showWithdrawalForm'])->name('appuser.withdraw')->defaults('extras', ['nav_skip' => true]);
      Route::post('{savings}/create', [self::class, 'createWithdrawalRequest'])->name('appuser.withdraw.create');
      Route::post('verify', [self::class, 'verifyWithdrawalRequest'])->name('appuser.withdraw.verify');
      Route::post('{savings}/interests/create', [self::class, 'createInterestsWithdrawalRequest'])->name('appuser.withdraw_interests.create');
      Route::post('interests/verify', [self::class, 'verifyInterestsWithdrawalRequest'])->name('appuser.withdraw_interests.verify');
    });
  }

  static function adminRoutes()
  {
    Route::prefix('withdrawal-requests')->name('admin.')->group(function () {
      Route::get('', [self::class, 'adminGetWithdrawalRequests'])->name('withdrawal_requests')->defaults('extras', ['icon' => 'fa fa-x-ray']);
      Route::post('/{withdrawalRequest}/mark-complete', [self::class, 'approveWithdrawalRequest'])->name('withdrawal_request.mark_complete');
      Route::delete('/{withdrawalRequestId}/cancel', [self::class, 'cancelWithdrawalRequest'])->name('withdrawal_request.delete');
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

    DB::transaction(function () use ($withdrawalRequest, $request) {
      $withdrawalRequest->is_user_verified = true;
      $withdrawalRequest->save();

      DB::table('password_resets')->where('token', $request->otp)->delete();
    });


    try {
      $user->notify(new WithdrawalRequestCreatedNotification($withdrawalRequest->amount));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($user, $th, 'Withdrawal request created notification failed');
    }

    if ($request->isApi()) return response()->json($withdrawalRequest, 201);
    return back()->withFlash(['success' => 'Withdrawal request verified. We will update you on the status of your request', 'verifiation_succeded' => true]);
  }

  public function createInterestsWithdrawalRequest(CreateInterestsWithdrawalRequestValidation $request, Savings $savings)
  {
    try {
      if (!$request->user()->hasUnverifiedWithdrawalRequest()) {
        DB::beginTransaction();

        /**
         * Create a withdrawal request
         */
        $withdrawal_request = $request->user()->withdrawal_request()->create($request->validated());

        $token = $request->user()->createVerificationToken();
        $request->user()->notify((new SendAccountVerificationMessage('sms', $token, 'A withdrawal request was initialised on your account for the accrued interests on your ' . $savings->type . ' savings. Use this OTP: ' . $token . 'to verify the request to enable us proceed.'))->onQueue('high'));

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

  public function verifyInterestsWithdrawalRequest(Request $request)
  {

    $tokenRecord = DB::table('password_resets')->where('token', $request->otp)->first();
    if (!$tokenRecord) throw ValidationException::withMessages(['err' => 'Invalid token!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    /**
     * @var AppUser $user
     */
    $user = AppUser::where('phone', $tokenRecord->phone)->firstOr(function () {
      throw ValidationException::withMessages(['err' => 'Invalid or stale request. Contact Support for assistance!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    if (!$user->is($request->user())) throw ValidationException::withMessages(['err' => 'Request not permitted! Contact our support team for more information.'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $withdrawalRequest = $user->pendingWithdrawalRequest;
    if (!$withdrawalRequest) throw ValidationException::withMessages(['err' => 'You currently have no pending withdrawal requests.'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    DB::transaction(function () use ($withdrawalRequest, $request) {
      $withdrawalRequest->is_user_verified = true;
      $withdrawalRequest->save();

      DB::table('password_resets')->where('token', $request->otp)->delete();
    });


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

  public function cancelWithdrawalRequest(Request $request, $withdrawalRequestId)
  {

    $withdrawalRequest = WithdrawalRequest::withTrashed()->find($withdrawalRequestId);

    if ($withdrawalRequest->trashed()) {
      $withdrawalRequest->forceDelete();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success' => 'Withdrawal request purged from the records']);
    } else {
      DB::beginTransaction();
      /**
       * Notify user that his request was declined
       */
      try {
        $withdrawalRequest->app_user->notify(new DeclinedWithdrawalRequestNotification($withdrawalRequest));
      } catch (\Throwable $th) {
        ErrLog::notifyAdmin($withdrawalRequest->app_user, $th, 'Declined withdrawal notification failed');
        if ($request->isApi()) return response()->json('Declined withdrawal notification failed', 500);
        return back()->withFlash(['error' => 'Withdrawal Request NOT DELETED! <br> We could not send the user a notfication and the actions was canceled. Check the logs for more details']);
      }

      /**
       * Delete the request;
       */
      $withdrawalRequest->delete();

      DB::commit();
      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success' => 'Withdrawal request deleted. The user has been notified']);
    }
  }

  public function approveWithdrawalRequest(Request $request, self $withdrawalRequest)
  {
    if ($withdrawalRequest->is_processed) {
      ActivityLog::notifyAdmins($request->user()->email . ' attempted to approve an already processed request: ' . $withdrawalRequest->id);
      throw ValidationException::withMessages(['err' => 'This request has been processed already!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    if (!$withdrawalRequest->is_user_verified) {
      ActivityLog::notifyAdmins($request->user()->email . ' attempted to approve a request that has not been verified by the user: ' . $withdrawalRequest->id);
      throw ValidationException::withMessages(['err' => 'Invalid action!'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    DB::beginTransaction();

    $withdrawalRequest->is_interests ? $this->processSavingsInterestsWithdrawal($withdrawalRequest) : $this->processSavingsWithdrawal($withdrawalRequest);

    /**
     * Notify user that his request has been processed
     */
    try {
      $appUser = $withdrawalRequest->app_user;
      $appUser->notify(new ProcessedWithdrawalRequestNotification($withdrawalRequest));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($appUser, $th, 'We could not send a notification of transaction processed to ' . $appUser->full_name);
    }

    DB::commit();

    if ($request->isApi()) return response()->json('Withdrawal request marked as processed', 204);
    return back()->withFlash(['success' => 'Withdrawal request marked as processed']);
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
      Cache::forget('withdrawalRequests');
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
