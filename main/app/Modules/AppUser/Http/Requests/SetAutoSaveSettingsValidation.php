<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class SetAutoSaveSettingsValidation extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'amount' => 'required|numeric',
      'frequency' => 'required|in:daily,weekly,monthly,quarterly',
      'date' => ['nullable', Rule::requiredIf($this->frequency == 'monthly'), 'integer', 'max:' . now()->endOfMonth()->day],
      'weekday' => ['nullable', 'string', Rule::requiredIf($this->frequency == 'weekly'), Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
      'time' => ['nullable', Rule::requiredIf($this->frequency == 'daily'), 'date_format:H:i'],
      'try_other_cards' => 'filled',
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
      'frequency.in' => 'The frequency field must either be daily, weekly, monthly or quarterly',
      'time.required_if' => 'The time field is required if the frequency is daily',
      'weekday.required' => 'If the frequency is weekly you must select a week day to process deductions',
    ];
  }

  public function validated()
  {
    /**
     * Remove the img key from the validated options so that it does not cause errors with the edit route
     */

    return array_merge(parent::validated(), [
      'period' => $this->frequency,
      'date' => $this->frequency == 'quarterly' ? null : $this->date,
      'weekday' => $this->frequency == 'quarterly' ? null : $this->weekday,
      'time' => $this->frequency == 'quarterly' ? null : $this->time,
    ]);
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
      if (!$this->user()->has_authorised_card()) {
        $validator->errors()->add('amount', 'You must authorise a card for debits before adding an auto save setting');
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
