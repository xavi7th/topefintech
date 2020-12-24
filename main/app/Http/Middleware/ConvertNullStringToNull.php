<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertNullStringToNull extends TransformsRequest
{
  private $nullableString = [
    'null', 'Not Provided', 'Not Allocated',
    'not provided', 'not allocated', 'undefined', 'Undefined'
  ];

  /**
   * Transform the given value.
   *
   * @param  string  $key
   * @param  mixed  $value
   * @return mixed
   */
  protected function transform($key, $value)
  {
    return is_string($value) && in_array($value, $this->nullableString) ? null : $value;
  }
}
