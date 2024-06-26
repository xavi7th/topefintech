<?php

use Paystack\Bank\GetBVN;
use Illuminate\Support\Str;
use Paystack\Bank\ListBanks;
use Illuminate\Http\Response;
use Paystack\Bank\GetCardBIN;
use Paystack\Bank\GetAccountDetails;
use GuzzleHttp\Exception\ClientException;
use Gbowo\Adapter\Paystack\PaystackAdapter;
use Illuminate\Validation\ValidationException;

// if (env('APP_DEBUG')) ini_set('opcache.revalidate_freq', '0');

if (!function_exists('unique_random')) {

  /**
   *
   * Generate a unique random string of characters
   * uses str_random() helper for generating the random string
   *
   * @param string $table - name of the table
   * @param string $col - name of the column that needs to be tested
   * @param string $prefix Any prefix you want to add to generated string
   * @param int $chars - length of the random string
   * @param bool $numeric Whether or not the generated characters should be numeric
   *
   * @return string
   */
  function unique_random($table, $col, $prefix = null, $chars = null, $numeric = false)
  {
    $unique = false;

    // Store tested results in array to not test them again
    $tested = [];

    do {

      // Generate random string of characters

      if ($chars == null) {
        if ($numeric) {
          $random = $prefix . rand(100001, PHP_INT_MAX);
        } else {
          $random = $prefix . Str::uuid();
        }
      } else {
        if ($numeric) {
          $random = $prefix . rand(substr(100000001, 1, ($chars)), substr(9999999999, - ($chars)));
        } else {
          $random = $prefix . Str::random($chars);
        }
      }

      // Check if it's already testing
      // If so, don't query the database again
      if (in_array($random, $tested)) {
        continue;
      }

      // Check if it is unique in the database
      $count = DB::table($table)->where($col, '=', $random)->count();

      // Store the random character in the tested array
      // To keep track which ones are already tested
      $tested[] = $random;

      // String appears to be unique
      if ($count == 0) {
        // Set unique to true to break the loop
        $unique = true;
      }

      // If unique is still false at this point
      // it will just repeat all the steps until
      // it has generated a random string of characters

    } while (!$unique);


    return $random;
  }
}

function unique_random2()
{
  // do {
  //   $token_id = makeRandomToken();
  //   $token_key = makeRandomTokenKey();
  // } while (User::where("token_id", "=", $token_id)->where("token_key", "=", $token_key)->first() instanceof User);
}

if (!function_exists('resolve_debit_card_bin')) {
  /**
   * resolve a debit card BIN (first 6 digits) to get extra details about the card
   * ? This can be useful for determining the validity of the card without prying for personal details
   *
   * @package https://github.com/adelowo/gbowo
   * @package https://paystack.com
   *
   * @param string $card_bin The first 6 digits of a debit card
   *
   * @return object
   **/

  function resolve_debit_card_bin(string $card_bin): object
  {
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new GetCardBIN(PaystackAdapter::API_LINK));

    try {
      $data = $paystack->getCardBIN($card_bin);
    } catch (\Throwable $th) {
      return (object)[
        'code' => $th->getCode(),
        'msg' => $th->getMessage()
      ];
    }
    return (object)$data;
  }
}

if (!function_exists('validate_bank_account')) {
  /**
   * validate a NUBAN Bank Account number that it matches the givem full name
   *
   * @package https://github.com/adelowo/gbowo
   * @package https://paystack.com
   *
   * @param string $acc_num The account number to verify
   * @param string $acc_bank The domiciling bank name
   * @param string $acc_name_to_compare The supplied account name / full name
   *
   * @return object
   **/

  function validate_bank_account(string $acc_num, string $acc_bank, string $acc_name_to_compare): object
  {
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new ListBanks(PaystackAdapter::API_LINK));
    $paystack->addPlugin(new GetAccountDetails(PaystackAdapter::API_LINK));

    /**
     * Get a list of banks supported by paystack
     */
    $banks_list = collect($paystack->listBanks());

    /**
     * Search for the user's bank among the list
     */
    $bank_details = $banks_list->filter(function ($item) use ($acc_bank) {
      return false !== stristr($item['name'], $acc_bank);
    })->first();

    if (is_null($bank_details)) {
      return (object)[
        'code' => 400,
        'msg' => 'Bank not found. Try verifying with an alternate form of your bank\'s name'
      ];
    }

    $bank_object = (object)$bank_details;

    try {
      /**
       * Query for the account number details at the gotten bank
       */
      $data = (object)$paystack->getAccountDetails(["account_number" => $acc_num, "bank_code" => $bank_object->code]);
    } catch (ClientException $th) {
      if ($th->getCode() == 400) {
        return (object)[
          'code' => 400,
          'msg' => $th->getResponse()->getReasonPhrase()
        ];
      } elseif ($th->getCode() == 422) {
        return (object)[
          'code' => 422,
          'msg' => 'Invalid account number'
        ];
      }
    }

    if (Str::containsAll(strtolower($data->account_name), explode(' ', strtolower($acc_name_to_compare)))) {
      return (object)[
        'code' => 200,
        'msg' => 'Bank Account Number Verified'
      ];
    } else {
      return (object)[
        'code' => 409,
        'msg' => 'This bank account number does not match the full name supplied'
      ];
    }

    dd($data);
  }
}

