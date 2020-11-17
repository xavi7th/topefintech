<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\TargetType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Models\PaystackTransaction;
use App\Modules\AppUser\Notifications\NewSavingsSuccess;
use App\Modules\Admin\Transformers\AdminSavingsTransformer;
use App\Modules\AppUser\Notifications\SmartSavingsInitialised;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;
use App\Modules\Admin\Http\Requests\CreteInvestmentTypeValidation;
use App\Modules\AppUser\Http\Requests\InitialiseSmartSavingsValidation;

class InvestmentType extends Model
{
  use SoftDeletes;

  protected $fillable = ['name', 'interest_rate', 'daily_interest_rate', 'duration'];
  protected $dates = ['funded_at', 'maturity_date', 'withdrawn_at', 'interests_unlocked_at'];
  protected $casts = [
    'current_balance' => 'double',
    'app_user_id' => 'int',
    'portfolio_id' => 'int',
    'is_liquidated' => 'boolean',
    'interests_withdrawable' => 'boolean',
  ];

  public function savings()
  {
    return $this->morphMany(Savings::class, 'portfolio');
  }

  static function adminRoutes()
  {
    Route::name('admin.')->prefix('investment-types')->group(function () {
      Route::get('', [self::class, 'adminGetInvestmentTypes'])->name('manage_investment_plans')->defaults('extras', ['icon' => 'far fa-save']);
      Route::post('create', [self::class, 'adminCreateInvestmentType'])->name('investment_plan.create');
      Route::put('{investmentType}/update', [self::class, 'adminUpdateInvestmentType'])->name('investment_plan.update');
      Route::delete('{investmentType}/delete', [self::class, 'adminDeleteInvestmentType'])->name('investment_plan.delete');
    });

    Route::get('{user}/investments', [self::class, 'adminViewUserInvestments'])->name('admin.user_investments')->defaults('extras', ['nav_skip' => true]);
    // Route::post('{appUser}/investments/{investment}/fund', [self::class, 'lockMoreUserFunds'])->name('admin.user_investments.fund');
    // Route::post('{appUser}/investments/{investment}/defund', [self::class, 'deductUserFunds'])->name('admin.user_investments.defund');
    // Route::get('notifications/matured-investments', [self::class, 'getMaturedSavingsNotifications'])->name('admin.view_matured_investments')->defaults('extras', ['icon' => 'fas fa-clipboard-list']);
  }

  static function appUserRoutes()
  {
    Route::get('investments', [self::class, 'viewUserInvestments'])->name('appuser.investments')->defaults('extras', ['icon' => 'fas fa-wallet']);
    // Route::post('/savings/auto-save/create', [self::class, 'setAutoSaveSettings'])->name('appuser.savings.create-autosave');
    // Route::delete('/savings/auto-save/{autoSaveSetting}', [self::class, 'deleteAutoSaveSettings'])->name('appuser.savings.delete-autosave');
    // Route::post('/savings/target-funds/add', [self::class, 'lockMoreFunds'])->name('appuser.savings.target.fund');
    // Route::get('/savings/{savings}/target-funds/add', [self::class, 'verifyLockMoreFunds'])->name('appuser.savings.target.fund.verify')->defaults('extras', ['nav_skip' => true]);
    Route::post('/interests/create', [self::class, 'initialiseInvestmentsPortfolio'])->name('appuser.investments.initialise');
  }

  public function adminGetInvestmentTypes(Request $request)
  {
    if ($request->isApi()) return InvestmentType::all();

    return Inertia::render('Admin,ManageInvestmentPlans', [
      'investment_list' => function () {
        return InvestmentType::withCount('savings')->get();
      }
    ]);
  }

  public function adminCreateInvestmentType(CreteInvestmentTypeValidation $request)
  {
    try {
      $investment_type = InvestmentType::create($request->validated());

      if ($request->isApi()) return response()->json($investment_type, 201);
      return back()->withFlash(['success' => 'Investment Plan created']);
    } catch (\Throwable $e) {
      ErrLog::notifyAdmin($request->user(), $e, 'Investment not created');

      if ($request->isApi())  return response()->json(['rsp' => $e->getMessage()], 500);
      return back()->withFlash(['error' => 'Investment not created. Check error logs']);
    }
  }

