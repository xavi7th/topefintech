<?php

namespace App\Modules\BasicSite\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormValidation extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
      'first_name' => 'required|max:35|string',
      'last_name' => 'required|max:35|string',
      'phone' => 'required|max:35|string',
			'email' => 'required|email|max:100',
      'address' => 'nullable|max:191|string',
      'message' => 'required|string',
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
      'phone.required' => 'Give us a phone number where we can reach you if necessary',
			'email.required' => 'Your email cannot be empty',
			'email.email' => 'The email you supplied is invalid',
      'message.required' => 'Tell us what you want to talk about',
		];
	}
}