if (!function_exists('validate_bvn_by_phone_number')) {
  /**
   * validate a BVN number that it matches the givem phone number
   *
   * @package https://github.com/adelowo/gbowo
   * @package https://paystack.com
   *
   * @param string $bvn The bvn number to verify
   * @param string $comparison_phone_number The phone number to verify the bvn agaibst
   *
   * @return object
   **/


  function validate_bvn_by_phone_number(string $bvn, string $comparison_phone_number): object
  {
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new GetBVN(PaystackAdapter::API_LINK));

    /**
     * --  SAMPLE RESPONSE FROM ENDPOINT --
     * $rsp = [
     * 	"data" =>  [
     * 		"first_name" => "EHIKIOYA",
     * 		"last_name" => "AKHILE",
     * 		"dob" => "15-Aug-85",
     * 		"formatted_dob" => "1985-08-15",
     * 		"mobile" => "08034411661",
     * 		"bvn" => "22358166951",
     * 	],
     * 	"meta" =>  [
     * 		"calls_this_month" => 5,
     * 		"free_calls_left" => 5,
     * 	]
     * ];
     */


    try {
      $rsp = $paystack->getBVN($bvn);
      $data = (object)$rsp['data'];
    } catch (\Throwable $th) {
      return (object)[
        'code' => $th->getCode(),
        'msg' => $th->getMessage()
      ];
    }

    /**
     * ! Verify via phone number
     */
    if ($data->mobile === get_11_digit_nigerian_number($comparison_phone_number)) {
      return (object)[
        'code' => 200,
        'msg' => 'BVN verified'
      ];
    } else {
      return (object)[
        'code' => 409,
        'msg' => 'BVN supplied does not match supplied phone number.'
      ];
    }
  }
}

if (!function_exists('validate_bvn_by_full_name')) {
  /**
   * validate a BVN number that it matches the givem full name
   *
   * @package https://github.com/adelowo/gbowo
   * @package https://paystack.com
   *
   * @param string $bvn The bvn number to verify
   * @param string $comparison_full_name The full name to verify the bvn agaibst
   *
   * @return object
   **/

  function validate_bvn_by_full_name(string $bvn, string $comparison_full_name): object
  {
    $paystack = new PaystackAdapter();
    $paystack->addPlugin(new GetBVN(PaystackAdapter::API_LINK));

    /**
     * --  SAMPLE RESPONSE FROM ENDPOINT --
     * $rsp = [
     * 	"data" =>  [
     * 		"first_name" => "EHIKIOYA",
     * 		"last_name" => "AKHILE",
     * 		"dob" => "15-Aug-85",
     * 		"formatted_dob" => "1985-08-15",
     * 		"mobile" => "08034411661",
     * 		"bvn" => "22358166951",
     * 	],
     * 	"meta" =>  [
     * 		"calls_this_month" => 5,
     * 		"free_calls_left" => 5,
     * 	]
     * ];
     */


    try {
      $rsp = $paystack->getBVN($bvn);
      $data = (object)$rsp['data'];
    } catch (\Throwable $th) {
      return (object)[
        'code' => $th->getCode(),
        'msg' => $th->getMessage()
      ];
    }

    if (Str::containsAll(strtoupper($comparison_full_name), [$data->first_name, $data->last_name])) {
      return (object)[
        'code' => 200,
        'msg' => 'The BVN is correct'
      ];
    } else {
      return (object)[
        'code' => 409,
        'msg' => 'BVN supplied does not match supplied full name'
      ];
    }
  }
}

