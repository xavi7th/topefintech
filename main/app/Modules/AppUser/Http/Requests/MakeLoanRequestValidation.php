<?php

namespace App\Modules\AppUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Auth\Access\AuthorizationException;
use App\Modules\BasicSite\Exceptions\AxiosValidationExceptionBuilder;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MakeLoanRequestValidation extends FormRequest
{

  public $surety1Details;
  public $surety2Details;
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'amount' => 'required|numeric',
      'surety1' => 'required|email',
      'surety2' => 'required|email',
      'repayment_installation_duration' => 'required|in:weekly,monthly',
      'auto_debit' => 'sometimes|boolean'
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
   * Configure the validator instance.
   *
   * @param  \Illuminate\Validation\Validator  $validator
   * @return void
   */
  public function withValidator($validator)
  {
    $validator->after(function ($validator) {

      try {
        $this->surety1Details = AppUser::where('email', $this->surety1)->firstOrFail();
        if (!$this->surety1Details->is_eligible_for_loan_surety($this->amount)) {
          $validator->errors()->add('amount', $this->surety1Details->email . ' is not an eligible surety for your loan request.');
        }

        $this->surety2Details = AppUser::where('email', $this->surety2)->firstOrFail();
        if (!$this->surety2Details->is_eligible_for_loan_surety($this->amount)) {
          $validator->errors()->add('amount', $this->surety2Details->email . ' is not an eligible surety for your loan request.');
        }
      } catch (\Throwable $th) {
        if ($th instanceof ModelNotFoundException) {
          $validator->errors()->add('surety1', 'One of your surety emails is invalid');
        }
      }

      // if ($this->surety1Details->is($this->surety2Details)) {
      //   $validator->errors()->add('surety2', 'You need two unique sureties');
      //   return;
      // }
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
    throw new AuthorizationException('You are not yet due for this amount of smartloan facility');
  }
}
