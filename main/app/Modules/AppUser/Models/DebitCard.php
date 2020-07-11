<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Models\PaystackTransaction;
use App\Modules\AppUser\Transformers\DebitCardTransformer;
use App\Modules\AppUser\Http\Requests\AddNewDebitCardValidation;

/**
 * App\Modules\AppUser\Models\DebitCard
 *
 * @property int $id
 * @property int $app_user_id
 * @property string|null $brand
 * @property string|null $sub_brand
 * @property string|null $country
 * @property string|null $card_type
 * @property string|null $bank
 * @property string $pan
 * @property string $pan_hash
 * @property string|null $month
 * @property string|null $year
 * @property string|null $cvv
 * @property string|null $cvv_hash
 * @property bool $is_default
 * @property int $is_authorised
 * @property string|null $authorization_code
 * @property object|null $authorization_object
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read mixed $xed_pan
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereAuthorizationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereAuthorizationObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvvHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereIsAuthorised($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePanHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereSubBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereYear($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\DebitCard withoutTrashed()
 * @mixin \Eloquent
 */
class DebitCard extends Model
{
  use SoftDeletes;

  protected $fillable = [
    'pan', 'month', 'year', 'cvv', 'brand', 'sub_brand', 'country', 'card_type', 'bank',
  ];

  protected $casts = [
    'is_default' => 'boolean',
    'is_authorised' => 'boolean',
    'app_user_id' => 'integer',
    'authorization_object' => 'object'
  ];

  protected $hidden = ['cvv_hash', 'pan_hash'];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    Inertia::setRootView('appuser::app');
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function belongs_to(AppUser $user): bool
  {
    return $this->app_user_id === $user->id;
  }

  public function is_default_card(): bool
  {
    return $this->is_default;
  }

  public function perform_recurrent_debit(float $amount): bool
  {
    $url = config('services.paystack.charge_authorization_url');
    $key = config('services.paystack.secret_key');
    $trxrf = unique_random('paystack_transactions', 'transaction_reference', 'AUT-', 26);
    $data = [
      "authorization_code" => $this->authorization_code,
      "email" => $this->app_user->email,
      "amount" => $amount * 100,
      'reference' => $trxrf,
      'customer_name' => $this->app_user->full_name,
      'metadata' => [
        'userName' => $this->app_user->full_name,
        'userPhone' => $this->app_user->phone
      ]
    ];

    $response = Http::withToken($key)->post($url, $data);

    if ($response->failed()) {
      logger('Paystack Auto Debit Failed for ' . $this->app_user->email, ['paystackRsp' => $response->json(), 'amount' => $amount, 'affectedUser' => $this->app_user]);
      return false;
    }

    $paystackRsp = $response->json();
    dump($paystackRsp);
    dump($this->app_user->id);

    if ($paystackRsp['status']) {
      // Model::unguard();
      // $this->app_user->paystack_transactions()->create(['transaction_reference' => $paystackRsp['data'][ 'reference'], 'amount' => $amount, 'description' => 'Autosave deduction', 'paystack_response' => $paystackRsp, 'is_processed' => true]);
      // Model::reguard();


      $paystackTrx = new PaystackTransaction;
      $paystackTrx->app_user_id = $this->app_user->id;
      $paystackTrx->transaction_reference = $paystackRsp['data']['reference'];
      $paystackTrx->amount = $amount;
      $paystackTrx->description = 'Autosave deduction';
      $paystackTrx->paystack_response = json_encode($paystackRsp);
      $paystackTrx->is_processed = true;
      $paystackTrx->save();

      return true;
    } else {
      return false;
    }
  }

  public function setMonthAttribute($value)
  {
    $this->attributes['month'] = str_pad($value, 2, "0", STR_PAD_LEFT);
  }

  public function setPanAttribute($value)
  {
    $this->attributes['pan'] = encrypt($value);
    $this->attributes['pan_hash'] = bcrypt($value);
  }

  public function getPanAttribute($value)
  {
    return 'ending in ' . substr(decrypt($this->attributes['pan']), -4);
  }

  public function getXedPanAttribute($value)
  {
    return 'XXXX XXXX XXXX ' . substr(decrypt($this->attributes['pan']), -4);
  }