if (!function_exists('get_11_digit_nigerian_number')) {
  /**
   * convert a number from international standard to 11 digit number
   *
   * @param float $number The number to convert
   *
   * @return string
   **/

  function get_11_digit_nigerian_number(string $number): string
  {
    return '0' . mb_substr(preg_replace('/(\D+)/i', '', $number), -10);
  }
}

if (!function_exists('to_naira')) {
  /**
   * convert a number to naira with the naira symbol
   *
   * @param float $amount The amount to convert
   *
   * @return string
   **/

  function to_naira(?float $amount): string
  {
    if (is_null($amount)) {
      $amount = 0;
    }
    return '₦' . number_format($amount, 2);
  }
}


if (!function_exists('generate_422_error')) {
  /**
   * Generate a 422 error in a format that axios and sweetalert 2 can display it
   *
   * @param  mixed  $errors An array of errors to display
   * @return Response
   */
  function generate_422_error($errors)
  {
    if (is_array($errors)) {
      throw ValidationException::withMessages($errors)->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    } else {
      if (request()->isApi()) {
        return response()->json([
          'error' => 'form validation error',
          'message' => $errors
        ], 422);
      } else {
        return back()->withFlash(['error' => $errors]);
      }
    }
  }
}

if (!function_exists('str_ordinal')) {
  /**
   * Append an ordinal indicator to a numeric value.
   *
   * @param  string|int $value
   * @param  bool $superscript
   * @return string
   */
  function str_ordinal($value, $superscript = false)
  {
    $number = abs($value);

    if (class_exists('NumberFormatter')) {
      $nf = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
      $ordinalized = $superscript ?
        number_format($number) .
        '<sup>' .
        substr($nf->format($number), -2) .
        '</sup>' : $nf->format($number);

      return $ordinalized;
    }


    $indicators = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

    $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
    if ($number % 100 >= 11 && $number % 100 <= 13) {
      $suffix = $superscript ? '<sup>th</sup>' : 'th';
    }

    return number_format($number) . $suffix;
  }
}

if (!function_exists('get_related_routes')) {
  /**
   * Generate an array of all routes unnder the given namespace that correspond to the provided methods
   *
   * @param  string $namespace
   * @param  array $methods
   * @return \Illuminate\Support\Collection
   *
   * Route::get('/', [BasicSiteController::class, 'index'])->name('app.home')->defaults('nav_skip', true);
   */
  function get_related_routes(string $namespace, array $methods): object
  {
    return collect(\Illuminate\Support\Facades\Route::getRoutes())->map(function (\Illuminate\Routing\Route $route) use ($namespace) {
      return (object)[
        'uri' => $route->uri(),
        'name' => $route->getName(),
        'nav_skip' => $route->defaults['extras']['nav_skip'] ?? false,
        'icon' => $route->defaults['extras']['icon'] ?? null,
        'method' => \Str::of(implode('|', $route->methods())),
        'menu_name' => \Str::of($route->getName())->afterLast('.')->replaceMatches('/[^A-Za-z0-9]++/', ' ')->after($namespace)->title()->trim()->__toString()
      ];
    })->filter(function ($value, $key) use ($methods, $namespace) {
      return \Str::startsWith($value->name, $namespace) && $value->method->contains($methods);
    })->transform(function ($v) {
      return collect($v)->merge(['method' => $v->method->__toString()]);
    });
  }
}


