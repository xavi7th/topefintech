<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Notifications\NewInvestmentInitialised;
use App\Modules\Admin\Http\Requests\CreteInvestmentTypeValidation;
use App\Modules\AppUser\Http\Requests\InitialiseInvestmentSavingsValidation;

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
  }

  static function appUserRoutes()
  {
    Route::post('/investment/create', [self::class, 'initialiseInvestmentsPortfolio'])->name('appuser.savings.investment.initialise');
    // Route::get('available-investment-list', [self::class, 'viewUserInvestments'])->name('appuser.investments')->defaults('extras', ['icon' => 'fas fa-wallet']);
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

  public function initialiseInvestmentsPortfolio(InitialiseInvestmentSavingsValidation $request)
  {
    $funds = $request->user()->investments()->create($request->validated());

    $request->user()->notify(new NewInvestmentInitialised(InvestmentType::find($request->portfolio_id)));

    if ($request->isApi()) return response()->json(['rsp' => $funds], 201);
    return back()->withFlash(['success' => 'Investment portfolio initialised successfully']);
  }

  protected static function boot()
  {
    parent::boot();

    static::saving(function (self $investmentType) {
      $investmentType->daily_interest_rate = $investmentType->interest_rate / now()->addRealMonths($investmentType->duration)->floatDiffInRealDays(now());
    });
  }
}
