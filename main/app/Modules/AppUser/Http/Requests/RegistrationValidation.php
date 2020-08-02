<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class RegistrationValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'first_name' => 'required|string|max:50',
      'last_name' => 'required|string|max:50',
      'phone' => 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i|unique:app_users,phone',
      'email' => 'nullable|string|email|max:50|unique:app_users,email',
      'password' => 'required|string|min:4|max:50|confirmed',
      'agreement' => 'required|in:1,true,"true"',
      'referral_id' => 'nullable|exists:agents,ref_code'
    ];
  }

  public function authorize()
  {
    return true;
  }

  public function messages()
  {
    return [
      'phone.numeric' => 'Invalid phone number',
      'agreement.required' => 'You must accept our terms and conditions to register',
      'agreement.in' => 'You must accept our terms and conditions to register',
    ];
  }

  public function validated()
  {
    /**
     * merge the name fields into one for storing
     */
    return array_merge((collect(parent::validated())->except(['first_name', 'last_name']))->all(), [
      'full_name' => $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name
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
