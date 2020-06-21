<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Requests\AddNewDebitCardValidation;
use App\Modules\AppUser\Transformers\DebitCardTransformer;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereCvvHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard wherePanHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereSubBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\DebitCard whereUpdatedAt($value)
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
    $debit_card = DebitCard::findOrFail(request('debit_card_id'));

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
       * Check if he has pending loan
       */
      if ($request->user()->has_pending_loan()) {
        return generate_422_error('You cannot delete debit cards while you have a pending loan');
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
}
