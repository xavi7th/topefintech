<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CreateWithdrawalRequestValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'amount' => 'bail|required|numeric|gte:1000|lte:' . $this->user()->total_withdrawable_amount(),
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Configure the error messages for the defined validation rules.
   *
   * @return array
   */
  public function messages()
  {
    return [
      'amount.gte' => 'Minimum amount withdrawable is ' . to_naira(1000),
      'amount.lte' => 'Maximum amount withdrawable is ' . to_naira($this->user()->total_withdrawable_amount())
    ];
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
       * Check if bank and bvn are validated
       */
      if (!($this->user()->is_bvn_verified && $this->user()->is_bank_verified)) {
        $validator->errors()->add('amount', 'BVN and bank account number must be verified before withdrawal');
      }

      /**
       * check if pending withdrawal request
       */
      if ($this->user()->has_pending_withdrawal_request()) {
        $validator->errors()->add('amount', 'You already have a pending request.');
        return;
      }
    });
  }

  public function validated()
  {
    /**
     * Check if user is due for withdrawal and flag for extra charge
     */

    if (!$this->user()->is_due_for_withdrawal()) {
      return array_merge(parent::validated(), [
        'is_charge_free' => false
      ]);
    } else {
      return array_merge(parent::validated(), [
        'is_charge_free' => true
      ]);
    }
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
