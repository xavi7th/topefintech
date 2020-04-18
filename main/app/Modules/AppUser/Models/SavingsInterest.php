<?php

namespace App\Modules\AppUser\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
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

	public function savings()
	{
		return $this->belongsTo(Savings::class);
	}

	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'savings-interests'], function () {
			Route::get('', 'SavingsInterest@getSavingsInterests');
			Route::get('{month}', 'SavingsInterest@getSavingsInterestsForMonth');
		});
	}

	public function getSavingsInterests(Request $request)
	{
		$records = $request->user()->savings_interests()->with('savings.gos_type')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();

		$interests_summary =  transform($records, function ($value) {
			return $value->groupBy('month')->transform(function ($item, $key) {
				return $item->groupBy('savings.gos_type.name')->transform(function ($item, $key) {
					return $item->sum('amount');
				});
			})->transform(function ($item) {
				return collect($item->all())->merge(['total' => $item->sum()]);
			});
		});
		return response()->json($interests_summary, 200);
	}

	public function getSavingsInterestsForMonth(Request $request, $month)
	{
		$records = $request->user()->savings_interests()->with('savings.gos_type')
			->whereMonth('savings_interests.created_at', Carbon::parse($month)->month)->orderByDesc('created_at')->get();

		$interests_summary = $records->groupBy([
			function ($item) {
				return $item->created_at->toString();
			},
		])->transform(function ($item, $key) {
			return $item->groupBy('savings.gos_type.name')->transform(function ($item, $key) {
				return $item->sum('amount');
			});
		})->transform(function ($item) {
			return collect($item->all())->merge(['total' => $item->sum()]);
		});;

		return response()->json($interests_summary, 200);
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
