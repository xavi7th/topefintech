<?php

namespace App\Modules\Admin\Http\Controllers;

use App\ErrLog;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Models\ApiRoute;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\BasicSite\Models\Message;
use App\Modules\BasicSite\Models\Testimonial;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\Transformers\AdminTestimonialTransformer;
use App\Modules\Admin\Transformers\AdminActivityTransformer;
use App\Modules\Admin\Transformers\AdminTransactionTransformer;
use App\Modules\AppUser\Models\GOSType;
use App\Modules\AppUser\Models\LoanRequest;

class AdminController extends Controller
{
	/**
	 * The admin routes
	 * @return Response
	 */
	public static function routes()
	{
		Route::group(['middleware' => 'api', 'prefix' => 'postman/' . Admin::DASHBOARD_ROUTE_PREFIX, 'namespace' => 'App\\Modules\Admin\Http\Controllers'], function () {
			LoginController::routes();
		});

		/**
		 * ! Change middleware to web
		 */
		Route::group(['middleware' => 'api', 'prefix' => Admin::DASHBOARD_ROUTE_PREFIX, 'namespace' => 'App\\Modules\Admin\Http\Controllers'], function () {
			// LoginController::routes();

			Route::group(['middleware' => ['auth:admin', 'admins']], function () {

				Route::group(['prefix' => 'api'], function () {

					Route::post('test-route-permission', function () {
						$api_route = ApiRoute::where('name', request('route'))->first();
						if ($api_route) {
							if (Auth::admin()->role_id === 2) {
								return ['rsp' => true];
							}
							return ['rsp'  => $api_route->permitted_users()->where('user_id', auth()->id())->exists()];
						} else {
							return response()->json(['rsp' => false], 410);
						}
					});

					Admin::adminRoutes();

					AppUser::adminRoutes();

					GOSType::adminRoutes();

					LoanRequest::adminRoutes();

					Route::get('transactions/withdrawals/summary', function () {
						// $transactions = Transaction::where('trans_type', 'withdrawal')->limit(6)->latest('trans_date')->whereDate('trans_date', '>', now()->subWeek())->get();
						$transactions = WithdrawalRequest::limit(6)->latest()->get();
						return (new AdminTransactionTransformer)->collectionTransformer($transactions, 'transformForAdminViewLatestWithdrawalRequestsSummary');
					});

					Route::post('transaction/create', function () {

						// return request()->all();

						try {
							AppUser::find(request('user_id'))->transactions()->create([
								'amount' => request('amount'),
								'trans_type' => request('trans_type'),
								'investment_plan' => request('investment_plan'),
								'trans_date' => Carbon::parse(request('trans_date')),
							]);
							return response()->json(['rsp' => true], 201);
						} catch (\Throwable $e) {
							Log::error($e);
							return response()->json(['rsp' => false], 500);
						}
					});

					Route::delete('transaction/{transaction_id}/delete', function ($transaction_id) {
						return response()->json(['rsp' => Transaction::destroy($transaction_id)], 204);
					});

					Route::put('transaction/update', function () {

						try {
							Transaction::find(request('id'))->update([
								'amount' => request('amount')
							]);
							return response()->json(['rsp' => true], 205);
						} catch (\Throwable $e) {
							Log::error($e);
							return response()->json(['rsp' => false], 500);
						}
					});


					Route::get('testimonials', function () {
						return (new AdminTestimonialTransformer)->collectionTransformer(Testimonial::all(), 'transformForAdminViewTestimonials');
					});


					Route::post('testimonial/create', function () {

						$url = request()->file('user_img')->store('public/testimonial_images');
						$url = str_replace_first('public', '/storage', $url);

						try {
							$testimonial = Testimonial::create([
								'name' => request('name'),
								'city' => request('city'),
								'country' => request('country'),
								'testimonial' => request('testimonial'),
								'img' => $url
							]);
							return response()->json(['rsp' => $testimonial], 201);
						} catch (\Throwable $e) {
							Log::error($e);
							return response()->json(['rsp' => false], 500);
						}
					});

					Route::delete('testimonial/{testimonial_id}/delete', function ($testimonial_id) {
						return response()->json(['rsp' => Testimonial::destroy($testimonial_id)], 204);
					});

					Route::put('testimonial/update', function () {

						// return request()->all();

						try {
							Testimonial::find(request('id'))->update([
								'amount' => request('amount')
							]);
							return response()->json(['rsp' => true], 205);
						} catch (\Throwable $e) {
							Log::error($e);
							return response()->json(['rsp' => false], 500);
						}
					});

					Route::delete('withdrawal-request/{request_id}/delete', function ($request_id) {
						return response()->json(['rsp' => WithdrawalRequest::destroy($request_id)], 204);
					});

					Route::get('dashboard/statistics', function () {
						return [
							'total_users' => AppUser::count(),
							'total_transactions' => Transaction::where('trans_type', '<>', 'withdrawal')->count(),
							'total_withdrawals' => Transaction::where('trans_type', 'withdrawal')->count(),
							'total_messages' => Message::count(),
						];
					});
				});

				Route::get('/{subcat?}', function () {
					// Auth::logout();
					if (request()->ajax()) {
						return 'Admin dashboadr';
					}
					return view('admin::index');
				})->name('admin.dashboard')->where('subcat', '^((?!(api)).)*');
			});
		});
	}
}
