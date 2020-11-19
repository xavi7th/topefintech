<?php

namespace App\Modules\AppUser\Models;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\AppUser\Models\SavingsInterest
 *
 * @property int $id
 * @property int $savings_id
 * @property float $amount
 * @property string|null $description
 * @property string|null $processed_at
 * @property string|null $process_type
 * @property int $is_locked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest compounded()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest liquidated()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest locked()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest newQuery()
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest processed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest unlocked()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest unprocessed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereProcessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SavingsInterest withdrawn()
 * @method static \Illuminate\Database\Query\Builder|SavingsInterest withoutTrashed()
 * @mixin \Eloquent
 */
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

  public function getDescriptionAttribute()
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
    $records = $request->user()->savings_interests()->with('savings.portfolio')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();

    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    } else {
      return Inertia::render('AppUser,savings/ViewInterests', [
        'interests_summary' => $interests_summary
      ]);
    }
  }

  public function getSavingsInterestsForMonth(Request $request, $month)
  {
    $records = $request->user()->savings_interests()->with('savings.portfolio')
      ->whereMonth('savings_interests.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $interests_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toDateString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
        return $item->sum('amount');
      });
    })->transform(function ($item) {
      return collect($item->all())->merge(['total' => $item->sum()]);
    });;

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    }

    return Inertia::render('AppUser,savings/ViewInterestBreakdown', [
      'interests_summary' => $interests_summary,
      'month' => $month
    ]);
  }

  public function adminGetSavingsInterests(Request $request, AppUser $appUser)
  {
    $records = $appUser->savings_interests()->with('savings.portfolio')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();
    // dd($appUser);
    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    } else {
      return Inertia::render('AppUser,savings/ViewUserInterests', [
        'interests_summary' => $interests_summary,
        'user' => $appUser
      ]);
    }
  }

  public function adminGetSavingsInterestsForMonth(Request $request, AppUser $appUser, $month)
  {
    $records = $appUser->savings_interests()->with('savings.portfolio')
      ->whereMonth('savings_interests.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $interests_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toDateString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
        return $item->sum('amount');
      });
    })->transform(function ($item) {
      return collect($item->all())->merge(['total' => $item->sum()]);
    });;

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    }

    return Inertia::render('AppUser,savings/ViewUserInterestBreakdown', [
      'interests_summary' => $interests_summary,
      'month' => $month,
      'user' => $appUser
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
