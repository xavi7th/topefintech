<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CreteInvestmentTypeValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    if ($this->isMethod('POST')) {
      return [
        'duration' => 'required|numeric',
        'name' => 'required|string|max:191|unique:investment_types,name',
        'interest_rate' => 'required|numeric|max:100|min:0',
      ];
    } elseif ($this->isMethod('PUT')) {
      return [
        'duration' => 'required|numeric',
        'name' => 'required|string|max:191|unique:investment_types,name,' . $this->investmentType->name . ',name',
        'interest_rate' => 'required|numeric|max:100|min:0',
      ];
    }
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // dd($this->investmentType);
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
      'duration.required' => 'Enter a duration for this investment plan',
      'name.required' => 'Enter a name to be displayed for this investment plan',
      'name.unique' => 'An investment plan exists with this name already',
      'name.max' => 'The name of an investment plan must be a maximum of 191 characters',
      'interest_rate.required' => 'Enter an interest rate for the duration of this investment plan',
      'interest_rate.numeric' => 'The interest rate must be a number',
      'interest_rate.max' => 'The interest rate must be a number between 0 and 100',
      'interest_rate.min' => 'The interest rate must be a number between 0 and 100',
    ];
  }

  // public function validated()
  // {
  //   /**
  //    * Add the type of savings
  //    */
  //   return array_merge(parent::validated(), [
  //     'daily_interest_rate' => $this->interest_rate / now()->addRealMonths($this->duration)->floatDiffInRealDays(now())
  //   ]);
  // }

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
