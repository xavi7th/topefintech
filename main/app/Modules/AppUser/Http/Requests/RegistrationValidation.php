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
      'full_name' => 'required|string|max:50',
      'phone' => 'required|string|max:20',
      'email' => 'required|string|email|max:50|unique:users,email',
      'password' => 'required|string|min:4|max:50|confirmed',
      'agreement' => 'required|in:1,true,"true"',
      'referral_id' => 'nullable|exists:agents,ref_code'
      // 'currency' => 'required|string|not_in:null',
      // 'country' => 'required|string|not_in:null',
      // 'phone' => 'required|regex:/^[\+]?[0-9\Q()\E\s-]+$/i|unique:users,phone',
      // 'id_card' => 'required|file|mimes:jpeg,bmp,png,pdf',
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
      'phone.numeric' => 'Invalid phone number',
      // 'id_card.required' => 'Upload a valid ID Card for verification purposes',
      // 'id_card.mimes' => 'Your ID Card must be an image of a pdf file',
      'agreement.required' => 'You must accept our terms and conditions to register',
      'agreement.in' => 'You must accept our terms and conditions to register',
    ];
  }
}