  public function adminUpdateInvestmentType(CreteInvestmentTypeValidation $request, self $investmentType)
  {
    try {
      $investmentType->interest_rate = $request->interest_rate;
      $investmentType->save();

      if ($request->isApi()) return response()->json($investmentType, 201);
      return back()->withFlash(['success' => 'Investment Plan updated']);
    } catch (\Throwable $e) {
      ErrLog::notifyAdmin($request->user(), $e, 'Investment not updated');

      if ($request->isApi())  return response()->json(['rsp' => $e->getMessage()], 500);
      return back()->withFlash(['error' => 'Investment not updated. Check error logs']);
    }
  }


  public function adminDeleteInvestmentType(Request $request, self $investmentType)
  {
    if ($investmentType->savings()->exists()) {
      if ($request->isApi())  return response()->json('Investment Plan has active savings and cannot be deleted', 403);
      return back()->withFlash(['error' => 'Investment Plan has active savings and cannot be deleted']);
    }

    $investmentType->forceDelete();

    if ($request->isApi())  return response()->json([], 204);
    return back()->withFlash(['success' => 'Investment Plan deleted']);
  }


  public function getInvestmentTypes(Request $request)
  {
    return InvestmentType::all();
  }

  public function viewUserInvestments(Request $request)
  {
    if ($request->isApi()) return $request->user()->savings_list;
    return Inertia::render('AppUser,savings/UserSavings', [
      'savings_list' => $request->user()->savings_list()->active()->with('portfolio')->get(),
      'auto_save_list' => $request->user()->auto_save_settings,
      'investment_types' => TargetType::all()
    ]);
  }

  public function lockMoreFunds(Request $request)
  {
    if (!$request->savings_id) {
      return generate_422_error('Invalid savings selected');
    }
    if (!$request->amount || $request->amount <= 0) {
      return generate_422_error('You need to specify an amount to add to this savings');
    }

    $savings = self::find($request->savings_id);

    if (is_null($savings)) {
      return generate_422_error('Invalid savings selected');
    }

    return PaystackTransaction::initializeTransaction($request, $request->amount, 'Fund ' . $savings->type . ' savings', route('appuser.savings.target.fund.verify', $savings->id));
  }

  public function verifyLockMoreFunds(Request $request, self $savings)
  {
    if (!($rsp = PaystackTransaction::verifyPaystackTransaction($request->trxref, $request->user()))) {
      return back()->withFlash(['error' => 'An error occured']);
    } else {

      try {

        if ($savings->type == 'smart') {
          $request->user()->fund_smart_savings($rsp['amount']);
        } else {
          $request->user()->fund_target_savings($savings, $rsp['amount']);
        }

        $request->user()->notify(new NewSavingsSuccess($rsp['amount']));

        if ($request->isApi()) {
          return response()->json(['rsp' => 'Created'], 201);
        } else {
          return back()->withFlash(['success' => 'Congrats! Funds added to savings']);
        }
      } catch (\Throwable $th) {
        if ($th->getCode() == 422) {
          return generate_422_error($th->getMessage());
        } else {
          ErrLog::notifyAdmin(auth()->user(), $th, 'Add more funds to savings failed');
        }
      };
    }
  }

  public function initialiseInvestmentsPortfolio(InitialiseSmartSavingsValidation $request)
  {
    $funds = $request->user()->smart_savings()->create($request->validated());

    /**
     * Notify the user that a smart savings account prifile was initialised for him. He can start saving right away
     */
    $request->user()->notify(new SmartSavingsInitialised($request->user()));

    if ($request->isApi()) return response()->json(['rsp' => $funds], 201);
    return back()->withFlash(['success' => 'Smart savings portfolio initialised successfully']);
  }

  public function adminViewUserInvestments(Request $request, AppUser $user)
  {
    $savings_list = (new AdminSavingsTransformer)->collectionTransformer($user->savings_list->load('portfolio'), 'basic');
    // $savings_list = $user->savings_list->load('portfolio');
    $auto_save_list = $user->auto_save_settings;
    // $target_types = TargetType::all();

    return Inertia::render('Admin,savings/ManageUserSavings', compact('user', 'savings_list', 'auto_save_list'));
  }

  public function getMaturedSavingsNotifications(Request $request)
  {
    $notifications = Admin::find(1)->unreadNotifications()->whereType(SavingsMaturedNotification::class)->get();

    if ($request->isApi()) return $notifications;
    return Inertia::render('Admin,AdminNotifications', [
      'notifications' => $notifications
    ]);
  }

  protected static function boot()
  {
    parent::boot();

    static::saving(function (self $investmentType) {
      $investmentType->daily_interest_rate = $investmentType->interest_rate / now()->addRealMonths($investmentType->duration)->floatDiffInRealDays(now());
    });
  }
}
