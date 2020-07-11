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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\Savings $savings
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction deposit()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereInterestProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Transaction withdrawals()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Transaction withoutTrashed()
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
    return $records = $request->user()->transactions()->with('savings.target_type')->addSelect(DB::raw('*, MONTHNAME(transactions.created_at) as month'))->get();

    $transactions_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
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
    return $records = $request->user()->transactions()->with('savings.target_type')
      ->whereMonth('transactions.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

    $transactions_summary = $records->groupBy([
      function ($item) {
        return $item->created_at->toString();
      },
    ])->transform(function ($item, $key) {
      return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
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
  public function scopeDeposit($query)
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
}
