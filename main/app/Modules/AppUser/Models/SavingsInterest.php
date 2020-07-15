<?php

namespace App\Modules\AppUser\Models;

use App\User;
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
 * @property bool $is_cleared
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest cleared()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest uncleared()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereIsCleared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\SavingsInterest withoutTrashed()
 * @mixin \Eloquent
 * @property int $is_withdrawn
 * @property int $is_compounded
 * @property int $is_locked
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest compounded()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest locked()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest notCompounded()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest notLocked()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest notWithdrawn()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereIsCompounded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereIsWithdrawn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest withdrawn()
 * @property int|null $processed_at
 * @property string|null $process_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest liquidated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest processed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest unprocessed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereProcessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\SavingsInterest unlocked()
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

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (User::hasRouteNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (User::hasRouteNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    }
  }

  public function savings()
  {
    return $this->belongsTo(Savings::class);
  }

  public function getDescriptionAttribute()
  {
    return str_ordinal($this->created_at->quarter) . ' quarter´s interest on ' . $this->savings->target_type->name . ' savings';
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
    $records = $request->user()->savings_interests()->with('savings.target_type')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();

    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    } else {
      return Inertia::render('savings/ViewInterests', [
        'interests_summary' => $interests_summary
      ]);
    }
  }

  public function getSavingsInterestsForMonth(Request $request, $month)
  {
    $records = $request->user()->savings_interests()->with('savings.target_type')
      ->whereMonth('savings_interests.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $interests_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toDateString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
        return $item->sum('amount');
      });
    })->transform(function ($item) {
      return collect($item->all())->merge(['total' => $item->sum()]);
    });;

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    }

    return Inertia::render('savings/ViewInterestBreakdown', [
      'interests_summary' => $interests_summary,
      'month' => $month
    ]);
  }

  public function adminGetSavingsInterests(Request $request, AppUser $appUser)
  {
    $records = $appUser->savings_interests()->with('savings.target_type')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();
    // dd($appUser);
    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    } else {
      return Inertia::render('savings/ViewUserInterests', [
        'interests_summary' => $interests_summary,
        'user' => $appUser
      ]);
    }
  }

  public function adminGetSavingsInterestsForMonth(Request $request, AppUser $appUser, $month)
  {
    $records = $appUser->savings_interests()->with('savings.target_type')
      ->whereMonth('savings_interests.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $interests_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toDateString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
        return $item->sum('amount');
      });
    })->transform(function ($item) {
      return collect($item->all())->merge(['total' => $item->sum()]);
    });;

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    }

    return Inertia::render('savings/ViewUserInterestBreakdown', [
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
