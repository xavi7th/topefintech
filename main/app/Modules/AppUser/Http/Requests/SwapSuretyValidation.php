<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Http\Response;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\LoanSurety;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;

class SwapSuretyValidation extends FormRequest
{
  public $newSurety;
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'new_surety_email' => 'required|email',
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
    return $this->user()->pending_loan_request()->exists();
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

      try {
        $this->newSurety = AppUser::where('email', $this->new_surety_email)->firstOrFail();
      } catch (\Throwable $th) {
        $validator->errors()->add('new_surety_email', 'The selected new surety email is invalid.');
        return;
      }

      // Check the status of the surety request
      // For simplicity if declined or still null just delete that one
      // If surety accepted decline the swap request

      if ($validator->errors()->isEmpty()) {
        $surety_request = LoanSurety::find($this->surety_request_id);

        if ($surety_request && $surety_request->is_surety_accepted()) {
          $validator->errors()->add('new_surety_email', 'This surety has accepted your request already. You cannot swap them');
          return;
        }


        if ($this->newSurety && !$this->newSurety->is_eligible_for_loan_surety($surety_request->loan_request->amount)) {
          $validator->errors()->add('new_surety_email', $this->new_surety_email . ' is not an eligible surety for your loan request.');
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

    throw new AxiosValidationExceptionBuilder($validator, $this);
  }


  protected function failedAuthorization()
  {
    throw ValidationException::withMessages([
      'new_surety_email' => 'You do not have a pending Smartloan request',
    ])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
  }
}
