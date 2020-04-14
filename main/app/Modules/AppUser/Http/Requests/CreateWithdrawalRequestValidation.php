<?php

namespace App\Modules\AppUser\Http\Requests;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\LoanSurety;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class CreateWithdrawalRequestValidation extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'amount' => 'required|numeric|gte:2000|lte:' . $this->user()->total_withdrawable_amount(),
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
			'amount.gte' => 'Minimum amount withdrawable is ' . to_naira(2000)
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
			/**
			 * Check if bank and bvn are validated
			 */
			if (!($this->user()->is_bvn_verified && $this->user()->is_bank_verified)) {
				$validator->errors()->add('Unverified', 'BVN and bank account number must be verified before withdrawal');
			}

			/**
			 * Check if has pending loan
			 */
			if ($this->user()->has_pending_loan()) {
				$validator->errors()->add('Loan restrictions', 'Those with pending loans cannot withdraw funds');
				return;
			}

			/**
			 * Check if surety and how much
			 */
			if ($this->user()->is_loan_surety() && ($this->amount >= ($this->user()->total_withdrawable_amount() - $this->user()->loan_surety_amount()))) {
				$validator->errors()->add('Loan restrictions', 'Loan sureties can only withdraw funds above the surety amount');
				return;
			}

			/**
			 * check if pending withdrawal request
			 */
			if ($this->user()->has_pending_withdrawal_request()) {
				$validator->errors()->add('Pemding Request', 'You already have a pending request.');
				return;
			}

			/**
			 * Check if user is due for withdrawal
			 */
			if ($this->user()->is_due_for_withdrawal()) {
				$validator->errors()->add('Withdraw restrictions', 'You are not yet due for free withdrawals');
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
