<?php

namespace App\Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use App\Modules\AppUser\Models\LoanRequest;
use App\Modules\BasicSite\Models\Testimonial;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Admin\Http\Controllers\LoginController;
use App\Modules\Transformers\AdminTestimonialTransformer;
use App\Modules\Admin\Transformers\AdminTransactionTransformer;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('admin::app');
  }

  public static function apiRoutes()
  {
    Route::group(['middleware' => ['api'], 'prefix' =>  Admin::DASHBOARD_ROUTE_PREFIX . '/api/',  'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {
      Route::group(['middleware' => 'auth:admin_api'], function () {
        ErrLog::apiRoutes();

        Admin::adminApiRoutes();

        AppUser::adminApiRoutes();

        GOSType::adminApiRoutes();

        LoanRequest::adminApiRoutes();

        WithdrawalRequest::adminApiRoutes();

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
      });
    });
  }

  /**
   * The admin routes
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => Admin::DASHBOARD_ROUTE_PREFIX, 'namespace' => 'App\\Modules\Admin\Http\Controllers'], function () {
      LoginController::routes();

      Route::group(['middleware' => ['auth:admin', 'admins']], function () {
        Route::get('/', [AdminController::class, 'loadAdminApp'])->name('admin.home');
      });
    });
  }

  public function loadAdminApp()
  {
    // Auth::logout();
    return Inertia::render('dashboard/AdminDashboard');;
  }
}
