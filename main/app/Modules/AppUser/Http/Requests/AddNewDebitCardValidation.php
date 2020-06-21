<?php

namespace App\Modules\AppUser\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class AddNewDebitCardValidation extends FormRequest
{
  /** @var object $details The details gotten from resolving the BIN number of this card */
  private $details = null;

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'pan' => ['required', new CardNumberOveride],
      'year' => ['required', new CardExpirationYearOveride($this->get('month'))],
      'month' => ['required', new CardExpirationMonthOveride($this->get('year'))],
      'cvv' => ['required', new CardCvcOveride($this->get('pan'))]

    ];
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [];
  }

  /**
   * Configure the validator instance.
   *
   * @param  \Illuminate\Validation\Validator  $validator
   * @return void
   */
  public function withValidator($validator)
  {
    $validator->after(function ($validator) {

      /**
       * Check to make sure the card is a nigerian card
       */
      $this->details = resolve_debit_card_bin(substr($this->pan, 0, 6));

      if (isset($this->details->code)) {
        $validator->errors()->add('pan', 'Error verifying PAN');
        return;
      }

      if ($this->details->country_name !== 'Nigeria') {
        $validator->errors()->add('pan', 'Only Cards issued by Nigerian financial institutions allowed');
        return;
      }
    });
  }


  public function validated()
  {
    /**
     * Add the extra details gotten from the BIN resolution to the validated request params
     */

    return array_merge(parent::validated(), [
      'brand' => $this->details->brand,
      'sub_brand' => $this->details->sub_brand,
      'country' => $this->details->country_name,
      'card_type' => $this->details->card_type,
      'bank' => $this->details->bank
    ]);
  }


  /**
   * Overwrite the validator response so we can customise it per the structure requested from the fronend
   *
   * @param \Illuminate\Contracts\Validation\Validator $validator
   * @return void
   */
  protected function failedValidation(Validator $validator)
  {
    /**
     * * Alternatively throw new AuthenticationFailedException($validator). Remember to use App\Exceptions\Admin\AuthenticationFailedException;
     * * And handle there. That will help for reuse. Handling here for compactness purposes
     * ? Who knows they might ask for a different format for the enxt validation
     */

    throw new AxiosValidationExceptionBuilder($validator, $this);
  }
}

class CardNumberOveride extends CardNumber
{

  const MSG_CARD_INVALID = 'validation.credit_card.card_invalid';
  const MSG_CARD_PATTER_INVALID = 'validation.credit_card.card_pattern_invalid';
  const MSG_CARD_LENGTH_INVALID = 'validation.credit_card.card_length_invalid';
  const MSG_CARD_CHECKSUM_INVALID = 'validation.credit_card.card_checksum_invalid';

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {

    switch ($this->message) {
      case self::MSG_CARD_INVALID:
        return 'The PAN is invalid';
        break;
      case self::MSG_CARD_PATTER_INVALID:
        return 'The PAN is pattern invalid';
        break;
      case self::MSG_CARD_LENGTH_INVALID:
        return 'The PAN has an invalid length';
        break;
      case self::MSG_CARD_CHECKSUM_INVALID:
        return 'Not a valid Credit/Debit Card';
        break;
      default:
        'There was an unknown error while trying to validate the Card';
        break;
    }
  }
}

class CardExpirationYearOveride extends CardExpirationYear
{
  const MSG_CARD_EXPIRATION_YEAR_INVALID = 'validation.credit_card.card_expiration_year_invalid';

  /**
   * Get the validation error message.
   *
   * @return string
   */
  public function message()
  {
    return 'The Card expiration year is invalid';
  }
}

class CardExpirationMonthOveride extends CardExpirationMonth
{
  public function message()
  {
    return 'The Card expiration month is invalid';
  }
}

class CardCvcOveride extends CardCvc
{
  public function message()
  {
    return 'The Card CVV number is incorrect';
  }
}
