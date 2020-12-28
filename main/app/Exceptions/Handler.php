<?php

namespace App\Exceptions;

use Throwable;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
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
   *
   * @throws \Exception
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
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @throws \Throwable
   */
  public function render($request, Throwable $exception)
  {
    //   dd($exception);
    return $response = parent::render($request, $exception);

    if (in_array($response->status(), [500, 503, 404, 403, 429])) {


      /**
       * ! Handle API request errors
       */
      if ($request->isApi()) {
        if ($this->is404($exception)) {
          $this->log404($request);
        }

        return $response;
      }

      try {
        Inertia::setRootView('basicsite::app');
        return Inertia::render('BasicSite,DisplayError', ['status' => $response->status()])
          ->toResponse($request)
          ->setStatusCode($response->status());
      } catch (\Throwable $th) {
        if (app()->environment('local')) {
          dd('Handler Error: ', $th);
        }
      }
    } elseif ($response->status() === 419) {
      return back()->withFlash(['error' => 'The page expired, please try again.',]);
      // throw ValidationException::withMessages(['error' => 'Your session has expired. Please try again'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    return $response;
  }


  /**
   * Get the default context variables for logging.
   *
   * @return array
   */
  protected function context()
  {
    try {
      $context = array_filter([
        'url' => Request::fullUrl(),
        'input' => Request::except(['password', 'password_confirmation'])
      ]);
    } catch (Throwable $e) {
      $context = [];
    }

    return array_merge($context, parent::context());
  }

  private function is404($exception)
  {
    return $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException
      || $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
  }

  private function log404($request)
  {
    $error = [
      'url'    => Request::fullUrl(),
      'method' => $request->method(),
      'data'   => Request::except(['password', 'password_confirmation']),
    ];

    $message = '404: ' . $error['url'] . "\n" . json_encode($error, JSON_PRETTY_PRINT);

    Log::debug($message);
  }
}
