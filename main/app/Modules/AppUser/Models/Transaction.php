<?php

namespace App\Modules\AppUser\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\AppUser\Models\Transaction
 *
 * @property int $id
 * @property int $savings_id
 * @property string $trans_type
 * @property float $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $interest_processed_at
 * @property int $yields_interests
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction deposits()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction interestable()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereInterestProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereYieldsInterests($value)
 * @method static \Illuminate\Database\Query\Builder|Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction withdrawals()
 * @method static \Illuminate\Database\Query\Builder|Transaction withoutTrashed()
 * @mixin \Eloquent
 */
class Transaction extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'amount', 'trans_type', 'savings_id', 'description'
  ];
  protected $dates = ['trans_date', 'interest_processed_at'];

  protected $casts = [
    'amount' => 'double',
  ];

  public function savings()
  {
    return $this->belongsTo(Savings::class);
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'transactions'], function () {
      Route::get('', 'Transaction@getTransactions');
      Route::get('{month}', 'Transaction@getTransactionsForMonth');
    });
  }

  public function getTransactions(Request $request)
  {
    return $records = $request->user()->transactions()->with('savings.portfolio')->addSelect(DB::raw('*, MONTHNAME(transactions.created_at) as month'))->get();

    $transactions_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });
    return response()->json($transactions_summary, 200);
  }

  public function getTransactionsForMonth(Request $request, $month)
  {
    return $records = $request->user()->transactions()->with('savings.portfolio')
      ->whereMonth('transactions.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $transactions_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
        return $item->sum('amount');
      });
    })->transform(function ($item) {
      return collect($item->all())->merge(['total' => $item->sum()]);
    });;

    return response()->json($transactions_summary, 200);
  }

  /**
   * Scope a query to only deposit transactions
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeDeposits($query)
  {
    return $query->where('trans_type', 'deposit');
  }

  /**
   * Scope a query to only withdrawals
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeWithdrawals($query)
  {
    return $query->where('trans_type', 'withdrawal');
  }

  public function scopeInterestable($query)
  {
    return $query->whereDate('interest_processed_at', '<', now())
      ->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')))
      ->where('yields_interests', true);
  }
}
