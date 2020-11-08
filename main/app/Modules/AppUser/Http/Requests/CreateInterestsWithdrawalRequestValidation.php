<?php

namespace App\Modules\AppUser\Http\Requests;

use App\Modules\AppUser\Models\Savings;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CreateInterestsWithdrawalRequestValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'description' => 'required|max:191'
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
      if (!$this->user()->is_bank_verified) {
        $validator->errors()->add('amount', 'You must add a bank account to your profile before withdrawal');
      }

      /**
       * check if pending withdrawal request
       */
      if ($this->user()->hasPendingWithdrawalRequest()) {
        $validator->errors()->add('amount', 'You already have a pending request.');
        return;
      }

      /**
       * check if pending withdrawal request
       */
      if (!$this->savings->isDueForInterestsWithdrawal()) {
        $validator->errors()->add('amount', 'This portfolio is not yet due for interests withdrawal. Contact our support team for more information');
        return;
      }
    });
  }

  public function validated()
  {
    /**
     * Check if user is due for withdrawal and flag for extra charge
     * ! Check if this savings is liquidated
     */
    // $savings_record = Savings::find($this->route('savings_id'));
    $savings_record = $this->savings;
    if (!$savings_record->is_due_for_free_withdrawal()) {
      return array_merge(parent::validated(), [
        'is_charge_free' => false,
        'amount' => $savings_record->unprocessedTotalInterestsAmount(),
        'savings_id' => $savings_record->id,
        'is_interests' => true,
      ]);
    } else {
      return array_merge(parent::validated(), [
        'is_charge_free' => true,
        'amount' => $savings_record->unprocessedTotalInterestsAmount(),
        'savings_id' => $savings_record->id,
        'is_interests' => true,
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
