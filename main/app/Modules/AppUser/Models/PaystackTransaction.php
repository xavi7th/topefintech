<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;

class PaystackTransaction extends Model
{
  protected $fillable = ['amount', 'description', 'transaction_reference'];

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  static function getByRef(string $trxrf)
  {
    return self::where('transaction_reference', $trxrf)->first();
  }

  /**
   * This initialises a paystack transaction
   *
   * @param Request $request
   * @param float $amount_in_naira
   * @param string $description
   * @param string $callback_url The url to redirect the user to after payment
   *
   * @return Response A redirect response either to Paystack servers or a back response to where we came from
   */
  static function initializeTransaction(Request $request, float $amount_in_naira, string $description, $callback_url)
  {
    $url = config('services.paystack.initialisation_url');
    $key = config('services.paystack.secret_key');
    $trxrf = unique_random('paystack_transactions', 'transaction_reference', 'TRF-', 21);
    $data = [
      'email' => $request->user()->email,
      'amount' => $amount_in_naira * 100,
      'customer_name' => $request->user()->full_name,
      'reference' => $trxrf,
      'callback_url' => $callback_url,
      'channels' => ['card', 'bank'],
      'metadata' => [
        'userName' => $request->user()->full_name,
        'userPhone' => $request->user()->phone
      ]
    ];

    $response = Http::withToken($key)->post($url, $data);

    if ($response->failed()) {
      logger('Paystack Initialisation Failed for ' . $request->user()->email, ['paystackRsp' => $response->json(), 'requestData' => $request->all(), 'affectedUser' => $request->user()]);
      return back()->withError('An error occured. Try again');
    }

    $paystackRsp = $response->json();

    if ($paystackRsp['status']) {
      $request->user()->paystack_transactions()->create(['transaction_reference' => $trxrf, 'amount' => $amount_in_naira, 'description' => $description]);

      return response('', 409)
        ->header('X-Inertia-Location', $paystackRsp['data']['authorization_url']);
    } else {
      return back()->withError('An unknown error occured');
    }
  }

  /**
   * This verifies a paystack transaction
   *
   * @param string $trxrf
   * @param \App\Modules\AppUser\Models\AppUser $appUser
   * @param bool $returnResponse Specify if the paystack response should be returned
   *
   * @return bool|object
   */
  static function verifyPaystackTransaction(string $trxrf, AppUser $appUser, $returnResponse = false)
  {
    $suspiciousTransaction = false;
    /**
     * Search for a saved transaction of this reference
     * ! If not found and the verification is successful,
     * ! then proceed but note it that this was a request
     * ! that had not been presaved
     */

    $savedTransaction = self::getByRef($trxrf);

    if (!$savedTransaction) {
      $suspiciousTransaction = true;
    }

    $url = config('services.paystack.verification_url') . $trxrf;
    $key = config('services.paystack.secret_key');

    $response = Http::withToken($key)->get($url);

    if ($response->failed()) {
      logger('Paystack Verification Failed for ' . $appUser->email, ['paystackRsp' => $response->json(), 'transactionRef' => $trxrf, 'affectedUser' => $appUser]);
      return false;
    }

    $paystackRsp = $response->json();

    if ($paystackRsp['status']) {

      if ($suspiciousTransaction) {
        logger('Suspicious attempt to verify a non existing transaction with reference: ' . $trxrf, ['paystackRsp' => $response->json(), 'transactionRef' => $trxrf, 'affectedUser' => $appUser]);
        return false;
      } elseif ($savedTransaction->is_processed) {
        logger('Suspicious attempt to reverify transaction with reference: ' . $trxrf, ['paystackRsp' => $response->json(), 'transactionRef' => $trxrf, 'affectedUser' => $appUser]);
        return false;
      } else {
        $savedTransaction->paystack_response = $paystackRsp;
        $savedTransaction->is_processed = true;
        $savedTransaction->save();

        if ($returnResponse) {
          return [
            'status' => true,
            'amount' => $paystackRsp['data']['amount'] / 100,
            'description' => $savedTransaction->description,
            'paystackRsp' => $paystackRsp
          ];
        } else {
          return [
            'status' => true,
            'amount' => $paystackRsp['data']['amount'] / 100,
            'description' => $savedTransaction->description
          ];
        }
      }
    } else {
      return false;
    }
  }
}
