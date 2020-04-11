<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class EditUserProfileValidation extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			// 'email' => ['filled', 'email', Rule::unique('users')->ignore(Auth::apiuser()->id)],
			'full_name' => 'filled|string',
			'password' => 'filled|min:6|regex:/^([0-9a-zA-Z-_\.\@]+)$/',
			// 'phone' => ['filled', 'regex:/^[\+]?[0-9\Q()\E\s-]+$/i', Rule::unique('users')->ignore(Auth::apiuser()->phone)],
			'address' => 'filled|string',
			'city' => 'filled|string',
			'country' => 'filled|string',
			'acc_num' => ['filled', 'numeric', Rule::unique('users')->ignore(Auth::apiuser()->acc_num)],
			'acc_bank' => 'filled|string',
			'acc_type' => 'filled|string',
			'bvn' => ['filled', 'numeric', Rule::unique('users')->ignore(Auth::apiuser()->bvn)],
			'id_card' => 'bail|filled|file|mimes:jpeg,bmp,png',
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
