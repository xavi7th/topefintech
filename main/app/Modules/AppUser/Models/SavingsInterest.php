<?php

namespace App\Modules\AppUser\Models;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsInterest extends Model
{
  use SoftDeletes;

  protected $fillable = ['amount', 'savings_id'];

  protected $casts = [
    'is_cleared' => 'boolean',
    'amount' => 'double',
  ];

  protected $appends = ['description'];

  public function savings()
  {
    return $this->belongsTo(Savings::class);
  }

  public function app_user()
  {
    return $this->hasOneThrough(AppUser::class, Savings::class, 'id', 'id', 'savings_id', 'app_user_id');
  }

  public function getDescriptionAttribute(): string
  {
    return str_ordinal($this->created_at->quarter) . ' quarter´s interest on ' . $this->savings->portfolio->name . ' savings';
  }

  static function superAdminRoutes()
  {
    Route::name('superadmin.')->prefix('savings-interests')->group(function () {
      Route::get('{appUser}/', [self::class, 'adminGetSavingsInterests'])->name('user.interest')->defaults('extras', ['nav_skip' => true]);
      Route::get('{appUser}/{month}', [self::class, 'adminGetSavingsInterestsForMonth'])->name('user.interest.details')->defaults('extras', ['nav_skip' => true]);
    });
  }

  static function adminRoutes()
  {
    Route::group(['prefix' => 'savings-interests'], function () {
      Route::get('{appUser}/', [self::class, 'adminGetSavingsInterests'])->name('admin.user.interest')->defaults('extras', ['nav_skip' => true]);
      Route::get('{appUser}/{month}', [self::class, 'adminGetSavingsInterestsForMonth'])->name('admin.user.interest.details')->defaults('extras', ['nav_skip' => true]);
    });
  }

  static function appUserRoutes()
  {
    Route::group(['prefix' => 'savings-interests'], function () {
      Route::get('', [self::class, 'getSavingsInterests'])->name('appuser.interest')->defaults('extras', ['icon' => 'fas fa-money-check-alt']);
      Route::get('{month}', [self::class, 'getSavingsInterestsForMonth'])->name('appuser.interest.details')->defaults('extras', ['nav_skip' => true]);
    });
  }

  public function getSavingsInterests(Request $request)
  {

    $interests_summary = $request->user()->getSavingsInterestsSummary();

    if ($request->isApi())  return response()->json($interests_summary, 200);
    return Inertia::render('AppUser,savings/ViewInterests', compact('interests_summary'));
  }

  public function getSavingsInterestsForMonth(Request $request, $month)
  {
    return Inertia::render('AppUser,savings/ViewInterestBreakdown', [
      'interests_summary' => $request->user()->getSavingsInterestsForMonth($month),
      'month' => $month
    ]);
  }

  public function adminGetSavingsInterests(Request $request, AppUser $appUser)
  {
    $interests_summary = $appUser->getSavingsInterestsSummary();


    if ($request->isApi()) return response()->json($interests_summary, 200);
    if ($request->user()->isSuperAdmin()) return Inertia::render('SuperAdmin,savings/ViewUserInterests', [
      'interests_summary' => $interests_summary,
      'user' => $appUser
    ]);
    if ($request->user()->isAdmin()) return Inertia::render('Admin,savings/ViewUserInterests', [
      'interests_summary' => $interests_summary,
      'user' => $appUser
    ]);

  }

  public function adminGetSavingsInterestsForMonth(Request $request, AppUser $appUser, $month)
  {
    if ($request->user()->isSuperAdmin())   return Inertia::render('SuperAdmin,savings/ViewUserInterestBreakdown', [
      'interests_summary' => $appUser->getSavingsInterestsForMonth($month),
      'month' => $month,
      'user' => $appUser->full_name
    ]);
    if ($request->user()->isAdmin())   return Inertia::render('Admin,savings/ViewUserInterestBreakdown', [
      'interests_summary' => $appUser->getSavingsInterestsForMonth($month),
      'month' => $month,
      'user' => $appUser->full_name
    ]);
  }

  /**
   * Scope a query to only certain parameters
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeUnprocessed($query)
  {
    return $query->where('processed_at', null);
  }
  public function scopeProcessed($query)
  {
    return $query->where('processed_at', '<>', null);
  }

  public function scopeWithdrawn($query)
  {
    return $query->where('process_type', 'withdrawn');
  }

  public function scopeCompounded($query)
  {
    return $query->where('process_type', 'compounded');
  }

  public function scopeLiquidated($query)
  {
    return $query->where('process_type', 'liquidated');
  }

  public function scopeUnlocked($query)
  {
    return $query->where('is_locked', false);
  }

  public function scopeLocked($query)
  {
    return $query->where('is_locked', true);
  }
}
