<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Http\Response;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CheckSuretyValidation extends FormRequest
{
  public $surety_details;

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'email' => 'nullable|email',
      'amount' => 'required|numeric',
    ];
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return $this->user()->is_eligible_for_loan($this->amount);
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
      if ($this->email === $this->user()->email) {
        $validator->errors()->add($this->surety, 'You cannot stand as a surety for your self');
      }
      try {
        $surety_details = AppUser::where('email', $this->email)->firstOrFail();

        $this->surety_details = $surety_details;

        if (!$surety_details->is_bvn_verified) {
          $validator->errors()->add($this->surety, 'Surety\'s bvn is not verified to be eligible for smart loans');
        } elseif (!$surety_details->default_debit_card()->exists()) {
          $validator->errors()->add($this->surety, 'User does not have any valid Debit Card set as default in their profile');
        } elseif ($surety_details->has_pending_loan()) {
          $validator->errors()->add($this->surety, 'This user is not an eligible surety.');
        } elseif ($surety_details->is_loan_surety()) {
          $validator->errors()->add($this->surety, 'User is already suretying for another user. They are no longer eligible');
        } elseif (!$surety_details->is_eligible_for_loan_surety($this->amount)) {
          $validator->errors()->add($this->surety, 'User is not an eligible surety');
        }
      } catch (\Throwable $th) {
        $validator->errors()->add($this->surety, 'Invalid email selected');
        return;
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
    /**
     * * Alternatively throw new AuthenticationFailedException($validator). Remember to use App\Exceptions\Admin\AuthenticationFailedException;
     * * And handle there. That will help for reuse. Handling here for compactness purposes
     * ? Who knows they might ask for a different format for the enxt validation
     */

    throw new AxiosValidationExceptionBuilder($validator, $this);
  }


  protected function failedAuthorization()
  {
    // throw new AuthorizationException('You are not yet due for a smartloan facility of this amount');
    throw ValidationException::withMessages([
      'amount' => 'You are not yet due for a smartloan facility of this amount',
    ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
  }
}
