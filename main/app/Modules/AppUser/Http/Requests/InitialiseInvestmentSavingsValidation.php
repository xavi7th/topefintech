<?php

namespace App\Modules\AppUser\Http\Requests;

use App\Modules\AppUser\Models\InvestmentType;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class InitialiseInvestmentSavingsValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'portfolio_id' => 'required|numeric|exists:investment_types,id',
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
      'portfolio_id.required' => 'Select a valid investment portfolio',
      'duration.numeric' => 'Invalid investment portfolio selected',
      'duration.exists' => 'Invalid investment portfolio selected',
    ];
  }


  /**
   * Configure the validator instance.
   *
   * @param  \Illuminate\Validation\Validator  $validator
   * @return void
   */
  // public function withValidator($validator)
  // {
  //   $validator->after(function ($validator) {
  //     if ($this->user()->has_smart_savings()) {
  //       $validator->errors()->add('duration', 'You already have a smart savings portfolio. If you need more savings portfolios, create a target savings');
  //       return;
  //     }
  //   });
  // }

  public function validated()
  {
    /**
     * Add the type of savings
     */
    return array_merge(parent::validated(), [
      'type' => 'investment',
      'maturity_date' => now()->addMonths($this->selected_investment['duration']),
      'portfolio_type' => InvestmentType::class
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
