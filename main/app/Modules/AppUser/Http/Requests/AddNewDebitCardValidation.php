<?php

namespace App\Modules\AppUser\Http\Requests;

use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class AddNewDebitCardValidation extends FormRequest
{
	/** @var object $details The details gotten from resolving the BIN number of this card */
	private $details = null;

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'pan' => ['required', new CardNumber],
			'year' => ['required', new CardExpirationYear($this->get('month'))],
			'month' => ['required', new CardExpirationMonth($this->get('year'))],
			'cvv' => ['required', new CardCvc($this->get('pan'))]

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

			/**
			 * Check to make sure the card is a nigerian card
			 */
			$this->details = resolve_debit_card_bin(substr($this->pan, 0, 6));

			if ($this->details->country_name !== 'Nigeria') {
				$validator->errors()->add('Invalid Card', 'Only Cards issued by Nigerian financial institutions allowed');
				return;
			}
		});
	}


	public function validated()
	{
		/**
		 * Add the extra details gotten from the BIN resolution to the validated request params
		 */

		return array_merge(parent::validated(), [
			'brand' => $this->details->brand,
			'sub_brand' => $this->details->sub_brand,
			'country' => $this->details->country_name,
			'card_type' => $this->details->card_type,
			'bank' => $this->details->bank
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

		throw new AxiosValidationExceptionBuilder($validator);
	}
}
