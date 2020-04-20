<?php
use Carbon\Carbon;

use Paystack\Bank\GetBVN;
use Illuminate\Support\Str;
use Paystack\Bank\ListBanks;
use Paystack\Bank\GetCardBIN;
use App\Modules\Admin\Models\ErrLog;
use Paystack\Bank\GetAccountDetails;
use GuzzleHttp\Exception\ClientException;
use Gbowo\Adapter\Paystack\PaystackAdapter;
use League\Flysystem\FileNotFoundException as FileDownloadException;
use Illuminate\Contracts\Filesystem\FileNotFoundException as FileGetException;

// if (env('APP_DEBUG')) ini_set('opcache.revalidate_freq', '0');

/**
 * Custom asset helper to append public/ to all asset generated urls
 *
 * @param string path The path to the asset
 * @param Boolean secure Should https be used explicitly for the path?
 * @return string
 */

function myAsset($path, $secure = null)
{
	return asset('/public/' . trim($path, '/'), $secure);
}

/**
 * Custom Url helper to generate urls using the storage facade
 *
 * @param string path The path to the asset
 * @param Boolean secure Should https be used explicitly for the path?
 * @return string
 */

function img($path, $secure = null)
{
	return Storage::disk('public')->url($path);
}

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
					$random = $prefix . rand(100001, 999999999);
				} else {
					$random = $prefix . Str::uuid();
				}
			} else {
				if ($numeric) {
					$random = $prefix . rand(substr(100000001, 1, ($chars)), substr(9999999999, -($chars)));
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


if (!function_exists('download_file')) {

	/**
	 *
	 * Generate a file download response
	 * uses default filesystems disk
	 *
	 * @param     $file - The file to download
	 * @param     $name_to_use - the name the user sees (optional)
	 *
	 * @return response
	 */
	function download_file($file, $name_to_use = null)
	{
		try {
			return Storage::download($file, $name_to_use);
		} catch (FileGetException $e) {
			abort(404, "Requested file ({$e->getMessage()}) not found");
		} catch (FileDownloadException $e) {
			abort(404, $e->getMessage());
		}
	}
}


if (!function_exists('view_file_in_browser')) {

	/**
	 *
	 * Generate a url redirect response that enables browser to access the file directly
	 * uses a custom filesystems disk that does not append app_url to the url method
	 * Something like this
	 *
	 *      'browser_view' => [
	 *          'driver' => 'local',
	 *          'root' => storage_path('app/public'),
	 *          'url' => '/storage',
	 *          'visibility' => 'public',
	 *      ],
	 *
	 * @param     $file - The file to download
	 *
	 *
	 *
	 * @return redirect response
	 */
	function view_file_in_browser($file)
	{

		try {
			return redirect(Storage::disk('browser_view')->url($file));
		} catch (FileGetException $e) {
			abort(404, "Requested file ({$e->getMessage()}) not found");
		} catch (FileDownloadException $e) {
			abort(404, $e->getMessage());
		}
	}
}



function unique_random2()
{
	do {
		$token_id = makeRandomToken();
		$token_key = makeRandomTokenKey();
	} while (User::where("token_id", "=", $token_id)->where("token_key", "=", $token_key)->first() instanceof User);
}

function mail_utf8($to, $from_user, $from_email, $subject = '(No subject)', $message = '')
{
	$from_user = "=?UTF-8?B?" . base64_encode($from_user) . "?=";
	$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

	$headers = "From: $from_user <$from_email>\r\n" .
		"MIME-Version: 1.0" . "\r\n" .
		"Content-type: text/html; charset=UTF-8" . "\r\n";

	return mail($to, $subject, $message, $headers);
}


function sendmail($data)
{
	$encoding = "utf-8";

	// Preferences for Subject field
	$subject_preferences = array(
		"input-charset" => $encoding,
		"output-charset" => $encoding,
		"line-length" => 76,
		"line-break-chars" => "\r\n"
	);

	// Mail header
	$header = "Content-type: text/html; charset=" . $encoding . " \r\n";
	$header .= "From: " . $from_name . " <" . $from_mail . "> \r\n";
	$header .= "MIME-Version: 1.0 \r\n";
	$header .= "Content-Transfer-Encoding: 8bit \r\n";
	$header .= "Date: " . date("r (T)") . " \r\n";
	$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

	// Send mail
	mail($mail_to, $mail_subject, $mail_message, $header);
}

function mydd(...$args)
{
	$content = "<!DOCTYPE html><html><body>";

	foreach ($args as $arg) {
		$val = (new \Symfony\Component\VarDumper\Cloner\VarCloner)->cloneVar($arg);
		$dumper = new \Illuminate\Support\Debug\HtmlDumper;
		$content .= $dumper->dump($val, true);
	}

	$content .= "</body></html>";

	return response($content, 500)->header('Content-Type', 'text/html')->send();
}

function _dd($args)
{
	http_response_code(500);
	dd($args);
}

if (!function_exists('alt_dd')) {
	function alt_dd(...$data)
	{
		header('HTTP/1.1 500 Internal Server Error');
		call_user_func_array('dd', $data);
	}
}

if (!function_exists('slug_to_string')) {
	function slug_to_string($data)
	{
		str_replace('-', ' ', $data);
	}
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
		return response()->json([
			'error' => 'form validation error',
			'message' => $errors
		], 422);
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
