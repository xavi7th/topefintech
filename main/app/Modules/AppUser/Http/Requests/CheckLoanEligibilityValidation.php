<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CheckLoanEligibilityValidation extends FormRequest
{

  public $is_eligible = true;
  public $eligibility_failures = [];

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
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'amount' => 'required|numeric',
    ];
  }

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {
      if (!empty($validator->failed())) {
        if ($this->isApi()) {
          return;
        }
      }
      if (!$this->user()->is_bvn_verified) {
        $validator->errors()->add('amount', 'Verify your bvn to be eligible for smart loans');
        $this->markIneligible('Verify your bvn to be eligible for smart loans');
        if ($this->isApi()) {
          return;
        }
      }
      if (!$this->user()->default_debit_card()->exists()) {
        $validator->errors()->add('amount', 'You must have one valid Debit Card set as default in your profile');
        $this->markIneligible('You must have one valid Debit Card set as default in your profile');

        if ($this->isApi()) {
          return;
        }
      }
      if ($this->user()->has_pending_loan()) {
        $validator->errors()->add('amount', 'You already have a pending loan. You are not eligible for another');
        $this->markIneligible('You already have a pending loan. You are not eligible for another');

        if ($this->isApi()) {
          return;
        }
      }
      if ($this->user()->is_loan_surety()) {
        $validator->errors()->add('amount', 'You are currently suretying for another user. You are not eligible for another');
        $this->markIneligible('You are currently suretying for another user. You are not eligible for another');
        if ($this->isApi()) {
          return;
        }
      }
    });
  }

  /**
   * Overwrite the validator response so we can customise it per the structure requested from the fronend
   *
   * @param \Illuminate\Contracts\Validation\Validator $validator
   * @return void
   */
  protected function failedValidation(Validator $validator)
  {
    if ($this->isApi()) {
      throw new AxiosValidationExceptionBuilder($validator, $this);
    }
  }

  protected function failedAuthorization()
  {
    throw new AuthorizationException('You are not yet due for smartloan facility');
  }

  private function markIneligible($reason)
  {
    $this->eligibility_failures = collect($this->eligibility_failures)->concat([$reason]);
    $this->is_eligible = false;
  }
}
