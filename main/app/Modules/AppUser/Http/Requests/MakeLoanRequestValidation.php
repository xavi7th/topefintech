<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;
use App\Modules\AppUser\Models\AppUser;

class MakeLoanRequestValidation extends FormRequest
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
			'first_surety' => 'required|email|exists:users,email',
			'second_surety' => 'required|email|exists:users,email',
			'repayment_installation_duration' => 'required|in:weekly,monthly',
			'expiration_date' => 'required|date'
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return auth()->user()->is_eligible_for_loan($this->amount);
	}



	/**
	 * Configure the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [];
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

			$first_surety = AppUser::where('email', $this->first_surety)->first();
			if (!$first_surety->is_eligible_for_loan_surety($this->amount)) {
				$validator->errors()->add('Ineligible surety', $this->first_surety . ' is not an eligible surety for your loan request.');
			}

			$second_surety = AppUser::where('email', $this->second_surety)->first();
			if (!$second_surety->is_eligible_for_loan_surety($this->amount)) {
				$validator->errors()->add('Ineligible surety', $this->second_surety . ' is not an eligible surety for your loan request.');
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


	protected function failedAuthorization()
	{
		throw new AuthorizationException('You are not yet due for smartloan facility');
	}
}