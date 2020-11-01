<?php

namespace App\Modules\Admin\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class AdminEditUserProfileValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'email' => 'nullable|email|unique:app_users,email,' . $this->appUser->id,
      'full_name' => 'required|string|max:50',
      // 'phone' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|regex:/^[\+]?[0-9\Q()\E\s-]+$/i|max:20|unique:app_users,phone,' . $this->user()->id,
      'address' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'city' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'country' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|string',
      'date_of_birth' => 'required_without_all:password,acc_bank,acc_num,acc_type|nullable|date',
      'gender' => 'bail|nullable|string|max:10',
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
      'phone.required_without_all' => 'User´s phone number is required',
      'address.required_without_all' => '<User>s</User> address is required',
      'city.required_without_all' => '<User>s</User> city is required',
      'country.required_without_all' => 'User´s country is required',
      'date_of_birth.required_without_all' => 'User´s date of birth is required',
      'id_card.mimes' => 'User´s profile picture must be an image',
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
        $validator->errors()->add('date_of_birth', 'User has to be 18 and older.');
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
