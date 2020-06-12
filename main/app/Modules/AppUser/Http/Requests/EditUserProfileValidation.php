<?php

namespace App\Modules\AppUser\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
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
      // 'full_name' => 'required|string|max:50',
      'password' => 'filled|min:6|regex:/^([0-9a-zA-Z-_\.\@]+)$/|confirmed|max:20',
      'phone' => ['required_without_all:password,acc_bank,acc_num,acc_type', 'nullable', 'regex:/^[\+]?[0-9\Q()\E\s-]+$/i', 'max:20', Rule::unique('users')->ignore($this->user()->phone, 'phone')],
      'address' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'city' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'country' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'date_of_birth' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|date',
      'acc_num' => ['bail', 'required_with:acc_bank,acc_type', 'numeric', Rule::unique('users')->ignore($this->user()->acc_num)],
      'acc_bank' => 'bail|required_with:acc_num,acc_type|string',
      'acc_type' => 'bail|required_with:acc_num,acc_bank|string',
      'bvn' => ['filled', 'numeric', Rule::unique('users')->ignore($this->user()->bvn)],
      'id_card' => 'bail|nullable|file|mimes:jpeg,bmp,png',
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
      'phone.required_without_all' => 'Your phone number is required',
      'address.required_without_all' => 'Your address is required',
      'city.required_without_all' => 'Your city is required',
      'country.required_without_all' => 'Your country is required',
      'date_of_birth.required_without_all' => 'Your date of birth is required',
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

      /** User muat be above 18 */
      if (!is_null($this->date_of_birth) && Carbon::parse($this->date_of_birth)->gte(now()->subYears(18))) {
        $validator->errors()->add('date_of_birth', 'You have to be 18 and older.');
      }

      if ($this->password) {
        if (!Hash::check($this->current_password, $this->user()->password)) {
          $validator->errors()->add('current_password', 'The supplied password is not correct. Have you forgotten your password?');
          return;
        }
      }

      if ($this->bvn) {
        if ($this->user()->total_balance() < config('app.balance_before_bvn_validation')) {
          $validator->errors()->add('bvn', 'You are not yet due to enter and validate your bvn. Become active on out platform before updating your BVN');
          return;
        }

        $rsp = $this->user()->validate_bvn($this->bvn, $this->phone, $this->full_name);

        if ($rsp->code === 0) {
          $validator->errors()->add('bvn', $rsp->msg);
          return;
        } elseif ($rsp->code === 400) {
          $validator->errors()->add('bvn', 'We were unable to resolve your provided BVN. Check it again to make sure there are no errors');
          return;
        } elseif ($rsp->code === 409) {
          $validator->errors()->add('bvn', $rsp->msg);
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
          $validator->errors()->add('acc_num', 'This bank account number does not match the full name you supplied');
        } elseif ($rsp === 422) {
          $validator->errors()->add('acc_num', 'This account number is invalid');
        } elseif ($rsp === 400) {
          $validator->errors()->add('acc_bank', 'This bank name is incorrect or not verifiable. Try another form of the name if any');
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