if (!function_exists('get_heirachical_related_routes')) {
  /**
   * Another implementation that can generate an array of all routes unnder the given namespace that correspond to the provided methods for drop down menus
   *
   * @param  string $namespace
   * @param  array $methods
   * @param  bool $isHeirarchical Determines whether to return an array that can be used for drop down mwnus
   * @return array
   *
   * Route::get('/', [BasicSiteController::class, 'index'])->name('app.home')->defaults('extras', ['nav_skip' => false, 'icon' => 'fa fas']);
   */
  function get_heirachical_related_routes(string $namespace, array $methods, bool $isHeirarchical = false): array
  {
    function getHeirachicalRoutes(&$routes)
    {
      $tmp = $routes;
      $routes = [];
      collect($tmp)->map(function ($route, $key) use (&$routes) {
        return $routes[Str::of($key)->after('.')->before('.')->title()->__toString()][] = $route;
      });
      return $routes;
    }

    $routes = collect(\Illuminate\Support\Facades\Route::getRoutes()->getRoutesByName())->filter(function ($value, $key) use ($methods, $namespace) {
      return \Str::startsWith($key, $namespace) && \Str::of(implode('|', $value->methods()))->contains($methods);
    })->map(function (\Illuminate\Routing\Route $route) use ($namespace) {
      return (object)[
        // 'uri' => $route->uri(),
        'name' => $route->getName(),
        'nav_skip' => $route->defaults['extras']['nav_skip'] ?? false,
        'icon' => $route->defaults['extras']['icon'] ?? null,
        'menu_name' => \Str::of($route->getName())->afterLast('.')->replaceMatches('/[^A-Za-z0-9]++/', ' ')->after($namespace)->title()->trim()->__toString()
      ];
    })->reject(function ($val) {
      return $val->nav_skip;
    })->transform(function ($v) {
      return collect($v)->forget('nav_skip');
    })->toArray();

    return $isHeirarchical ? getHeirachicalRoutes($routes) : $routes;
  }
}

if (!function_exists('compress_image_upload')) {

  /**
   * Compress uploaded image files for better optimisation
   *
   * Uses the Intervention library to compress files into the specified size at 85% quality
   *  and optionally create thumbnail images and saves them in the paths provided
   * for the image and the thumbnail. The aspect ration can optionally be maintained
   * returns an array of file names.
   *
   * @param string $key The index name of the file field in the request object
   * @param string $save_path The path to save the compressed image
   * @param string $thumb_path The optional path to save the thumbnail. If provided, thumbnails will be generated
   * @param int $size The size to compress the image into. Defaults to 1400px
   * @param bool $constrain_aspect_ration Boolean value indication whether to constrain the aspect ratio on compression
   *
   * @package \Intervention\Image\Facades\Image
   *
   * composer require intervention/image
   *
   * compress_image_upload('img', 'product_models_images/', 'product_models_images/thumbs/', 800, true, 50)['img_url'],
   *
   * @return array
   **/
  function compress_image_upload(string $key, string $save_path, ?string $thumb_path = null, ?int $size = 1400, ?bool $constrain_aspect_ratio = true, ?int $thumb_size = 200)
  {
    // dd(public_path(Storage::url($save_path)));

    Storage::makeDirectory('public/' . $save_path, 0777);
    Storage::makeDirectory('public/' . $thumb_path, 0777);

    // if ($thumb_path && !File::isDirectory(Storage::url($thumb_path))) {
    //   File::makeDirectory(Storage::url($thumb_path), 0755);
    // }

    $image = Image::make(request()->file($key)->getRealPath());

    if ($constrain_aspect_ratio) {
      $image->resize($size, null, function ($constraint) {
        $constraint->upsize();
        $constraint->aspectRatio();
      })->save(public_path(Storage::url($save_path)) . request()->file($key)->hashName(), 85);

      $url = Storage::url($save_path) . request()->file($key)->hashName();

      if ($thumb_path) {
        $image->resize(null, $thumb_size, function ($constraint) {
          $constraint->upsize();
          $constraint->aspectRatio();
        })->save(public_path(Storage::url($thumb_path)) . request()->file($key)->hashName(), 70);

        $thumb_url = Storage::url($thumb_path) . request()->file($key)->hashName();

        return ['img_url' => $url, 'thumb_url' => $thumb_url];
      }
      return ['img_url' => $url];
    } else {
      $image->resize($size)->save(public_path(Storage::url($save_path)) . request()->file($key)->hashName(), 85);
      $url = Storage::url($save_path) . request()->file($key)->hashName();

      if ($thumb_path) {
        $image->resize($thumb_size)->save(public_path(Storage::url($thumb_path)) . request()->file($key)->hashName(), 70);
        $thumb_url = Storage::url($thumb_path) . request()->file($key)->hashName();

        return ['img_url' => $url, 'thumb_url' => $thumb_url];
      }

      return ['img_url' => $url];
    }
  }
}

if (!function_exists('routeHasRootNamespace')) {
  /**
   * Check if the current route has the provided namespace
   *
   * @param string $namespace
   *
   * @return bool
   */

  function routeHasRootNamespace($namespace = 'app.'): bool
  {
    return Str::startsWith(\Route::currentRouteName(), $namespace);
  }
}
