<?php

namespace App\Modules\AppUser\Http\Requests;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\LoanSurety;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class SwapSuretyValidation extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'new_surety_email' => 'required|email|exists:users,email',
			'surety_request_id' => 'required|numeric|exists:loan_sureties,id',
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

			// Check the status of the surety request
			// For simplicity if declined or still null just delete that one
			// If surety accepted decline the swap request

			if ($validator->errors()->isEmpty()) {
				$surety_request = LoanSurety::find($this->surety_request_id);

				if ($surety_request && $surety_request->is_surety_accepted()) {
					$validator->errors()->add('Swap rejected', 'This surety has accepted your request already. You cannot swap them');
					return;
				}

				$new_surety = AppUser::where('email', $this->new_surety_email)->first();
				if ($new_surety && !$new_surety->is_eligible_for_loan_surety($surety_request->loan_request->amount)) {
					$validator->errors()->add('Ineligible surety', $this->new_surety_email . ' is not an eligible surety for your loan request.');
				}
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
