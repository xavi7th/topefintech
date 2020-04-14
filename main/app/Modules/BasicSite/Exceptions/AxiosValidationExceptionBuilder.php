<?php

namespace App\Modules\BasicSite\Exceptions;

use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class AxiosValidationExceptionBuilder extends Exception
{
	protected $validator;

	protected $code = 422;

	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Report or log an exception.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report()
	{
		if (DB::transactionLevel() > 0) {
			Db::rollBack();
		}
		Log::channel('database')->info('Form Validation Error', ['userId' => auth()->id(), 'userType' => get_class(auth()->user()), 'msg' => $this->validator->errors()->all(), 'context' => $this]);
	}

	/**
	 * Build the response to be returned
	 *
	 * @return response
	 */
	public function render()
	{
		return response()->json([
			"error" => "form validation error",
			// "message" => implode('<br>', $this->validator->errors()->all())
			"message" => $this->validator->errors()->all()
		], $this->code);
	}
}
