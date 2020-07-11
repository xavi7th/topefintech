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
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;
use App\Modules\AppUser\Notifications\WithdrawalRequestCreatedNotification;
use App\Modules\AppUser\Notifications\DeclinedWithdrawalRequestNotification;
use App\Modules\AppUser\Notifications\ProcessedWithdrawalRequestNotification;

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
      Route::get('create', [self::class, 'showWithdrawalForm'])->name('appuser.withdraw')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
      Route::get('', [self::class, 'getWithdrawalRequests'])->name('appuser.withdraw.requests')->defaults('extras', ['nav_skip' => true]);
      Route::post('create', [self::class, 'createWithdrawalRequest'])->name('appuser.withdraw.create');
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
    return Inertia::render('withdraw/MakeWithdrawalRequest');
  }

  public function getWithdrawalRequests(Request $request)
  {
    $withdrawal_requests = $request->user()->withdrawal_requests()->withTrashed()->get();
    $statistics = [
      'total_pending' => $request->user()->withdrawal_requests()->where('is_processed', false)->count(),
      'total_processed' => $request->user()->withdrawal_requests()->where('is_processed', true)->count(),
      'total_declined' => $request->user()->withdrawal_requests()->onlyTrashed()->count(),
    ];
    if ($request->isApi()) {
      return response()->json($withdrawal_requests, 200);
    }

    return Inertia::render('withdraw/ViewWithdrawalRequests', compact('withdrawal_requests', 'statistics'));
  }

  public function createWithdrawalRequest(CreateWithdrawalRequestValidation $request)
  {
    // return $request->validated();
    try {
      DB::beginTransaction();
      /**
       * Remove the amount from smart savings current_balane
       */
      $smart_savings = $request->user()->smart_savings;
      $smart_savings->current_balance = ($smart_savings->current_balance - $request->amount);
      $smart_savings->save();

      /**
       * Create a withdrawal request
       */
      $withdrawal_request = $request->user()->withdrawal_request()->create($request->validated());

      /**
       * Notify user that his request was created
       */
      try {
        $request->user()->notify(new WithdrawalRequestCreatedNotification);
      } catch (\Throwable $th) {
        ErrLog::notifyAdmin($request->user(), $th, 'Withdrawal request created notification failed');
      }

      DB::commit();

      if ($request->isApi()) {
        return response()->json($withdrawal_request, 201);
      }
      return back()->withSuccess('Withdrawal request sent. We will update you on the status of your request');
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Withdrawal request NOT created');
      return response()->json(['err' => 'Withdrawal request not created'], 500);
    }
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
