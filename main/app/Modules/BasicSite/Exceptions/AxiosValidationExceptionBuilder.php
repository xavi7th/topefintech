<?php

namespace App\Modules\BasicSite\Exceptions;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AxiosValidationExceptionBuilder extends Exception
{
  protected $validator;
  protected $validation_class;

  protected $code = 422;

  public function __construct(Validator $validator, FormRequest $validation_class)
  {
    $this->validator = $validator;
    $this->validation_class = $validation_class;
  }

  /**
   * Report or log an exception.
   *
   * @param  \Exception  $exception
   * @return void
   */
  public function report()
  {
    ErrLog::logValidationErrors($this->validator, $this->validation_class);
  }

  /**
   * Build the response to be returned
   *
   * @return response
   */
  public function render(Request $request)
  {
    if ($request->isApi()) {
      return response()->json([
        "error" => "form validation error",
        // "message" => implode('<br>', $this->validator->errors()->all())
        "message" => $this->validator->errors()->all()
      ], $this->code);
    }
    return back()->withErrors($this->validator);
  }
}
