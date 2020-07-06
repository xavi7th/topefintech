<?php

namespace App\Modules\AppUser\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
use App\Modules\AppUser\Models\LoanSurety;
use App\Modules\AppUser\Models\LoanRequest;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\AppUser\Models\PaystackTransaction;
use App\Modules\AppUser\Http\Controllers\LoginController;
use App\Modules\AppUser\Http\Controllers\RegisterController;
use App\Modules\AppUser\Http\Controllers\VerificationController;

class AppUserController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('appuser::app');
  }

  /**
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {
      LoginController::routes();
      RegisterController::routes();
      // ResetPasswordController::routes();
      // ForgotPasswordController::routes();
      // ConfirmPasswordController::routes();
      VerificationController::routes();


      Route::group(['middleware' => ['throttle:20,1', 'auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

        Route::redirect('/', '/user/dashboard', 303);
        Route::get('dashboard', [self::class, 'loadDashboard'])->name('appuser.dashboard')->defaults('extras', ['icon' => 'fas fa-desktop']);

        Route::get('savings/initialise', [self::class, 'initialisePaystackTransaction'])->name('appuser.paystack.initialise')->defaults('extras', ['nav_skip' => true]);
        Route::get('savings/verify', [self::class, 'verifyPaystackTransaction'])->name('appuser.paystack.verify')->defaults('extras', ['nav_skip' => true]);

        Savings::appUserRoutes();

        SavingsInterest::appUserRoutes();

        DebitCard::appUserRoutes();

        WithdrawalRequest::appUserRoutes();

        GOSType::appUserRoutes();

        LoanSurety::appUserRoutes();

        LoanRequest::appUserRoutes();

        Transaction::appUserRoutes();

        AppUser::routes();

        ErrLog::routes();

        // Route::get('messages', [self::class, 'loadUserApp'])->name('appuser.messages')->defaults('extras', ['icon' => 'fas fa-mail-bulk']);
      });
    });
  }

  public function loadDashboard(Request $request)
  {
    return Inertia::render('dashboard/UserDashboard', [
      'total_savings_amount' =>  $request->user()->total_deposit_amount(),
      'total_core_savings_amount' => $request->user()->total_withdrawable_amount(),
      'interest_today' =>  $request->user()->daily_interest(),
      'total_interests_amount' =>  $request->user()->total_interests_amount(),
      'total_uncleared_interests_amount' => $request->user()->savings_interests()->uncleared()->sum('amount'),
      'total_withdrawals_amount' =>  $request->user()->total_withdrawal_amount(),
      'total_loans_amount' => optional($request->user()->active_loan_request)->loan_statistics()->balance_left,
    ]);
  }

  public function initialisePaystackTransaction(Request $request)
  {
    // dd($request->all());
    if (!$request->amount || $request->amount < 100) {
      return generate_422_error('An amount is required and must be greater than ' . to_naira(100));
    }

    if (!$request->description) {
      return generate_422_error('A description was not supplied for this transaction');
    }


    $url = config('services.paystack.initialisation_url');
    $key = config('services.paystack.secret_key');
    $trxrf = unique_random('paystack_transactions', 'transaction_reference', 'TRF-', 21);
    $data = [
      'email' => $request->user()->email,
      'amount' => $request->amount * 100,
      'customer_name' => $request->user()->full_name,
      'reference' => $trxrf,
      'callback_url' => route('appuser.paystack.verify'),
      'channels' => ['card', 'bank'],
      'metadata' => [
        'userName' => $request->user()->full_name,
        'userPhone' => $request->user()->full_name
      ]
    ];

    $response = Http::withToken($key)->post($url, $data);

    if ($response->failed()) {
      logger('Paystack Initialisation Failed for ' . $request->user()->email, ['paystackRsp' => $response->json(), 'requestData' => $request->all(), 'affectedUser' => $request->user()]);
      return back()->withError('An error occured. Try again');
    }

    $paystackRsp = $response->json();

    if ($paystackRsp['status']) {

      $request->user()->paystack_transactions()->create(collect($request->all())->merge(['transaction_reference' => $trxrf])->toArray());

      return response('', 409)
        ->header('X-Inertia-Location', $paystackRsp['data']['authorization_url']);
    } else {
      return back()->withError('An unknown error occured');
    }
  }

  public function verifyPaystackTransaction(Request $request)
  {
    // dd($request->all());
    $suspiciousTransaction = false;
    /**
     * Search for a saved transaction of this reference
     * ! If not found and the verification is successful, then proceed but note it that this was a request that had not been presaved
     */

    $savedTransaction = PaystackTransaction::getByRef($request->trxref);

    if (!$savedTransaction) {
      $suspiciousTransaction = true;
    }

    $url = config('services.paystack.verification_url') . $request->trxref;
    $key = config('services.paystack.secret_key');

    $response = Http::withToken($key)->get($url);

    // dd($response, $response->json());

    if ($response->failed()) {
      logger('Paystack Verification Failed for ' . $request->user()->email, ['paystackRsp' => $response->json(), 'requestData' => $request->all(), 'affectedUser' => $request->user()]);
      // redirect to payment complet page with failure
      return back()->withError('An error occured while trying to verify your transaction. Try again');
    }

    $paystackRsp = $response->json();

    // dd($paystackRsp);

    if ($paystackRsp['status']) {

      if ($suspiciousTransaction) {
        # code...
      } else {
        DB::beginTransaction();
        $savedTransaction->paystack_response = $paystackRsp;
        $savedTransaction->save();

        /**
         * Give the user value
         * !Send a meta data of the type of transaction and then fund as necessary
         */

        $request->user()->distribute_savings(($paystackRsp['data']['amount'] / 100), $savedTransaction->description);


        DB::commit();
        return back()->withSuccess('Complete');
      }
      // return response('', 409)
      //   ->header('X-Inertia-Location', $paystackRsp['data']['authorization_url']);
    } else {
      return back()->withError('An unknown error occured');
    }
  }
}
