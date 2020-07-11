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
   * Scope a query to only uncleared interests
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeUncleared($query)
  {
    return $query->where('is_cleared', false);
  }

  /**
   * Scope a query to only uncleared interests
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeCleared($query)
  {
    return $query->where('is_cleared', true);
  }
}
