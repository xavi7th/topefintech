<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class EditUserProfileValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      // 'email' => ['filled', 'email', Rule::unique('users')->ignore(Auth::apiuser()->id)],
      'full_name' => 'filled|string',
      'password' => 'filled|min:6|regex:/^([0-9a-zA-Z-_\.\@]+)$/',
      // 'phone' => ['filled', 'regex:/^[\+]?[0-9\Q()\E\s-]+$/i', Rule::unique('users')->ignore(Auth::apiuser()->phone)],
      'address' => 'filled|string',
      'city' => 'filled|string',
      'country' => 'filled|string',
      'acc_num' => ['bail', 'required_with:acc_bank,acc_type', 'numeric', Rule::unique('users')->ignore($this->user()->acc_num)],
      'acc_bank' => 'bail|required_with:acc_num,acc_type|string',
      'acc_type' => 'bail|required_with:acc_num,acc_bank|string',
      'bvn' => ['filled', 'numeric', Rule::unique('users')->ignore($this->user()->bvn)],
      'id_card' => 'bail|filled|file|mimes:jpeg,bmp,png',
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
      'acc_num.required_with' => 'You must enter your bank name and account type along with your account number',
      'acc_bank.required_with' => 'You must enter your account number and account type along with your bank name',
      'acc_type.required_with' => 'You must enter your account number and bank name along with your account type',
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

      if ($this->bvn) {
        if ($this->user()->total_balance() < config('app.balance_before_bvn_validation')) {
          $validator->errors()->add('BVN Error', 'You are not yet due to enter and validate your bvn. Become active on out platform before updating your BVN');
          return;
        }

        $rsp = $this->user()->validate_bvn($this->bvn, $this->phone, $this->full_name);

        if ($rsp->code === 0) {
          $validator->errors()->add('BVN Error', $rsp->msg);
          return;
        } elseif ($rsp->code === 400) {
          $validator->errors()->add('BVN Error', 'We were unable to resolve your provided BVN. Check it again to make sure there are no errors');
          return;
        } elseif ($rsp->code === 409) {
          $validator->errors()->add('BVN Error', $rsp->msg);
          return;
        }
        return;
      }

      /**
       * Validate the user's bank account details
       * ! We are using Paystack endpoint
       */
      if ($this->acc_num && $this->acc_bank) {
        $rsp = $this->user()->validate_bank_account($this->acc_num, $this->acc_bank, $this->full_name);

        if ($rsp === 409) {
          $validator->errors()->add('Invalid Account Number', 'This bank account number does not match the full name you supplied');
        } elseif ($rsp === 422) {
          $validator->errors()->add('Invalid Account Number', 'This account number is invalid');
        } elseif ($rsp === 400) {
          $validator->errors()->add('Invalid Account Number', 'This bank name is incorrect or not verifiable. Try another form of the name if any');
        }
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
}
