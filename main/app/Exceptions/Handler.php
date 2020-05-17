<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
  /**
   * A list of the exception types that are not reported.
   *
   * @var array
   */
  protected $dontReport = [
    //
  ];

  /**
   * A list of the inputs that are never flashed for validation exceptions.
   *
   * @var array
   */
  protected $dontFlash = [
    'password',
    'password_confirmation',
  ];

  /**
   * Report or log an exception.
   *
   * @param  \Throwable  $exception
   * @return void
   */
  public function report(Throwable $exception)
  {
    parent::report($exception);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Throwable  $exception
   * @return \Illuminate\Http\Response
   */
  public function render($request, Throwable $exception)
  {
    $response = parent::render($request, $exception);
    if (
      (App::environment('production'))
      && $request->header('X-Inertia')
      && in_array($response->status(), [500, 503, 404, 403])
    ) {
      Inertia::setRootView('publicpages::app');
      return Inertia::render('DisplayError', ['status' => $response->status()])
        ->toResponse($request)
        ->setStatusCode($response->status());
    }
    return $response;
  }
}