  public function setCvvAttribute($value)
  {
    $this->attributes['cvv'] = encrypt($value);
    $this->attributes['cvv_hash'] = bcrypt($value);
  }

  public function getCvvAttribute()
  {
    return '****'; //decrypt($this->attributes['cvv']);
  }


  static function appUserRoutes()
  {
    Route::group([], function () {

      Route::get('debit-cards', [self::class, 'viewDebitCards'])->name('appuser.my-cards')->defaults('extras', ['icon' => 'far fa-credit-card']);

      Route::post('/debit-card/create', [self::class, 'addNewDebitCard'])->name('appuser.cards.add');

      Route::put('/debit-card/default', [self::class, 'setDefaultDebitCard'])->name('appuser.cards.default');

      Route::delete('/debit-card/{debit_card}', [self::class, 'deleteDebitCard'])->name('appuser.cards.delete');

      Route::get('/debit-card/{debitCard}/authorize', [self::class, 'authorizeDebitCard'])->name('appuser.cards.authorize')->defaults('extras', ['nav_skip' => true]);

      Route::get('/debit-card/{debitCard:uuid}/verify', [self::class, 'verifyAuthorizeDebitCard'])->name('appuser.debit_card.verify')->defaults('extras', ['nav_skip' => true]);
    });
  }

  public function viewDebitCards(Request $request)
  {
    if ($request->isApi()) {
      return $request->user()->debit_cards;
    } else {
      return Inertia::render('DebitCards', [
        'debit_cards' => (new DebitCardTransformer)->collectionTransformer($request->user()->debit_cards, 'transformWithX')
      ]);
    }
  }

  public function addNewDebitCard(AddNewDebitCardValidation $request)
  {
    $debitCard = $request->user()->debit_cards()->create($request->validated());

    if ($request->isApi()) {
      return response()->json($debitCard, 201);
    }
    return back()->withSuccess('Card successfully added to your account');
  }

  public function setDefaultDebitCard(Request $request)
  {
    $debit_card = self::findOrFail(request('debit_card_id'));

    auth()->user()->debit_cards()->update(['is_default' => false]);

    $debit_card->is_default = true;
    $debit_card->save();

    if ($request->isApi()) {
      return response()->json(['rsp' => true], 204);
    }
    return back()->withSuccess('Card ' . $debit_card->pan . ' has been made the default card');
  }

  public function deleteDebitCard(Request $request, self $debit_card)
  {
    if ($debit_card->belongs_to($request->user())) {
      /**
       * Check if this is his default card
       */
      if ($debit_card->is_default_card()) {
        return generate_422_error('You cannot delete your default card.');
      }

      /**
       * Check if he has autosave
       */
      if ($request->user()->has_auto_save()) {
        return generate_422_error('You cannot delete your card when you have activated autosave. Contact support if you really need to remove your card.');
      }

      /**
       * then delete the card soft delete
       */

      $debit_card->delete();

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withSuccess('Deleted');
    } else {
      abort(403, 'invalid operation');
    }
  }

  public function authorizeDebitCard(Request $request, self $debitCard)
  {
    return PaystackTransaction::initializeTransaction($request, 50, 'Debit card authorization', route('appuser.debit_card.verify', $debitCard->uuid));
  }

  public function verifyAuthorizeDebitCard(Request $request, self $debitCard)
  {
    // dd($debitCard);

    if (!($rsp = PaystackTransaction::verifyPaystackTransaction($request->trxref, $request->user(), $returnResponse = true))) {
      return back()->withError('An error occured');
    } else {
      DB::beginTransaction();
      /** Give the user value */
      $request->user()->fund_smart_savings($rsp['amount'], $rsp['description']);

      $debitCard->is_authorised = true;
      $debitCard->authorization_code = $rsp['paystackRsp']['data']['authorization']['authorization_code'];
      $debitCard->authorization_object = $rsp['paystackRsp']['data']['authorization'];
      $debitCard->save();

      DB::commit();

      return back()->withSuccess('Done');
    }
  }

  public static function boot()
  {
    parent::boot();

    static::creating(function ($debitCard) {
      $debitCard->uuid = Str::uuid();
    });
  }
}
