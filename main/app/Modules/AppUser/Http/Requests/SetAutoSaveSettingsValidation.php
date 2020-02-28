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
			'period' => 'required|in:daily,weekly,monthly,quarterly',
			'date' => ['nullable', Rule::requiredIf($this->period == 'monthly'), 'integer', 'max:' . now()->endOfMonth()->day],
			'weekday' => ['nullable', 'string', Rule::requiredIf($this->period == 'weekly'), Rule::in(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])],
			'time' => ['nullable', Rule::requiredIf($this->period == 'daily'), 'date_format:H:i'],
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
			'period.in' => 'The period field must either be daily, weekly, monthly or quarterly',
			'time.required_if' => 'The time field is required if the period is daily',
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
			// dd($this->all());
			/**
			 * Check if by some trickery the user has manipulated his savings distribution above 100%
			 */
			$total_percentage = $this->user()->savings_list()->sum('savings_distribution');
			if ($total_percentage != 100) {
				$validator->errors()->add('Savings distribution', 'Your savings distribution is not 100%. Correct it before continuing');
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

		throw new AxiosValidationExceptionBuilder($validator);
	}
}
